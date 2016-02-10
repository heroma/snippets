<?php
include_once("includes/classCSV.php");
include_once("includes/classCURL.php");

class HTTPCodesCSV extends CSV{
	
	public function procesaCabeceira($csv, $lineaCSV){
		// Engadir columnas
		array_push($lineaCSV, date("Ymd"));
		fputcsv($csv, $lineaCSV, ";");
	}


	public function procesaLinea($csv, $lineaCSV){
		$cnx = new CURL();
		$code  = "ERRO";
		try{
			// Ler URL da liña do CSV
			$url 	= trim($lineaCSV[0]);
			$param 	= array("url" => $url);

			// Abrir URL 
			$info  = $cnx->open_url($param);	
			$data  = $param[0];


			$code  = $info["http_code"];

		} catch (Exception $e){
			$log = array(
				"data"		=> date("YmdHis"),
				"linea" 	=> json_encode($lineaCSV),
				"excepcion" => $e->getMessage()
			);
			$this -> trace_error($log);
		}
		// finally: engadir columnas ao CSV
		array_push($lineaCSV, $code);	

		//fputcsv — Dar formato CSV a una línea y escribirla en un puntero a un fichero
		fputcsv($csv, $lineaCSV, ";");
	}
}



$miCSV = new HTTPCodesCSV();
$miCSV->run("httpcodes.csv");

?>

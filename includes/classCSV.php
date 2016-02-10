 <?php
class CSV{
	public function procesaCSV($filepath){
		if (($arr = file($filepath)) === false){
			throw new Exception("classCSV.php (5) » Arquivo CSV non existe.");
		}

		// http://php.net/manual/en/function.set-time-limit.php
		// set_time_limit — Limita el tiempo máximo de ejecución deste script ensegundos
		// Tempo máximo de procesado da información estimado en 5 segundos
		set_time_limit(count($arr) * 5);

		// Novo CSV
		$csv = date("Ymd").$filepath;
		$fp = fopen($csv, 'w');

		// Liña de cabeceira
		$linea = explode(",", trim($arr[0]));
		// Engadir columnas ao CSV a continuación:
		$this -> procesaCabeceira($fp, $linea);
		
		// Resto do CSV
		$size = count($arr);
		for($i=1; $i < $size; $i++){
			if (trim(str_replace(",", "", $arr[$i])) != ""){
				// Liña non baleira
				$this -> procesaLinea($fp, explode(",", trim($arr[$i])));
			} 
		}
		fclose($fp);
		return $csv;
	}

	public function procesaCabeceira($csv, $lineaCSV){
		throw new BadFunctionCallException("classCSV.php (35) » Funcionalidade non implementada.");
	}

	public function procesaLinea($csv, $lineaCSV){
		throw new BadFunctionCallException("classCSV.php (39) » Funcionalidade non implementada.");
	}

	public function trace_error($errormsg){
		error_log(print_r($errormsg, true), 3, "erro.log");
	}

	public function run($csv){
		date_default_timezone_set("Europe/Madrid");
		var_dump(new DateTime);
		error_reporting(E_ALL);	
		try{					
			echo "Procesos finalizado en: " . $this -> procesaCSV($csv);
		} catch (Exception $e) {
				$log = array(
					"data"		=> date("YmdHis"),
					"excepcion" => "Execución aboartada » " . $e->getMessage()
				);
				$this -> trace_error($log);
		}
		var_dump(new DateTime);		
	}
}


?>

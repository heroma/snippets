 <?php
 class CURL{
	function open_url(&$param){
		if (!(isset($param["url"]))) {
	    	throw new Exception("classCURL.php(5) » Falta parámetro (url).");
	    }
	    
	    $url = $param["url"];

		$ch = curl_init();
		$timeout = 0;

		//http://php.net/manual/en/function.curl-setopt.php
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array ("charset=iso-8859-1"));
		
		$data = curl_exec($ch);
		
		if($data === false){
			throw new Exception('classCURL.php(27) » ' . curl_error($ch));
		} 

		/*
			$param = {
				"url" => value,
				0 	  => $data
			}

		*/
		array_push($param, $data);

		//http://php.net/manual/en/function.curl-getinfo.php
		$info = curl_getinfo($ch);

		curl_close($ch);

		return $info;
	}	

	public function test_conexionphp(){
		try{
			error_reporting(E_ALL);
			date_default_timezone_set("Europe/Madrid");
			var_dump(new DateTime);
			$param["url"] = $_GET["url"];
			$datos = open_url($param);
			var_dump($param[0]);

			var_dump(new DateTime);
		} catch (Exception $e) {
			$msgerro = "ERRO » " . $e->getMessage() . "\n";
			error_log($msgerro, 3, "erro.log");
		}
	}
 }


?>

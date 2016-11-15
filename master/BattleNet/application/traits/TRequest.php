<?php
trait TRequest {
	
	/**
	 * getDecoded
	 *
	 * json
	 * 
	 * @param string $url
	 * @param string $time
	 *
	 * @return Object
	 */
	private function getDecoded($url, $time) {
	
		$parse = parse_url($url);
		$file = PUBLIC_PATH . '/datas' . rtrim($parse['path'], '/') . '-' . $this->locale . '.json';
		$response = null;
	
		if(!file_exists($file)) {
	
			$opts =
			array(
				'https' =>
					array(
						'method' => 'GET',
						'header' => 'Content-type: application/json' . PHP_EOL .
						'If-Modified-Since: ' . gmdate('D, d M Y H:i:s', 0) . ' GMT'
					)
			);
				
			$context = stream_context_create($opts);
	
			$response = @file_get_contents($url, false, $context);
	
			if($response !== false) {
				
				if($http_response_header[0] == 'HTTP/1.1 200 OK') {
				
					file_put_contents($file, $response);
				
				}
				
			} else {
				
				$response = '{"message": "HTTP/1.1 404 Not Found"}';
			}
				
		} else if((filemtime($file) + $time) < time()) {
	
			$opts =
			array(
				'https' =>
					array(
						'method' => 'GET',
						'header' => 'Content-type: application/json' . PHP_EOL .
						'If-Modified-Since: ' . gmdate('D, d M Y H:i:s', filemtime($file)) . ' GMT'
					)
			);
	
			$context = stream_context_create($opts);
			
			$response = @file_get_contents($url, false, $context);
	
			if($response !== false) {
				
				if($http_response_header[0] == 'HTTP/1.1 200 OK') {
				
					file_put_contents($file, $response);
				
				}
				
			} else {
				
				//Api on maintenance and local file exist
				$response = file_get_contents($file);
			}
	
		} else {
				
			$response = file_get_contents($file);
		}
	
		return json_decode($response);
	}
	
	/**
	 * getDecodedP
	 * 
	 * json p
	 *
	 * @param string $url
	 * @param string $time
	 *
	 * @return string
	 */
	private function getDecodedP($url, $time) {
	
		$parse = parse_url($url);
		$file = PUBLIC_PATH . '/datas' . rtrim($parse['path'], '/') . '-' . $this->locale . '.jsonp';
		$response = null;
	
		if(!file_exists($file)) {
	
			$opts =
			array(
				'https' =>
					array(
						'method' => 'GET',
						'header' => 'Content-type: application/javascript' . PHP_EOL .
						'If-Modified-Since: ' . gmdate('D, d M Y H:i:s', 0) . ' GMT'
					)
			);
	
			$context = stream_context_create($opts);
	
			$response = @file_get_contents($url, false, $context);
	
			if($response !== false) {
				
				if($http_response_header[0] == 'HTTP/1.1 200 OK') {
				
					file_put_contents($file, $response);
				
				}
				
			} else {
				
				$response = 'callback({"message": "HTTP/1.1 404 Not Found"});';
			}
	
		} else if((filemtime($file) + $time) < time()) {
	
			$opts =
			array(
				'https' =>
					array(
						'method' => 'GET',
						'header' => 'Content-type: application/javascript' . PHP_EOL .
						'If-Modified-Since: ' . gmdate('D, d M Y H:i:s', filemtime($file)) . ' GMT'
					)
			);
	
			$context = stream_context_create($opts);
			
			$response = @file_get_contents($url, false, $context);
	
			if($response !== false) {
				
				if($http_response_header[0] == 'HTTP/1.1 200 OK') {
				
					file_put_contents($file, $response);
				
				}
				
			} else {
				
				//Api on maintenance and local file exist
				$response = file_get_contents($file);
			}
			
		} else {
	
			$response = file_get_contents($file);
		}
	
		return $response;
	}
	
	/**
	 * toLink
	 *
	 * @param string $str
	 * 
	 * @return string
	 */
	private function toLink($str) {
		
		$tempStr = $str;
		
		//fake url for php test with filter_var
		$url = 'https://dev.battle.net/';
		
		//Suffisent in some case (utf-8)
		#to lower case + white space and simple quote replaced
		$str = strtolower(str_replace(' ', '-', str_replace('\'', '', $str)));
	
		//Sometimes we need more dealing (utf-8 Europe) @usage filter_var >= PHP 5.2.0
		if(!filter_var($url . $str, FILTER_VALIDATE_URL)) {
	
			#all accented char replaced by its couterpart without
			$str = strtr($str, array('à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'ÿ' => 'y'));
			
			//Sometimes we need even more dealing (Russian chars, Chinese chars,...)
			if(!filter_var($url . $str, FILTER_VALIDATE_URL)) {
					
				$str = urlencode($tempStr);
			}
		}
	
		return $str;
	}
	
	/**
	 * setObjectRoute
	 *
	 * @param string $route
	 * 
	 * @throws InvalidArgumentException
	 */
	private function setRoute($route) {
	
		if(!is_string($route)) {
				
			throw new InvalidArgumentException('route parameter must be a string.');
		}
	
		return $route;
	}
}
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
						'header' => 'Content-type: application/json\r\n' .
						'If-Modified-Since: ' . gmdate('D, d M Y H:i:s', 0) . ' GMT\r\n'
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
						'header' => 'Content-type: application/json\r\n' .
						'If-Modified-Since: ' . gmdate('D, d M Y H:i:s', filemtime($file)) . ' GMT\r\n'
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
						'header' => 'Content-type: application/javascript\r\n' .
						'If-Modified-Since: ' . gmdate('D, d M Y H:i:s', 0) . ' GMT\r\n'
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
						'header' => 'Content-type: application/javascript\r\n' .
						'If-Modified-Since: ' . gmdate('D, d M Y H:i:s', filemtime($file)) . ' GMT\r\n'
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
			
		} else {
	
			$response = readfile($file);
		}
	
		return $response;
	}
	
	/**
	 * toLink
	 * 
	 * @param string $url
	 * @param string $str
	 * 
	 * @return string
	 */
	private function toLink($url, $str) {
		//Suffisent in some case (utf-8)
	
		#to lower case + point and white space and simple quote replaced by hyphens
		$str = strtolower(str_replace('.', '', str_replace(' ', '-', str_replace('\'', '-', $str))));
	
		#replace all hyphen followed by other(s) by only one
		$str = preg_replace('#-+#', '-', $str);
	
		#if first chars is hyphen, remove it
		if($str[0] == '-') {
			$str = substr($str, 1);
		}
	
		# if last chars is hyphen, remove it
		if(substr($str, -1) == '-') {
			$str = substr($str, 0, -1);
		}
	
		//Sometimes we need more dealing (utf-8 US with special chars) @usage filter_var >= PHP 5.2.0
		if(!filter_var($url . $str, FILTER_VALIDATE_URL)) {
	
		#all special chars and eventually typing errors on the keyboard are removed
			$str = strtr($str, array('[' => '-', ']' => '-', '{' => '-', '}' => '-', '(' => '-', ')' => '-', '?' => '-', '!' => '-', '/' => '-', '~' => '-', ',' => '-', ':' => '-', ';' => '-', '+' => '-', '@' => '-', '|' => '-', '&' => '-', '#' => '-', '§' => '-', '^' => '-', '´' => '-', '`' => '-', '*' => '-', '°' => '-', '¨' => '-', '£' => '-', 'µ' => '-', '%' => '-', '<' => '-', '>' => '-', '\\' => '-'));
	
			#replace all hyphens followed by other(s) by only one
			$str = preg_replace('#-+#', '-', $str);
	
			#if first chars is hyphen, remove it
			if($str[0] == '-') {
				$str = substr($str, 1);
			}
	
			# if last chars is hyphen, remove it
			if(substr($str, -1) == '-') {
				$str = substr($str, 0, -1);
			}
	
			//Sometimes we need more dealing (utf-8 Europe)
			if(!filter_var($url . $str, FILTER_VALIDATE_URL)) {
	
				#all accented char replaced by its couterpart without
				$str = strtr($str, array('à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'ÿ' => 'y'));
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
	
		if(!filter_var($route, FILTER_VALIDATE_URL)) {
				
			throw new InvalidArgumentException('route must be a valid wow api url');
		}
	
		return $route;
	}
}
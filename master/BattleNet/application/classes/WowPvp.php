<?php
class WowPvp implements IWowPvp {
	
	use TRequest {
		#overloaded here
		getDecoded as gd;
		getDecodedP as gdp;
	}
	
	private $locale = null;
	private $bracket = null;
	private $route = null;
	private $brackets = array('2v2', '3v3', '5v5', 'rbg');
	
	function __construct($bracket, $locale) {
		
		$this->setLocale($locale);
		$this->setBracket($bracket);
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowPvp::ROUTE . $this->bracket . '?locale=' . $this->locale . '&apikey=' . API_KEY);
	}
	
	/**
	 * setBracket
	 * 
	 * @param string $bracket
	 * 
	 * @throws InvalidArgumentException
	 */
	private function setBracket($bracket) {
		
		if(is_string($bracket) && self::isValid($bracket)) {
			
			$this->bracket = $bracket;
			
			return;
		}
		
		throw new InvalidArgumentException('bracket parameter must be a string and must be a valid bracket: ' . implode(', ', $this->brackets));
	}
	
	private function isValid($bracket) {
		
		return in_array($bracket, $this->brackets);
	}
	
	/**
	 * setLocale
	 * 
	 * @param string $locale
	 * 
	 * @throws InvalidArgumentException
	 */
	private function setLocale($locale) {
		
		if(is_string($locale)) {
			
			$this->locale = $locale;
			
			return;
		}
		
		throw new InvalidArgumentException('locale parameter must be a string');
	}
	
	/**
	 * json
	 * 
	 * @return Object
	 */
	public function json() {
		
		return $this->getDecoded($this->route, IWowPvp::TIMER);
	}
	
	/**
	 * jsonp
	 * 
	 * @return Object
	 */
	public function jsonp() {
	
		$this->route .= '&jsonp=callback';
		
		return $this->getDecodedP($this->route, IWowPvp::TIMER);
	}
	
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
		$file = PUBLIC_PATH . '/datas' . $parse['path'] . '-' . $this->locale . '.json';
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
		$file = PUBLIC_PATH . '/datas' . $parse['path'] . '-' . $this->locale . '.jsonp';
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
				
				//Api on maintenance and local file exist
				$response = readfile($file);
			}
			
		} else {
	
			$response = readfile($file);
		}
	
		return $response;
	}
}
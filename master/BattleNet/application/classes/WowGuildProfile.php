<?php
class WowGuildProfile implements IWowGuildProfile {

	use TRequest {
		#overloaded here
		getDecoded as gd;
		getDecodedP as gdp;
	}

	private $locale = null;
	private $realm = null;
	private $guild = null;
	private $route = null;
	private $fields = 'achievements, challenge, members, news';


	function __construct($realm, $guild, $locale) {

		$this->setLocale($locale);
		$this->setRealm($realm);
		$this->setGuild($guild);
		$this->setFields($this->fields);
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowGuildProfile::ROUTE . $this->realm . '/' . $this->guild . '?locale=' . $this->locale . '&fields=' . $this->fields . '&apikey=' . API_KEY);
	}

	/**
	 * setRealm
	 *
	 * @param string $realm
	 *
	 * @throws InvalidArgumentException
	 */
	private function setRealm($realm) {

		if(is_string($realm)) {
				
			$this->realm = $this->toLink(unserialize(API_LINKS)[$this->locale] . IWowGuildProfile::ROUTE, $realm);
				
			return;
		}

		throw new InvalidArgumentException('realm parameter must be a string');
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
	 * setGuild
	 *
	 * @param string $guild
	 *
	 * @throws InvalidArgumentException
	 */
	private function setGuild($guild) {
	
		if(is_string($guild)) {
	
			$this->guild = $this->toLink(unserialize(API_LINKS)[$this->locale] . IWowGuildProfile::ROUTE, $guild);
	
			return;
		}
	
		throw new InvalidArgumentException('guild parameter must be a string');
	}
	
	/**
	 * setFields
	 * 
	 * @param string $fields
	 */
	private function setFields($fields) {
		
		$this->fields = urlencode($fields);
	}

	/**
	 * json
	 *
	 * @return Object
	 */
	public function json($type = 'full') {

		switch ($type) {
			
			case('full'):
			default:
				
				return self::getDecoded($this->route, IWowGuildProfile::TIMER);
					
			break;
			
			case('achievements'):
				
				$json = self::getDecoded($this->route, IWowGuildProfile::TIMER);
			
				return $json->achievements;
				
			break;
			
			case('challenge'):
			
				$json = self::getDecoded($this->route, IWowGuildProfile::TIMER);
					
				return $json->challenge;
			
			break;
			
			case('members'):
					
				$json = self::getDecoded($this->route, IWowGuildProfile::TIMER);
					
				return $json->members;
					
			break;
			
			case('news'):
					
				$json = self::getDecoded($this->route, IWowGuildProfile::TIMER);
					
				return $json->news;
					
			break;
		}
	}

	/**
	 * jsonp
	 *
	 * @return Object
	 */
	public function jsonp($type = 'full') {

	switch ($type) {
			
			case('full'):
			default:
				
				return self::getDecodedP($this->route, IWowGuildProfile::TIMER);
					
			break;
			
			case('achievements'):
				
				$json = self::getDecoded($this->route, IWowGuildProfile::TIMER);
			
				return 'callback(' . json_encode($json->achievements) . ');';
				
			break;
			
			case('challenge'):
			
				$json = self::getDecoded($this->route, IWowGuildProfile::TIMER);
					
				return 'callback(' . json_encode($json->challenge) . ');';
			
			break;
			
			case('members'):
					
				$json = self::getDecoded($this->route, IWowGuildProfile::TIMER);
					
				return 'callback(' . json_encode($json->members) . ');';
					
			break;
			
			case('news'):
					
				$json = self::getDecoded($this->route, IWowGuildProfile::TIMER);
					
				return 'callback(' . json_encode($json->news) . ');';
					
			break;	
		}
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
		$path = PUBLIC_PATH . '/datas' . $parse['path'];
		
		if (!is_dir($path)) {
			mkdir($path, 755, true);
		}
		
		$file = PUBLIC_PATH . '/datas' . $parse['path'] . '/std-' .$this->locale . '.json';
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
	
			$response = @file_get_contents($this->route, false, $context);
			
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
						'header' => 'Content-type: application/json\r\n' .
						'If-Modified-Since: ' . gmdate('D, d M Y H:i:s', filemtime($file)) . ' GMT\r\n'
					)
			);
	
			$context = stream_context_create($opts);
	
			$response = @file_get_contents($this->route, false, $context);
			
			if($response !== false) {
	
				if($http_response_header[0] == 'HTTP/1.1 200 OK') {
	
					file_put_contents($file, $response);
				}
	
			} else {
	
				$response = 'callback({"message": "HTTP/1.1 404 Not Found"});';
			}
	
		} else {
	
			$response = file_get_contents($file);
		}
	
		return json_decode($response);
	}
	
	/**
	 * getDecodedP
	 *
	 * jsonp
	 *
	 * @param string $url
	 * @param string $time
	 *
	 * @return string
	 */
	private function getDecodedP($url, $time) {
	
		$parse = parse_url($url);
		$path = PUBLIC_PATH . '/datas' . $parse['path'];
		
		if (!is_dir($path)) {
			mkdir($path, 755, true);
		}
		
		$file = PUBLIC_PATH . '/datas' . $parse['path'] . '/std-' . $this->locale . '.jsonp';
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
	
			$response = @file_get_contents($this->route, false, $context);
			
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
	
			$response = @file_get_contents($this->route, false, $context);
			
			if($response !== false) {
	
				if($http_response_header[0] == 'HTTP/1.1 200 OK') {
	
					file_put_contents($file, $response);
				}
	
			} else {
	
				$response = 'callback({"message": "HTTP/1.1 404 Not Found"});';
			}
				
		} else {
	
			$response = file_get_contents($file);
		}
	
		return $response;
	}
}
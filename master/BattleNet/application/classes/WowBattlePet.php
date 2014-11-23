<?php
class WowBattlePet implements IWowBattlePet {

	use TRequest {
		#overloaded here
		getDecoded as gd;
		getDecodedP as gdp;
	}

	private $locale = null;
	private $id = null;
	private $route = null;

	function __construct($locale) {

		$this->setLocale($locale);
	}
	
	/**
	 * setId
	 *
	 * @param int $id
	 *
	 * @throws InvalidArgumentException
	 */
	private function setId($id) {
	
		if(is_int($id)) {
				
			$this->id = $id;
				
			return;
		}
	
		throw new InvalidArgumentException('id parameter must be an integer');
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
	 * species
	 * 
	 * @param integer $id
	 * 
	 * @return WowBattlePet
	 */
	public function species($id, $level = 1, $breadId = 3, $qualityId = 1) {
	
		$this->setId($id);
		
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowBattlePet::ROUTE_ABILITY . $this->id . '?locale=' . $this->locale . '&apikey=' . API_KEY);
	
		$this->route .= '&level=' . $level;
		
		$this->route .= '&breadId=' . $breadId;
		
		$this->route .= '&qualityId=' . $qualityId;
		
		return $this;
	}
	
	/**
	 * ability
	 * 
	 * @param integer $id
	 * 
	 * @return WowBattlePet
	 */
	public function ability($id, $level = 1, $breadId = 3, $qualityId = 1) {
	
		$this->setId($id);
		
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowBattlePet::ROUTE_ABILITY . $this->id . '?locale=' . $this->locale . '&apikey=' . API_KEY);
	
		$this->route .= '&level=' . $level;
		
		$this->route .= '&breadId=' . $breadId;
		
		$this->route .= '&qualityId=' . $qualityId;
		
		return $this;
	}
	
	/**
	 * stats
	 * 
	 * @param integer $id
	 * @param integer $level
	 * @param integer $breadId
	 * @param integer $qualityId
	 * 
	 * @return WowBattlePet
	 */
	public function stats($id, $level = 1, $breadId = 3, $qualityId = 1) {
	
		$this->setId($id);
		
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowBattlePet::ROUTE_STATS . $this->id . '?locale=' . $this->locale . '&apikey=' . API_KEY);
	
		$this->route .= '&level=' . $level;
		
		$this->route .= '&breadId=' . $breadId;
		
		$this->route .= '&qualityId=' . $qualityId;
		
		return $this;
	}

	/**
	 * getJson
	 *
	 * @return Object
	 */
	public function json() {

		return self::getDecoded($this->route, IWowBattlePet::TIMER);
	}

	/**
	 * getJsonP
	 *
	 * @return Object
	 */
	public function jsonp() {

		$this->route .= '&jsonp=callback';

		return self::getDecodedP($this->route, IWowBattlePet::TIMER);
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
		$tmp = parse_url($url, PHP_URL_QUERY);
		parse_str($tmp, $attrs);
		
		$path = PUBLIC_PATH . '/datas' . $parse['path'] . '/' . $attrs['qualityId'] . '/' .$attrs['level'];
		$file = $path . '/' . $attrs['breadId'] . '-' . $this->locale . '.json';
		$response = null;
		
		if (!is_dir($path)) {
			mkdir($path, 755, true);
		}
	
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
		$tmp = parse_url($url, PHP_URL_QUERY);
		parse_str($tmp, $attrs);
		
		$path = PUBLIC_PATH . '/datas' . $parse['path'] . '/' . $attrs['qualityId'] . '/' .$attrs['level'];
		$file = $path . '/' . $attrs['breadId'] . '-' . $this->locale . '.jsonp';
		$response = null;
		
		if (!is_dir($path)) {
			mkdir($path, 755, true);
		}
	
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
	
			$response = file_get_contents($file);
		}
	
		return $response;
	}
}
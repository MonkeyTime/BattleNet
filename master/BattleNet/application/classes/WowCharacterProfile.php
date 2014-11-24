<?php
class WowCharacterProfile implements IWowCharacterProfile {

	use TRequest {
		#overloaded here
		getDecoded as gd;
		getDecodedP as gdp;
	}

	private $locale = null;
	private $realm = null;
	private $character = null;
	private $route = null;
	private $fields = 'achievements, appearance, feed, guild, hunterPets, items, mounts, pets, petSlots, progression, pvp, quests, reputation, stats, talents, titles, audit';


	function __construct($realm, $character, $locale) {

		$this->setLocale($locale);
		$this->setRealm($realm);
		$this->setCharacter($character);
		$this->setFields($this->fields);
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowCharacterProfile::ROUTE . $this->realm . '/' . $this->character . '?locale=' . $this->locale . '&fields=' . $this->fields . '&apikey=' . API_KEY);
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
				
			$this->realm = $this->toLink($realm);
				
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
	 * setCharacter
	 *
	 * @param string $character
	 *
	 * @throws InvalidArgumentException
	 */
	private function setCharacter($character) {
	
		if(is_string($character)) {
	
			$this->character = urlencode($character);
	
			return;
		}
	
		throw new InvalidArgumentException('character parameter must be a string');
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
				
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
				
				return isset($json) ? $json : null;
					
			break;
			
			case('achievements'):
				
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
			
				return isset($json->achievements) ? $json->achievements : null;
				
			break;
			
			case('appearance'):
			
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->appearance) ? $json->appearance : null;
			
			break;
			
			case('feed'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->feed) ? $json->feed : null;
					
			break;
			
			case('guild'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->guild) ? $json->guild : null;
					
			break;
			
			case('hunterPets'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->hunterPets) ? $json->hunterPets : null;
					
			break;
			
			case('items'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->items) ? $json->items : null;
					
			break;
			
			case('mounts'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->mounts) ? $json->mounts : null;
					
			break;
			
			case('pets'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->pets) ? $json->pets : null;
					
			break;
			
			case('petSlots'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->petSlots) ? $json->petSlots : null;
					
			break;
			
			case('progression'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->progression) ? $json->progression : null;
					
			break;
			
			case('pvp'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->pvp) ? $json->pvp : null;
					
			break;
			
			case('quests'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->quests) ? $json->quests : null;
					
			break;
			
			case('reputation'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->reputation) ? $json->reputation : null;
					
			break;
			
			case('stats'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->stats) ? $json->stats : null;
					
			break;
			
			case('talents'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->talents) ? $json->talents : null;
					
			break;
			
			case('titles'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->titles) ? $json->titles : null;
					
			break;
			
			case('audit'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->audit) ? $json->audit : null;
					
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
				
				$json = self::getDecodedP($this->route, IWowCharacterProfile::TIMER);
				
				return isset($json) ? 'callback(' . $json . ');' : null;
					
			break;
			
			case('achievements'):
				
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
			
				return isset($json->achievements) ? 'callback(' . json_encode($json->achievements) . ');' : null;
				
			break;
			
			case('appearance'):
			
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->appearance) ? 'callback(' . json_encode($json->appearance) . ');' : null;
			
			break;
			
			case('feed'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->feed) ? 'callback(' . json_encode($json->feed) . ');' : null;
					
			break;
			
			case('guild'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->guild) ? 'callback(' . json_encode($json->guild) . ');' : null;
					
			break;
			
			case('hunterPets'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->hunterPets) ? 'callback(' . json_encode($json->hunterPets) . ');' : null;
					
			break;
			
			case('items'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->items) ? 'callback(' . json_encode($json->items) . ');' : null;
					
			break;
			
			case('mounts'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->mounts) ? 'callback(' . json_encode($json->mounts) . ');' : null;
					
			break;
			
			case('pets'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->pets) ? 'callback(' . json_encode($json->pets) . ');' : null;
					
			break;
			
			case('petSlots'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->petSlots) ? 'callback(' . json_encode($json->petSlots) . ');' : null;
					
			break;
			
			case('progression'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->progression) ? 'callback(' . json_encode($json->progression) . ');' : null;
					
			break;
			
			case('pvp'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->pvp) ? 'callback(' . json_encode($json->pvp) . ');' : null;
					
			break;
			
			case('quests'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->quests) ? 'callback(' . json_encode($json->quests) . ');' : null;
					
			break;
			
			case('reputation'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->reputation) ? 'callback(' . json_encode($json->reputation) . ');' : null;
					
			break;
			
			case('stats'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->stats) ? 'callback(' . json_encode($json->stats) . ');': null;
					
			break;
			
			case('talents'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->talents) ? 'callback(' . json_encode($json->talents) . ');' : null;
					
			break;
			
			case('titles'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->titles) ? 'callback(' . json_encode($json->titles) . ');' : null;
					
			break;
			
			case('audit'):
					
				$json = self::getDecoded($this->route, IWowCharacterProfile::TIMER);
					
				return isset($json->audit) ? 'callback(' . json_encode($json->audit) . ');' : null;
					
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
		
		$file = PUBLIC_PATH . '/datas' . $parse['path'] . '/std-' . $this->locale . '.json';
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
		#$tmp = parse_url($url, PHP_URL_QUERY);
		#parse_str($tmp, $attrs);
		
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
<?php
class WowChallengeMode implements IWowChallengeMode {

	use TRequest {
		#overloaded here and also in use here
		getDecoded as gd;
		getDecodedP as gdp;
	}

	private $locale = null;
	private $realm = null;
	private $route = null;

	function __construct($locale) {

		$this->setLocale($locale);
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
	 * realmLeaderboard
	 *
	 * @param string $realm
	 *
	 * @return WowChallengeMode
	 */
	public function realmLeaderboard($realm) {
	
		$this->setRealm($realm);
	
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowChallengeMode::ROUTE_REALM . $this->realm . '?locale=' . $this->locale . '&apikey=' . API_KEY);
		
		return $this;
	}
	
	/**
	 * regionLeaderboard
	 *
	 * @return WowChallengeMode
	 */
	public function regionLeaderboard() {
	
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowChallengeMode::ROUTE_REGION . '?locale=' . $this->locale . '&apikey=' . API_KEY);
	
		return $this;
	}
	
	/**
	 * json
	 *
	 * @return Object
	 */
	public function json() {
		
		if(preg_match('#/region#', $this->route)) {
			
			return self::getDecoded($this->route, IWowChallengeMode::TIMER);
		}
		
		return $this->gd($this->route, IWowChallengeMode::TIMER);
	}
	
	/**
	 * jsonp
	 *
	 * @return Object
	 */
	public function jsonp() {
	
		$this->route .= '&jsonp=callback';
		
		if(preg_match('#/region#', $this->route)) {
				
			return self::getDecodedP($this->route, IWowChallengeMode::TIMER);
		}
	
		return $this->gdp($this->route, IWowChallengeMode::TIMER);
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
		$host = $parse['host'];
		
		if(strpos('us.api.battle.net', $host) !== false) {
			$region = 'us';
		}
		elseif(strpos('eu.api.battle.net', $host) !== false) {
			$region = 'eu';
		}
		elseif(strpos('tw.api.battle.net', $host) !== false) {
			$region = 'tw';
		}
		elseif(strpos('kr.api.battle.net', $host) !== false) {
			$region = 'kr';
		}
		elseif(strpos('www.battlenet.com.cn', $host) !== false) {
			$region = 'cn';
		}
		else {
			throw new InvalidArgumentException('url parameter must contain a valid region url');
		}
		
		$file = PUBLIC_PATH . '/datas' . $parse['path'] . '/' . $region . '-' . $this->locale . '.json';
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
	 * jsonp
	 *
	 * @param string $url
	 * @param string $time
	 *
	 * @return string
	 */
	private function getDecodedP($url, $time) {
	
		$parse = parse_url($url);
		$host = $parse['host'];
		
		if(strpos('us.api.battle.net', $host) !== false) {
			$region = 'us';
		}
		elseif(strpos('eu.api.battle.net', $host) !== false) {
			$region = 'eu';
		}
		elseif(strpos('tw.api.battle.net', $host) !== false) {
			$region = 'tw';
		}
		elseif(strpos('kr.api.battle.net', $host) !== false) {
			$region = 'kr';
		}
		elseif(strpos('www.battlenet.com.cn', $host) !== false) {
			$region = 'cn';
		}
		else {
			throw new InvalidArgumentException('url parameter must contain a valid region url');
		}
		
		$file = PUBLIC_PATH . '/datas' . $parse['path'] . '/' . $region . '-' . $this->locale . '.jsonp';
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
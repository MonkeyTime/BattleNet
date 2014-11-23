<?php
class WowRealmStatus implements IWowRealmStatus {
	
	use TRequest;
	
	private $locale = null;
	private $realms = null;
	private $route = null;
	
	function __construct($realms = '', $locale) {
		
		$this->setLocale($locale);
		$this->setRealms($realms);
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowRealmStatus::ROUTE . '?locale=' . $this->locale . ($realms != '' ? '&realms=' . $this->realms : '') . '&apikey=' . API_KEY);
	}
	
	/**
	 * setRealms
	 * 
	 * @param string $bracket
	 * 
	 * @throws InvalidArgumentException
	 */
	private function setRealms($realms) {
		
		if(is_string($realms)) {
			
			$this->realms = urlencode($realms);
			
			return;
		}
		
		throw new InvalidArgumentException('bracket parameter must be a string and must be a valid bracket: ' . implode(', ', $this->brackets));
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
		
		return $this->getDecoded($this->route, IWowRealmStatus::TIMER);
	}
	
	/**
	 * jsonp
	 * 
	 * @return Object
	 */
	public function jsonp() {
	
		$this->route .= '&jsonp=callback';
		
		return $this->getDecodedP($this->route, IWowRealmStatus::TIMER);
	}
}
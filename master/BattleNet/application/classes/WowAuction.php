<?php
class WowAuction implements IWowAuction {
		
	use TRequest;
	
	private $locale = null;
	private $realm = null;	
	private $route = null;

	
	function __construct($realm, $locale) {
	
		$this->setLocale($locale);
		$this->setRealm($realm);
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowAuction::ROUTE . $this->realm . '?locale=' . $this->locale . '&apikey=' . API_KEY);
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
			
			$this->realm = $this->toLink(unserialize(API_LINKS)[$this->locale] . IWowAuction::ROUTE, $realm);
			
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
	 * getJson
	 * 
	 * @return Object
	 */
	public function json() {
		
		return $this->getDecoded($this->route, IWowAchievement::TIMER);
	}
	
	/**
	 * getJsonP
	 * 
	 * @return Object
	 */
	public function jsonp() {
		
		$this->route .= '&jsonp=callback';
		
		return $this->getDecodedP($this->route, IWowAchievement::TIMER);
	}
}
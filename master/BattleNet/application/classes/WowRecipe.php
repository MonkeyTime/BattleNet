<?php

class WowRecipe implements IWowRecipe {
	
	use TRequest;
	
	private $locale = null;
	private $id = null;
	private $route = null;
	
	function __construct($id, $locale) {
	
		$this->setLocale($locale);
		$this->setId($id);
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowRecipe::ROUTE . $this->id . '?locale=' . $this->locale . '&apikey=' . API_KEY);
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
	 * getJson
	 *
	 * @return Object
	 */
	public function json() {
	
		return $this->getDecoded($this->route, IWowRecipe::TIMER);
	}
	
	/**
	 * getJsonP
	 *
	 * @return Object
	 */
	public function jsonp() {
	
		$this->route .= '&jsonp=callback';
	
		return $this->getDecodedP($this->route, IWowRecipe::TIMER);
	}
}
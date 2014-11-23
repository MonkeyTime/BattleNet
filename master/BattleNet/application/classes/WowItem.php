<?php
class WowItem implements IWowItem {
	
	use TRequest;

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
	 * @return WowItem
	 */
	public function item($id) {
	
		$this->setId($id);
	
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowItem::ROUTE_ITEM . $this->id . '?locale=' . $this->locale . '&apikey=' . API_KEY);
	
		return $this;
	}
	
	/**
	 * ability
	 *
	 * @param integer $id
	 *
	 * @return WowItem
	 */
	public function set($id) {
	
		$this->setId($id);
	
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowItem::ROUTE_SET . $this->id . '?locale=' . $this->locale . '&apikey=' . API_KEY);
		
		return $this;
	}
	
	/**
	 * json
	 *
	 * @return Object
	 */
	public function json() {
	
		return $this->getDecoded($this->route, IWowItem::TIMER);
	}
	
	/**
	 * jsonp
	 *
	 * @return Object
	 */
	public function jsonp() {
	
		$this->route .= '&jsonp=callback';
	
		return $this->getDecodedP($this->route, IWowItem::TIMER);
	}
	}
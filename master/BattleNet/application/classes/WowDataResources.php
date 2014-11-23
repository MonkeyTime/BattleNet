<?php
class WowDataResources implements IWowDataResourses {
	
	use TRequest;
	
	private $locale = null;
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
	 * battlegroups
	 *
	 * @return WowDataResourses
	 */
	public function battlegroups() {
	
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowDataResourses::ROUTE_BATTLEGROUPS . '?locale=' . $this->locale . '&apikey=' . API_KEY);
	
		return $this;
	}
	
	/**
	 * characterRaces
	 *
	 * @return WowDataResourses
	 */
	public function characterRaces() {
	
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowDataResourses::ROUTE_CHARACTER_RACES . '?locale=' . $this->locale . '&apikey=' . API_KEY);
	
		return $this;
	}
	
	/**
	 * characterClasses
	 *
	 * @return WowDataResourses
	 */
	public function characterClasses() {
	
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowDataResourses::ROUTE_CHARACTER_CLASSES . '?locale=' . $this->locale . '&apikey=' . API_KEY);
	
		return $this;
	}
	
	/**
	 * characterAchievements
	 *
	 * @return WowDataResourses
	 */
	public function characterAchievements() {
	
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowDataResourses::ROUTE_CHARACTER_ACHIEVEMENTS . '?locale=' . $this->locale . '&apikey=' . API_KEY);
	
		return $this;
	}
	
	/**
	 * guildRewards
	 *
	 * @return WowDataResourses
	 */
	public function guildRewards() {
	
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowDataResourses::ROUTE_GUILD_REWARDS . '?locale=' . $this->locale . '&apikey=' . API_KEY);
	
		return $this;
	}
	
	/**
	 * guildPerks
	 *
	 * @return WowDataResourses
	 */
	public function guildPerks() {
	
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowDataResourses::ROUTE_GUILD_PERKS . '?locale=' . $this->locale . '&apikey=' . API_KEY);
	
		return $this;
	}
	
	/**
	 * guildAchievements
	 *
	 * @return WowDataResourses
	 */
	public function guildAchievements() {
	
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowDataResourses::ROUTE_GUILD_ACHIEVEMENTS . '?locale=' . $this->locale . '&apikey=' . API_KEY);
	
		return $this;
	}
	
	/**
	 * itemClasses
	 *
	 * @return WowDataResourses
	 */
	public function itemClasses() {
	
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowDataResourses::ROUTE_ITEM_CLASSES . '?locale=' . $this->locale . '&apikey=' . API_KEY);
	
		return $this;
	}
	
	/**
	 * talents
	 *
	 * @return WowDataResourses
	 */
	public function talents() {
	
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowDataResourses::ROUTE_TALENTS . '?locale=' . $this->locale . '&apikey=' . API_KEY);
	
		return $this;
	}
	
	/**
	 * petTypes
	 *
	 * @return WowDataResourses
	 */
	public function petTypes() {
	
		$this->route = $this->setRoute(unserialize(API_LINKS)[$this->locale] . IWowDataResourses::ROUTE_PET_TYPES . '?locale=' . $this->locale . '&apikey=' . API_KEY);
	
		return $this;
	}
	
	/**
	 * json
	 *
	 * @return Object
	 */
	public function json() {
	
		return $this->getDecoded($this->route, IWowDataResourses::TIMER);
	}
	
	/**
	 * jsonp
	 *
	 * @return Object
	 */
	public function jsonp() {
	
		$this->route .= '&jsonp=callback';
	
		return $this->getDecodedP($this->route, IWowDataResourses::TIMER);
	}
}
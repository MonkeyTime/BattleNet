<?php

class ApiWoW {
	
	private $locale = null;
	
	/**
	 * Constructor
	 * 
	 */
	public function __construct() {}
	
	/**
	 * setLocale
	 * 
	 * @param string $locale
	 * 
	 * @throws InvalidArgumentException
	 * 
	 * @return void
	 */
	public function setLocale($locale) {
		
		if(is_string($locale) && in_array($locale, unserialize(API_LOCALES))) {
			
			$this->locale = $locale;
			
			return;
		}
		
		throw new InvalidArgumentException('locale parameter must be a string and must be a valid locale: ' . implode(', ', unserialize(API_LOCALES)));
	}
	
	/**
	 * getAchievement
	 * 
	 * After this init you have access to all methods from Achievement class.
	 * 
	 * @param int $id
	 * 
	 * @throws InvalidArgumentException
	 * 
	 * @return WowAchievement
	 */
	public function getAchievement($id) {
		
		if($this->locale == null) {
		
			throw new Exception('You must use setLocale() before using getAchievement($id) Api');
		}
	
		if(is_int($id)) {
			
			return new WowAchievement($id, $this->locale);
		}
		
		throw new InvalidArgumentException('id parameter must be an integer');
	}
	
	/**
	 * getAuction
	 * 
	 * After this init you have access to all methods from Auction class.
	 *
	 * @param string $realm
	 * 
	 * @throws InvalidArgumentException
	 * 
	 * @return WowAuction
	 */
	public function getAuction($realm) {
		
		if(is_string($realm)) {
			
			return new WowAuction($realm, $this->locale);
		}
			
		throw new InvalidArgumentException('realm parameter must be a string');
	}
	
	
	/**
	 * getBattlePet
	 * 
	 * After this init you have access to all methods from BattlePet class.
	 *
	 * @return WowBattlePet
	 */
	public function getBattlePet() {
		
		if($this->locale == null) {
		
			throw new Exception('You must use setLocale() before using getBattlePet() Api');
		}
		
		return new WowBattlePet($this->locale);
	}
	
	/**
	 * getChallengeMode
	 * 
	 * After this init you have access to all methods from ChallengeMode class.
	 *
	 * @return ChallengeMode
	 */
	public function getChallengeMode() {
	
		if($this->locale == null) {
		
			throw new Exception('You must use setLocale() before using getChallengeMode() Api');
		}
		
		return new WowChallengeMode($this->locale);
	}
	
	/**
	 * getCharacterProfile
	 * 
	 * After this init you have access to all methods from CharacterProfile class.
	 *
	 * @param string $realm
	 * @param string $name
	 * 
	 * @throws InvalidArgumentException
	 * 
	 * @return CharacterProfile
	 */
	public function getCharacterProfile($realm, $name) {
		
		if(is_string($realm) and is_string($name)) {
			
			return new WowCharacterProfile($realm, $name, $this->locale);
		}
		
		throw new InvalidArgumentException('realm and name parameters must be strings');
	}
	
	/**
	 * getItem
	 * 
	 * After this init you have access to all methods from Item class.
	 *
	 * @param int $id
	 * 
	 * @return Item
	 */
	public function getItem() {
		
		if($this->locale == null) {
		
			throw new Exception('You must use setLocale() before using getItem() Api');
		}
	
		return new WowItem($this->locale);
	}
	
	/**
	 * getGuildProfile
	 * 
	 * After this init you have access to all methods from GuildProfile class.
	 *
	 * @param string $realm
	 * @param string $name
	 * 
	 * @throws InvalidArgumentException
	 * 
	 * @return GuildProfile
	 */
	public function getGuildProfile($realm, $name) {
		
		if(is_string($realm) and is_string($name)) {
				
			return new WowGuildProfile($realm, $name, $this->locale);
		}
		
		throw new InvalidArgumentException('realm and name parameters must be strings');
		
	}
	
	/**
	 * getPvp
	 * 
	 * After this init you have access to all methods from Pvp class.
	 *
	 * @param string $bracket	A valid braket 2v2, 3v3, 5v5, rbg
	 * 
	 * @throws InvalidArgumentException
	 * 
	 * @return Pvp
	 */
	public function getPvp($bracket) {
		
		if($this->locale == null) {
		
			throw new Exception('You must use setLocale() before using getPvp($bracket) Api');
		}
		
		if(is_string($bracket)) {
		
			return new WowPvp($bracket, $this->locale);
		}
		
		throw new InvalidArgumentException('bracket parameter must be a string');
	}
	
	/**
	 * getQuest
	 * 
	 * After this init you have access to all methods from Quest class.
	 *
	 * @param int $id
	 * 
	 * @throws InvalidArgumentException
	 * 
	 * @return Quest
	 */
	public function getQuest($id) {
		
		if($this->locale == null) {
		
			throw new Exception('You must use setLocale() before using getQuest($id) Api');
		}
		
		if(is_int($id)) {
		
			return new WowQuest($id, $this->locale);
		}
		
		throw new InvalidArgumentException('id parameter must be an integer');
	}
	
	/**
	 * getRealmStatus
	 * 
	 * After this init you have access to all methods from RealmStatus class.
	 *
	 * @return RealmStatus
	 */
	public function getRealmStatus($realms = '') {
		
		if($this->locale == null) {
		
			throw new Exception('You must use setLocale() before using getRealmStatus() Api');
		}
		
		return new WowRealmStatus($realms, $this->locale);
	}
	
	/**
	 * getRecipe
	 * 
	 * After this init you have access to all methods from Recipe.
	 *
	 * @param int $id
	 * 
	 * @throws InvalidArgumentException
	 * 
	 * @return Recipe
	 */
	public function getRecipe($id) {
		
		if($this->locale == null) {
		
			throw new Exception('You must use setLocale() before using getRecipe($id) Api');
		}
		
		if(is_int($id)) {
		
			return new WowRecipe($id, $this->locale);
		}
		
		throw new InvalidArgumentException('id parameter must be an integer');
	}
	
	/**
	 * getSpell
	 * 
	 * After this init you have access to all methods from Spell class.
	 *
	 * @param int $id
	 * 
	 * @throws InvalidArgumentException
	 * 
	 * @return Spell
	 */
	public function getSpell($id) {
		
		if($this->locale == null) {
		
			throw new Exception('You must use setLocale() before using getSpell($id) Api');
		}
		
		if(is_int($id)) {
		
			return new WowSpell($id, $this->locale);
		}
		
		throw new InvalidArgumentException('id parameter must be an integer');
	}
	
	/**
	 * getDataResourses
	 * 
	 * After this init you have access to all methods from DataResourses class.
	 *
	 * @return DataResources
	 */
	public function getDataResourses() {
		
		if($this->locale == null) {
		
			throw new Exception('You must use setLocale() before using getDataResourses() Api');
		}
		
		return new WowDataResources($this->locale);
	}
}
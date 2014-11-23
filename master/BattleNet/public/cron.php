<?php
#cron guild example
define('ROOT_PATH', realpath(dirname(__DIR__)));
define('APP_PATH', ROOT_PATH . '/application');
define('PUBLIC_PATH', ROOT_PATH . '/public');

define('API_LOCALES', 'a:13:{i:0;s:5:"en_US";i:1;s:5:"pt_BR";i:2;s:5:"es_MX";i:3;s:5:"en_GB";i:4;s:5:"de_DE";i:5;s:5:"es_ES";i:6;s:5:"fr_FR";i:7;s:5:"it_IT";i:8;s:5:"pl_PL";i:9;s:5:"pt_PT";i:10;s:5:"ru_RU";i:11;s:5:"ko_KR";i:12;s:5:"zh_TW";}');
define('API_LINKS', 'a:13:{s:5:"en_US";s:26:"https://us.api.battle.net/";s:5:"pt_BR";s:26:"https://us.api.battle.net/";s:5:"es_MX";s:26:"https://us.api.battle.net/";s:5:"en_GB";s:26:"https://eu.api.battle.net/";s:5:"de_DE";s:26:"https://eu.api.battle.net/";s:5:"es_ES";s:26:"https://eu.api.battle.net/";s:5:"fr_FR";s:26:"https://eu.api.battle.net/";s:5:"it_IT";s:26:"https://eu.api.battle.net/";s:5:"pl_PL";s:26:"https://eu.api.battle.net/";s:5:"pt_PT";s:26:"https://eu.api.battle.net/";s:5:"ru_RU";s:26:"https://eu.api.battle.net/";s:5:"ko_KR";s:26:"https://tw.api.battle.net/";s:5:"zh_TW";s:29:"https://www.battlenet.com.cn/";}');

define('API_KEY', 'YOUR API KEY'); //https://dev.battle.net/

define('REALM', 'Marécage de Zangar');
define('GUILD', 'Cercle');

require(APP_PATH . '/autoload.php');

$wow = new ApiWoW();

$wow->setLocale('fr_FR');

//if you need Auction update
$wow->getAuction(REALM)->json();

//if you need realmLeaderboard update
$wow->getChallengeMode()->realmLeaderboard(REALM)->json();

//your guild
$guild = $wow->getGuildProfile(REALM, GUILD)->json();

//use only guild profile and not this kind of loop for a guild page (for performance purpose)
//prefer to create a "by character" page to display more information on a character member.
//of course you can use this kind of loop for a cron task.
foreach ($guild->members as $member) {
	$wow->getCharacterProfile(REALM, $member->character->name)->json();
}
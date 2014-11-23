<?php
#usage example
define('ROOT_PATH', realpath(dirname(__DIR__)));
define('APP_PATH', ROOT_PATH . '/application');
define('PUBLIC_PATH', ROOT_PATH . '/public');

define('API_LOCALES', 'a:14:{i:0;s:5:"en_US";i:1;s:5:"pt_BR";i:2;s:5:"es_MX";i:3;s:5:"en_GB";i:4;s:5:"de_DE";i:5;s:5:"es_ES";i:6;s:5:"fr_FR";i:7;s:5:"it_IT";i:8;s:5:"pl_PL";i:9;s:5:"pt_PT";i:10;s:5:"ru_RU";i:11;s:5:"zh_TW";i:12;s:5:"ko_KR";i:13;s:5:"zh_CN";}');
define('API_LINKS', 'a:14:{s:5:"en_US";s:26:"https://us.api.battle.net/";s:5:"pt_BR";s:26:"https://us.api.battle.net/";s:5:"es_MX";s:26:"https://us.api.battle.net/";s:5:"en_GB";s:26:"https://eu.api.battle.net/";s:5:"de_DE";s:26:"https://eu.api.battle.net/";s:5:"es_ES";s:26:"https://eu.api.battle.net/";s:5:"fr_FR";s:26:"https://eu.api.battle.net/";s:5:"it_IT";s:26:"https://eu.api.battle.net/";s:5:"pl_PL";s:26:"https://eu.api.battle.net/";s:5:"pt_PT";s:26:"https://eu.api.battle.net/";s:5:"ru_RU";s:26:"https://eu.api.battle.net/";s:5:"zh_TW";s:26:"https://tw.api.battle.net/";s:5:"ko_KR";s:26:"https://kr.api.battle.net/";s:5:"zh_CN";s:29:"https://www.battlenet.com.cn/";}');

exit(print_r(unserialize(API_LOCALES)));
define('API_KEY', 'YOUR API KEY'); //https://dev.battle.net/

require(APP_PATH . '/autoload.php');

$wow = new ApiWoW();

/*
$wow->setLocale('fr_FR');
print_r($wow->getAuction('Marécage de Zangar')->json());
echo '<br>&nbsp;<br>';
print_r($wow->getAuction('Marécage de Zangar')->jsonp());
*/

/*
echo '<br>&nbsp;<br>';
$wow->setLocale('en_GB');
$obj = $wow->getAchievement(2144);
print_r($obj->json());
echo '<br>&nbsp;<br>';
print_r($obj->jsonp());
*/

/*
echo '<br>&nbsp;<br>';
$wow->setLocale('fr_FR');
$obj2 = $wow->getBattlePet()->ability(640);
print_r($obj2->json());
echo '<br>&nbsp;<br>';
print_r($obj2->jsonp());
*/

/*
echo '<br>&nbsp;<br>';
$wow->setLocale('en_GB');
print_r($wow->getBattlePet()->species(258)->json());
echo '<br>&nbsp;<br>';
print_r($wow->getBattlePet()->species(258)->jsonp());
*/

/*
echo '<br>&nbsp;<br>';
$wow->setLocale('en_GB');
print_r($wow->getBattlePet()->stats(258)->json());
echo '<br>&nbsp;<br>';
print_r($wow->getBattlePet()->stats(258)->jsonp());
*/

/*
echo '<br>&nbsp;<br>';
$wow->setLocale('fr_FR');
print_r($wow->getBattlePet()->stats(258, 25)->json());
echo '<br>&nbsp;<br>';
print_r($wow->getBattlePet()->stats(258, 25)->jsonp());
*/

/*
echo '<br>&nbsp;<br>';
$wow->setLocale('fr_FR');
print_r($wow->getChallengeMode()->realmLeaderboard('Marécage de Zangar')->json());
echo '<br>&nbsp;<br>';
print_r($wow->getChallengeMode()->realmLeaderboard('Marécage de Zangar')->jsonp());
*/

/*
echo '<br>&nbsp;<br>';
$wow->setLocale('fr_FR');
print_r($wow->getChallengeMode()->regionLeaderboard()->json());
echo '<br>&nbsp;<br>';
print_r($wow->getChallengeMode()->regionLeaderboard()->jsonp());
*/

/*
echo '<br>&nbsp;<br>';
$wow->setLocale('fr_FR');
//basic usage
print_r($wow->getCharacterProfile('Marécage de Zangar', 'Agila')->json());
echo '<br>&nbsp;<br>';
print_r($wow->getCharacterProfile('Marécage de Zangar', 'Agila')->jsonp());
*/

/*
echo '<br>&nbsp;<br>';
$wow->setLocale('fr_FR');
print_r($wow->getCharacterProfile('Marécage de Zangar', 'Agila')->json('audit'));
echo '<br>&nbsp;<br>';
print_r($wow->getCharacterProfile('Marécage de Zangar', 'Agila')->jsonp('audit'));
*/ 

/*
echo '<br>&nbsp;<br>';
$wow->setLocale('en_GB');
print_r($wow->getItem()->item(18803)->json());
echo '<br>&nbsp;<br>';
print_r($wow->getItem()->item(18803)->jsonp());
*/

/*
echo '<br>&nbsp;<br>';
$wow->setLocale('en_GB');
print_r($wow->getItem()->set(1060)->json());
echo '<br>&nbsp;<br>';
print_r($wow->getItem()->set(1060)->jsonp());
*/

/*
echo '<br>&nbsp;<br>';
$wow->setLocale('fr_FR');
//basic usage
print_r($wow->getGuildProfile('Marécage de Zangar', 'Cercle')->json());
echo '<br>&nbsp;<br>';
print_r($wow->getGuildProfile('Marécage de Zangar', 'Cercle')->jsonp());
*/

/*
echo '<br>&nbsp;<br>';
$wow->setLocale('fr_FR');
print_r($wow->getGuildProfile('Marécage de Zangar', 'Cercle')->json('news'));
echo '<br>&nbsp;<br>';
print_r($wow->getGuildProfile('Marécage de Zangar', 'Cercle')->jsonp('news'));
*/

/*
echo '<br>&nbsp;<br>';
$wow->setLocale('en_GB');
$obj = $wow->getPvp('rbg');
print_r($obj->json());
echo '<br>&nbsp;<br>';
print_r($obj->jsonp());
*/

/*
echo '<br>&nbsp;<br>';
$wow->setLocale('en_GB');
$obj = $wow->getQuest(13146);
print_r($obj->json());
echo '<br>&nbsp;<br>';
print_r($obj->jsonp());

echo '<br>&nbsp;<br>';
$wow->setLocale('fr_FR');
$obj = $wow->getQuest(13146);
print_r($obj->json());
echo '<br>&nbsp;<br>';
print_r($obj->jsonp());
*/

/*
echo '<br>&nbsp;<br>';
$wow->setLocale('en_GB');
$obj = $wow->getRealmStatus();
print_r($obj->json());
echo '<br>&nbsp;<br>';
print_r($obj->jsonp());
*/

/*
echo '<br>&nbsp;<br>';
$wow->setLocale('fr_FR');
$obj = $wow->getRecipe(33994);
print_r($obj->json());
echo '<br>&nbsp;<br>';
print_r($obj->jsonp());
*/

/*
echo '<br>&nbsp;<br>';
$wow->setLocale('fr_FR');
$obj = $wow->getSpell(8056);
print_r($obj->json());
echo '<br>&nbsp;<br>';
print_r($obj->jsonp());
*/

/*
echo '<br>&nbsp;<br>';
$wow->setLocale('fr_FR');
print_r($wow->getDataResourses()->petTypes()->json());
echo '<br>&nbsp;<br>';
print_r($wow->getDataResourses()->petTypes()->jsonp());
*/
 

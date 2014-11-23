<?php
spl_autoload_register(function($class) {
	
	$c = $class[0];
	
	if($c == 'I') {
		
		require(APP_PATH . '/interfaces/' . $class . '.php');
		
		return;
		
	} elseif($c == 'T') {
		
		require(APP_PATH . '/traits/' . $class . '.php');
		
		return;
		
	} else {
		
		$d = $class[1];
		$e = $class[2];
		
		if(($c . $d . $e) == 'Api') {
			
			require(APP_PATH . '/' . $class . '.php');
			
			return;
		}
			
		require(APP_PATH . '/classes/' . $class . '.php');
	}
});
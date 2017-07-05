<?php

define('FILE', '../../');

function charge($class) {
	require_once FILE.'class/'.$class.'.php';
}

spl_autoload_register('charge');

$classDevis = new devis();
	
$get = @explode('/', $_GET['get']);
	
$dir = '';
foreach($get as $_get) {
	$dir .= '/'.$_get;
	if(file_exists('tpl'.$dir.'.php')) {
		require 'tpl'.$dir.'.php';
		break;
	}
}

?>
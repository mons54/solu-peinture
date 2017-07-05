<?php

define('FILE', '../');

function charge($class) {
	require_once FILE.'class/'.$class.'.php';
}

spl_autoload_register('charge');

$classConnexion = new connexion();

if($classConnexion->connect())
	header('location:../');

define('PATH', "http://".$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'], '/')));

$get = @explode('/', $_GET['get']);

ob_start();

$file = false;

$dir = '';
foreach($get as $_get) {
	$dir .= '/'.$_get;
	if(file_exists('tpl'.$dir.'.php')) {
		require 'tpl'.$dir.'.php';
		$file = true;
		break;
	}
}

if(!$file)
	require 'tpl/default.php';
	
$html = ob_get_contents();
ob_end_clean();
	
require 'content.php';

?>
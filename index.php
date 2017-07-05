<?php
@session_start();

$version='6'; 

define('FILE', '');
define("PATH", "http://".$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'], '/')));

$get = @explode('/', $_GET['get']);

function charge($class) {
	require_once 'class/'.$class.'.php';
}

spl_autoload_register('charge');

function connect() {
	return !empty($_SESSION['admin']);
}

if(!connect()) {
	if (!empty($_COOKIE['password'])) {
		$classAdmin=new admin();
		$classAdmin->connexionAuto($_COOKIE['password']);
	}
}

$classContacts=new contacts();
$contacts=$classContacts->getContacts();

$dir = '';
$file = false;
foreach($get as $_get) {
	$dir .= '/'.$_get;
	if(file_exists('head'.$dir.'.php')) {
		require 'head'.$dir.'.php';
		$file = true;
		break;
	}
}

if(!$file)
	require 'head/default.php';

ob_start();

$dir = '';
$file = false;
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
	
require 'contenu.php';

?>
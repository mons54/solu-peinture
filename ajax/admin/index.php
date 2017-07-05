<?php
@session_start();

define('FILE', '../../');

function connect() {
	return !empty($_SESSION['admin']);
}

if(!connect())
	die;
	
function charge($class) {
	require_once FILE.'class/'.$class.'.php';
}

spl_autoload_register('charge');

$classAdmin=new admin();
	
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
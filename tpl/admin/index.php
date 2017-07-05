<?php

function charge($class) {
	require_once '../../class/'.$class.'.php';
}

spl_autoload_register('charge');

$classAdmin=new admin();

echo 'ok';

?>
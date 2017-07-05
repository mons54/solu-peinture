<?php

$dir = '../../img/redactor/';


if(!file_exists($dir) || ($open = opendir($dir)) === false)
	die;

$img = array();
while($fichier = readdir($open)) {
	if (!is_dir($dir.'/'.$fichier))
		$img[] = array(
			'thumb' => 'img/redactor/'.$fichier,
			'image' => 'img/redactor/'.$fichier
		);
}

echo json_encode($img);

?>
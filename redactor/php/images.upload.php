<?php

$dir = 'img/redactor/';
$file = pathinfo($_FILES['file']['name']);
$extension = strtolower($file['extension']);
$extensions = array('jpg', 'jpeg', 'pjpeg', 'gif', 'png');

if(in_array($extension, $extensions)){
	
	$file = $dir.md5(date('YmdHis')).'.'.$extension;
	$dir_file = '../../'.$dir.md5(date('YmdHis')).'.'.$extension;
	
	move_uploaded_file($_FILES['file']['tmp_name'], $dir_file);

    $array = array(
        'filelink' => $file
    );

    echo stripslashes(json_encode($array));
}

?>
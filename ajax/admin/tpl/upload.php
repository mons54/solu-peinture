<?php

$array = array();

foreach($_FILES as $file) {
	if($file['error'] == 0){
		$infosfichier = pathinfo($file['name']);
		$extension_upload = $infosfichier['extension'];
		$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');
		if (in_array($extension_upload, $extensions_autorisees)){
			$name = md5(uniqid(rand(), true)).'_'.time();
			move_uploaded_file($file['tmp_name'], FILE.'img/upload/'.$name.'.'.$extension_upload.'');
			$img = array(
				'name' => $name,
				'ext' => $extension_upload,
			);
			array_push($array, $img);
		}
	}
}

echo json_encode($array);
?>





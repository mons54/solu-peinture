<?php

@session_start();

class admin extends contacts {

	const prefixe = 'gdh4z5d5edK98';
	const suffixe = 'LaPo43Hj87zsY';
	
	public function connect() {
		return !empty($_SESSION['admin']);
	}
	
	public function getCle(){
		return md5(uniqid(rand(), true));
	}
	
	public function hacherMdp($mdp){
		return md5(sha1(self::prefixe).$mdp.sha1(self::suffixe));
	}
	
	public function connexionAuto($mdp){
		if($mdp == $this->getMdp())
			$_SESSION['admin'] = true;
		else
			setcookie("password", "", time()-3600);
	}
	
	public function getMdp(){
		return json_decode(file_get_contents(FILE.'json/mdp.json'), true);
	}
	
	public function setMdp($mdp){
		
		$fp = fopen(FILE.'json/mdp.json', 'w+');
		
		$data = json_encode($this->hacherMdp($mdp));
		fwrite($fp, $data);

		fclose($fp);
		
		if(file_exists(FILE.'json/mdp-oublier.json'))
			unlink(FILE.'json/mdp-oublier.json');
			
		return 'Le mot de passe a été modifié.';
	}
	
	public function setContacts($post) {
		
		$fp = fopen('json/contacts.json', 'w+');
		
		$data = json_encode($post, JSON_FORCE_OBJECT);
		fwrite($fp, $data);

		fclose($fp);
	}
	
	public function addModule($post, $file) {
	
		unset($post['ajouter-module']);
		
		$module = $post['module'];
		
		if($module == 'image_text') {
			if($post['image_size'] != 'custom') {
				$post['image_width'] = $post['image_size'];
				$post['image_height'] = $post['image_size'];
			}
		}
		
		if(isset($post['time']))
			$post['time'] = (int) $post['time'] * 1000;
		
		$keys = array();
		$dir = 'json/modules/'.$module.'/';
		
		if(($open = opendir($dir)) === false)
			return; 
		
		while($files = readdir($open)) {
			if ($files == '.' || $files == '..') 
				continue;
			
			if(!is_dir($dir.$files))
				if(($key = str_replace('.json', '', $files)) > 0)
					$keys[] = $key;
		}
		
		if(($key = max($keys) + 1) > 0) {
			$module = array(
				'module' => $module,
				'key' => $key
			);
			
			$modules = json_decode(file_get_contents($file), true);
			$modules[] = $module;
			
			$fp = fopen($file, 'w+');
		
			$data = json_encode($modules);
			fwrite($fp, $data);

			fclose($fp);
			
			unset($post['module']);
			
			$file = $dir.$key.'.json';
			
			$fp = fopen($file, 'w+');
		
			$data = json_encode($post);
			fwrite($fp, $data);

			fclose($fp);
		}
		
		header('location:'.$_SERVER['REQUEST_URI']);
	}
	
	public function setModule($post) {
	
		$module = $post['module'];
		$key = (int) $post['key'];
		
		if($module == 'image_text') {
			if($post['image_size'] != 'custom') {
				$post['image_width'] = $post['image_size'];
				$post['image_height'] = $post['image_size'];
			}
		}
		
		if(isset($post['time']))
			$post['time'] = (int) $post['time'] * 1000;
		
		$file = 'json/modules/'.$module.'/'.$key.'.json';
		
		if(!file_exists($file))
			return false;
			
		unset($post['modifier-module']);
		unset($post['module']);
		unset($post['key']);
		
		$module = json_decode(file_get_contents($file), true);
		
		foreach($post as $key => $value)
			$module[$key] = $value;
		
		$fp = fopen($file, 'w+');
	
		$data = json_encode($module);
		fwrite($fp, $data);

		fclose($fp);
		
		header('location:'.$_SERVER['REQUEST_URI']);
	}
	
	public function deleteModule($post, $file) {
		
		if(!file_exists($file))
			return false;
	
		$module = $post['module'];
		$key = (int) $post['key'];
		
		$_modules = json_decode(file_get_contents($file), true);
		
		foreach($_modules as $_key => $_module)
			if($_module['module'] == $module && $_module['key'] == $key)
				unset($_modules[$_key]);
		
		$fp = fopen($file, 'w+');
		
		$data = json_encode($_modules);
		fwrite($fp, $data);

		fclose($fp);
		
		$file = 'json/modules/'.$module.'/'.$key.'.json';
		@unlink($file);
		
		header('location:'.$_SERVER['REQUEST_URI']);
	}
	
	public function changeModules($post) {
	
		$file = FILE.$post['file'];
		$data = $post['data'];
		
		$fp = fopen($file, 'w+');
		
		$data = json_encode($data);
		fwrite($fp, $data);

		fclose($fp);
	}
	
	public function uploadPhotosSliders($post) {
	
		$key = $post['key'];
		$file = 'json/modules/sliders/'.$key.'.json';
		$dir_img = 'img/modules/sliders/'.$key.'/';
		
		if(!file_exists($file))
			return false;
			
		if(!file_exists($dir_img))
			mkdir($dir_img);
			
		$sliders = json_decode(file_get_contents($file), true);
		
		if(!empty($sliders['image'])) {
			foreach($sliders['image'] as $key => $photo) {
				if(!isset($post['photo'][$key])) {
					@unlink($dir_img.$photo);
					unset($sliders['image'][$key]);
				}
			}
		}
					
		
		if(!empty($post['upload']))
			foreach($post['upload'] as $photo)
				if(($image = $this->uploadImageBase64($photo, $dir_img)) !== false)
					$sliders['image'][] = $image;
		
		$fp = fopen($file, 'w+');
		
		$data = json_encode($sliders);
		fwrite($fp, $data);

		fclose($fp);
		
		header('location:'.$_SERVER['REQUEST_URI']);
	}
	
	public function uploadPhotosAlbums($post) {
	
		$key = $post['key'];
		$file = 'json/modules/albums/'.$key.'.json';
		$dir_img = 'img/modules/albums/'.$key.'/';
		
		if(!file_exists($file))
			return false;
			
		if(!file_exists($dir_img))
			mkdir($dir_img);
			
		$albums = json_decode(file_get_contents($file), true);
		
		if(!empty($albums['image'])) {
			foreach($albums['image'] as $key => $photo) {
				if(!isset($post['photo'][$key])) {
					@unlink($dir_img.$photo);
					unset($albums['image'][$key]);
				}
			}
		}
		
		if(!empty($post['upload']))
			foreach($post['upload'] as $photo)
				if(($image = $this->uploadImageBase64($photo, $dir_img)) !== false)
					$albums['image'][] = $image;
		
		$fp = fopen($file, 'w+');
		
		$data = json_encode($albums);
		fwrite($fp, $data);

		fclose($fp);
		
		header('location:'.$_SERVER['REQUEST_URI']);
	}
	
	public function saveImageText($post) {
	
		$key = $post['key'];
		$file = FILE.'json/modules/image_text/'.$key.'.json';
		$image_text = json_decode(file_get_contents($file), true);
			
		if(!empty($post['data']['title']))
			$image_text['title'] = $post['data']['title'];
		
		$image_text['text'] = $post['data']['text'];
		
		$data = json_encode($image_text);
		
		$fp = fopen($file, 'w+');
		fwrite($fp, $data);
		
		fclose($fp);
	}
	
	public function uploadImageText($post) {
	
		$_key = $post['key'];
		$file = FILE.'json/modules/image_text/'.$_key.'.json';
		$dir_img = FILE.'img/modules/image_text/'.$_key.'/';
		
		if(!file_exists($dir_img))
			mkdir($dir_img);
			
		$image_text = json_decode(file_get_contents($file), true);
		
		if(!empty($image_text['image'])) {
			foreach($image_text['image'] as $key => $photo) {
				if(!isset($post['data']['photos'][$key])) {
					@unlink($dir_img.$photo);
					unset($image_text['image'][$key]);
				}
			}
		}
		
		if(!empty($post['data']['upload']))
			foreach($post['data']['upload'] as $photo)
				if(($image = $this->uploadImageBase64($photo, $dir_img)) !== false)
					$image_text['image'][] = $image;
		
		$fp = fopen($file, 'w+');
		
		$data = json_encode($image_text);
		fwrite($fp, $data);

		fclose($fp);
		
		return $data;
	}
	
	public function saveEditor($post) {
	
		$key = $post['key'];
		$file = FILE.'json/modules/editor/'.$key.'.json';
		$editor = json_decode(file_get_contents($file), true);
			
		$editor['content'] = $post['data'];
		
		$data = json_encode($editor);
		
		$fp = fopen($file, 'w+');
		fwrite($fp, $data);
		
		fclose($fp);
	}
	
	private function supDir($dossier) {
		
		if(!file_exists($dossier))
			return;
			
		if(($open = opendir($dossier)) === false)
			return; 
		
		while($fichier = readdir($open)) {
			if ($fichier == '.' || $fichier == '..') 
				continue;
			
			if (is_dir($dossier.'/'.$fichier))
				$this->supDir($dossier.'/'.$fichier);
			else 
				unlink($dossier.'/'.$fichier);
		}
					
		closedir($open);
		rmdir($dossier);
	}
	
	private function uploadImageBase64($data_url, $dir) {
		
		$ext_autoris = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');
		$array = explode(',', $data_url);

		if(empty($array[0]))
			return false;
			
		$array = explode('/', $array[0]);

		if($array[0] != 'data:image')
			return false;
		
		$ext = explode(';', $array[1]);
		
		if(!in_array($ext[0], $ext_autoris))
			return false;
			
		$name = md5(uniqid(rand(), true)).'_'.time().'.'.$ext[0];
		
		copy($data_url, $dir.$name);
		
		return $name;
	}
	
	private function resizeImage($min_max, $chemin, $new_chemin, $width, $height){
		$file_path = $chemin;
		$new_file_path = $new_chemin;
		list($img_width, $img_height) = @getimagesize($file_path);
		if(!$img_width || !$img_height){
			return false;
		}
		
		if($min_max == 'max') {
			$scale = max(
				$width / $img_width,
				$height / $img_height
			);
		}
		else {
			$scale = min(
				$width / $img_width,
				$height / $img_height
			);
		}
		
		if($scale >= 1) {
			if($file_path !== $new_file_path){
				return copy($file_path, $new_file_path);
			}
			return true;
		}
		$new_width = $img_width * $scale;
		$new_height = $img_height * $scale;
		$new_img = @imagecreatetruecolor($new_width, $new_height);
		switch (strtolower(substr(strrchr($chemin, '.'), 1))){
			case 'jpg':
			case 'jpeg':
				$src_img = @imagecreatefromjpeg($file_path);
				$write_image = 'imagejpeg';
				$image_quality = 100;
			break;
			case 'gif':
				@imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
				$src_img = @imagecreatefromgif($file_path);
				$write_image = 'imagegif';
				$image_quality = null;
			break;
			case 'png':
				@imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
				@imagealphablending($new_img, false);
				@imagesavealpha($new_img, true);
				$src_img = @imagecreatefrompng($file_path);
				$write_image = 'imagepng';
				$image_quality = 9;
			break;
			default:
				$src_img = null;
		}
		$success = $src_img && @imagecopyresampled(
			$new_img,
			$src_img,
			0, 0, 0, 0,
			$new_width,
			$new_height,
			$img_width,
			$img_height
		) && $write_image($new_img, $new_file_path, $image_quality);
		@imagedestroy($src_img);
		@imagedestroy($new_img);
		return $success;
	}
}
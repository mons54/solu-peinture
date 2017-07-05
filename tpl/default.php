<?php

$dir = '';
$file = false;

if(connect()) {
	foreach($get as $_get) {
		$dir .= '/'.$_get;
		if(file_exists('json/tpl'.$dir.'.json')) {
			$file = 'json/tpl'.$dir.'.json';
			break;
		}
	}
}

if(!$file)
	$file = 'json/tpl/default.json';

if(connect()) {
	if(isset($_POST)) {
		
		$classAdmin=new admin();
		
		if(isset($_POST['submit-photos-sliders']) && !empty($_POST['key']))
			echo $classAdmin->uploadPhotosSliders($_POST);
		
		if(isset($_POST['ajouter-module']) && !empty($_POST['module']))
			$classAdmin->addModule($_POST, $file);
			
		if(isset($_POST['modifier-module']) && !empty($_POST['module']) && !empty($_POST['key']))
			$classAdmin->setModule($_POST);
		
		if(isset($_POST['supprimer-module']) && !empty($_POST['module']) && !empty($_POST['key']))
			echo $classAdmin->deleteModule($_POST, $file);
		
		if(isset($_POST['submit-photos-albums']) && !empty($_POST['key']))
			$classAdmin->uploadPhotosAlbums($_POST);
		
	}
	$modules = json_decode(file_get_contents($file), true);
	?>
	<script>
		$(document).ready(function() {
			$('#admin_modules').admin_modules({file:<?php echo json_encode($file); ?>, data:<?php echo json_encode($modules); ?>});
		});
	</script>
	<section id="admin_modules"></section>
	<?php
}
	
$modules = json_decode(file_get_contents($file), true);

if(!empty($modules)) {
	foreach($modules as $key => $module) {
		?>
		<section id="module-<?php echo $key; ?>" class="module">
			<?php require 'modules/'.$module['module'].'.php'; ?>
		</section>
		<?php
	}
}
?>
<?php
$file = 'json/modules/image_text/'.$module['key'].'.json';
$image_text = json_decode(file_get_contents($file), true);
$image = @array_shift(array_values($image_text['image']));
?>
<section <?php if(connect()) echo 'id="image_text-'.$module['key'].'"'; ?> class="contenu image_text image_text-<?php echo $image_text['position']; ?>">
	<?php 
	if($image_text['title'] != 'false')
		echo '<h1 class="title">'.$image_text['title'].'</h1>';
	?>
	<div style="width:<?php echo $image_text['image_width']; ?>px;height:<?php echo $image_text['image_height']; ?>px;background-image: url(img/modules/image_text/<?php echo $module['key'].'/'.$image; ?>);" id="image_text-image-<?php echo $module['key']; ?>" class="image <?php echo $image_text['position']; ?>"></div>
	<div class="text"><?php echo @stripslashes($image_text['text']); ?></div>
	<div class="clear"></div>
</section>
<?php
$count = @count($image_text['image']);

if($count > 1) {
	?>
	<script>
		$(document).ready(function() {
			$('#image_text-image-<?php echo $module['key']; ?>').image_text({key:<?php echo json_encode($module['key']); ?>, data:<?php echo json_encode($image_text); ?>});
		});
	</script>
	<?php
}

if(connect()) {
	?>
	<script>
		$(document).ready(function() {
			$('#image_text-<?php echo $module['key']; ?>').admin_image_text({key: <?php echo json_encode($module['key']); ?>, data:<?php echo @json_encode($image_text); ?>});
		});
	</script>
	<?php
}
?>





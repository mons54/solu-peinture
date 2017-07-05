<?php
$file = 'json/modules/editor/'.$module['key'].'.json';
$editor = json_decode(file_get_contents($file), true);
?>
<section <?php if(connect()) echo 'id="editor-'.$module['key'].'"'; ?> class="contenu">
	<div class="content"><?php echo @stripslashes($editor['content']); ?></div>
	<div class="clear"></div>
</section>
<?php

if(connect()) {
	?>
	<script>
		$(document).ready(function() {
			$('#editor-<?php echo $module['key']; ?>').admin_editor({key: <?php echo json_encode($module['key']); ?>, data:<?php echo @json_encode($editor); ?>});
		});
	</script>
	<?php
}
?>





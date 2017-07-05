<?php
$file = 'json/modules/albums/'.$module['key'].'.json';

if(connect()) {
	
	$data = json_decode(file_get_contents($file), true);
	?>
	<script>
		$(document).ready(function() {
			$('#album-<?php echo $module['key']; ?>').admin_albums({data:<?php echo @json_encode($data); ?>, key:<?php echo json_encode($module['key']); ?>});
		});
	</script>
	<?php
}

$data = json_decode(file_get_contents($file), true);
?>

<script>
	$(document).ready(function() {
		$('#album-<?php echo $module['key']; ?>').albums({data:<?php echo @json_encode($data); ?>, key:<?php echo json_encode($module['key']); ?>});
	});
</script>
<section id="album-<?php echo $module['key']; ?>" class="contenu album"></section>




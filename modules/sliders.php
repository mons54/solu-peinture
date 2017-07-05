<?php
$file = 'json/modules/sliders/'.$module['key'].'.json';

if(connect()) {
	
	$data = json_decode(file_get_contents($file), true);
	?>
	<script>
		$(document).ready(function() {
			$('#sliders-<?php echo $module['key']; ?>').admin_sliders({data:<?php echo @json_encode($data); ?>, key:<?php echo json_encode($module['key']); ?>});
		});
	</script>
	<?php
}

$data = json_decode(file_get_contents($file), true);
?>

<script>
	$(document).ready(function() {
		$('#sliders-<?php echo $module['key']; ?>').sliders({data:<?php echo @json_encode($data); ?>, key:<?php echo json_encode($module['key']); ?>});
	});
</script>
<section style="height:<?php echo $data['height']; ?>px" id="sliders-<?php echo $module['key']; ?>" class="sliders"></section>




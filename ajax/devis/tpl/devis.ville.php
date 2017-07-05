<?php
if(!empty($_POST['id'])) {
	$ville = $classDevis->getVille((int) $_POST['id']);
	foreach($ville as $ville){
		?>
		<option value="<?php echo $ville->id; ?>" <?php if(!empty($_POST['ville']) AND $_POST['ville'] == $ville->id) { ?>selected<?php } ?> ><?php echo $ville->nom; ?></option>
		<?php
	}
}
?>





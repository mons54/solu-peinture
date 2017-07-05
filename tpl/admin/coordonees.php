<?php 
if(!empty($_POST)){
	$classAdmin->setContacts($_POST);
}

$contacts=$classAdmin->getContacts();
	
?>
<form action="admin/coordonnees" method="post">
	<div class="form">
		<label>Nom</label>
		<input name="nom" type="text" value="<?php echo stripslashes($contacts->nom); ?>" />
	</div>
	<div class="form">
		<label>Email</label>
		<input name="email" type="email" value="<?php echo stripslashes($contacts->email); ?>" />
	</div>
	<div class="form">
		<label>Adresse</label>
		<textarea name="adresse" style="height:100px"><?php echo stripslashes($contacts->adresse); ?></textarea>
	</div>
	<div class="form">
		<label>Ville</label>
		<input name="ville" type="text" value="<?php echo stripslashes($contacts->ville); ?>" />
	</div>
	<div class="form">
		<label>Code Postale</label>
		<input name="cp" type="text" value="<?php echo stripslashes($contacts->cp); ?>" />
	</div>
	<div class="form">
		<label>Téléphone</label>
		<input name="tel" type="tel" value="<?php echo stripslashes($contacts->tel); ?>" />
	</div>
	<div class="form">
		<button type="submit">Modifier</button>
	</div>
</form>
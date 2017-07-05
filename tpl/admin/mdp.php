<?php 

if(!empty($_POST['password']) && !empty($_POST['new-password'])){
	
	$password = $_POST['password'];
	
	if($classAdmin->hacherMdp($password) == $classAdmin->getMdp()) {
		if($_POST['new-password'] == $_POST['repeat-password']) {
			echo "<p class='message'>".$classAdmin->setMdp($_POST['new-password'])."</p>";
		}
		else {
			echo "<p class='message'>Les mots de passe ne sont pas identiques</p>";
		}
	}
	else {
		echo "<p class='message'>Le mot de passe actuel n'est pas valide</p>";
	}
}
?>
<form action="admin/mdp" method="post">
	<div class="form">
		<label>Actuel</label>
		<input type="password" name="password" required />
	</div>
	<div class="form">
		<label>Nouveau</label>
		<input type="password" name="new-password" required />
	</div>
	<div class="form">
		<label>Saisir à nouveau</label>
		<input type="password" name="repeat-password" required />
	</div>
	<div class="form">
		<button name="coordonnees" type="submit">Modifier</button>
	</div>
</form>




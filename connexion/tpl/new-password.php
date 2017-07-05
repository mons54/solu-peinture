<script>
	$(document).ready(function() {
		$('input').focus(function() {
			$('.message').remove();
		});
	});
</script>

<?php
$url = explode('?',$_SERVER['REQUEST_URI']);
$lines = preg_split("/&/", $url[1]);

$gets = array();

foreach($lines as $line) {
	$matches = explode('=',$line,2);
	$gets[$matches[0]] = $matches[1];
}

if(isset($gets['code']) && $classConnexion->verifCode($gets['code'])) {
	?>
	<section id="login">
		<?php
		if(!empty($_POST['password']) && $_POST['password'] == $_POST['repeat-password']) {
			echo "<p class='message'>".$classConnexion->setMdp($_POST['password'])."</p>";
		}
		else {
			?>
			<h1>Nouveau mot de passe</h1>
			<form id="form" action="" method="post">
				<div id="form-password">
					<label for="password">Mot de passe</label>
					<input name="password" type="password" />
				</div>
				<div id="form-password">
					<label for="repeat-password">Saisir à nouveau</label>
					<input name="repeat-password" type="password" />
				</div>
				<?php
				if(isset($_POST['password'])) {
					echo "<p class='message'>Les mots de passe ne sont pas identiques</p>";
				}
				?>
				<div id="form-submit">
					<button type="submit">Modifier</button>
				</div>
				<div class="clear"></div>
			</form>
			<?php
		}
		?>
		<p><a href="">Connexion</a> | <a href="../">Retour au site</a></p>
	</section>
	<?php
}
else {
	header('location:'.PATH.'/');
}
?>






<script>
	$(document).ready(function() {
		$('#form-contact').contact();
	});
</script>

<section class="contenu">
	<h1>Nous contacter</h1> 
	<?php
	
	if(!empty($get[1]) && $get[1] == 'message-envoyer') {
		echo '<p class="message">Votre message a été envoyé. Nous vous répondrons dans les plus brefs délais, merci.</p>';
	}
	else {
				
				
		if(!empty($_POST['objet']) AND !empty($_POST['nom']) AND !empty($_POST['message']) AND preg_match("#^[\w.-]+@[\w.-]{2,}\.[a-z]{2,5}$#", $_POST['email']))
			$classContacts->sendMail($_POST['nom'], $_POST['email'], $_POST['tel'], $_POST['objet'], nl2br(stripslashes($_POST['message']))); 

		else if(isset($_POST['nom']))
			echo "<p class='message'>Veuillez remplir les informations obligatoire, merci.</p>";

		?>
		<section class="section-contact">
			<form action="contact" id="form-contact" method="post">
				<h2>Par formulaire</h2>
				<div class="form">
					<label>Nom *</label>
					<input type="text" id="nom" name="nom" <?php if(!empty($_POST['nom'])) echo 'value="'.stripslashes($_POST['nom']).'"'; ?> />
				</div>
				<div class="form">
					<label>Email *</label>
					<input type="email" id="email" name="email" <?php if(!empty($_POST['email'])) echo 'value="'.$_POST['email'].'"'; ?> />
				</div>
				<div class="form">
					<label>Téléphone &nbsp;</label>
					<input type="tel" id="tel" name="tel" <?php if(!empty($_POST['tel'])) echo 'value="'.$_POST['tel'].'"'; ?> />
				</div>
				<div class="form">
					<label>Objet *</label>
					<input type="text" id="objet" name="objet" <?php if(!empty($_POST['objet'])) echo 'value="'.stripslashes($_POST['objet']).'"'; ?> />
				</div>
				<div class="form">
					<label>Message *</label>
					<textarea name="message" ><?php if(!empty($_POST['message'])) echo $_POST['message'];  ?></textarea>
				</div>
				<div class="form">
					<button type="submit">Envoyer</button>
				</div>
			</form>
		</section>
		<?php
	}
	?>
	<section class="section-contact">
		<h2>Par email</h2>
		<p>Vous pouvez nous contacter à cette adresse : <a href="mailto:<?php echo $contacts->email; ?>"><?php echo $contacts->email; ?></a></p>
	</section>
</section>





<?php 
$classDevis = new devis();
?>

<script>
	$(document).ready(function() {
		$('#form-devis').devis();
	});
</script>

<section id="demande_devis" class="contenu">
	<h1>Demande de devis</h1> 
	<?php
	
	if(!empty($get[1]) && $get[1] == 'message-envoyer') {
		echo '<p class="message">Votre demande de devis a été envoyé. Nous vous répondrons dans les plus brefs délais, merci.</p>';
	}
	else {
				
				
		if(!empty($_POST['nom']) AND preg_match("#^[\w.-]+@[\w.-]{2,}\.[a-z]{2,5}$#", $_POST['email']) AND !empty($_POST['adresse']) AND !empty($_POST['code_postal']) AND !empty($_POST['commune']))
			$classDevis->sendDevis($_POST); 

		else if(isset($_POST['nom']))
			echo "<p class='message'>Veuillez remplir les informations obligatoire, merci.</p>";

		?>
		<form action="devis" id="form-devis" method="post">
			<section class="section-devis">
				<h2>Lieu, date et type d'habitation</h2>
				<div class="form">
					<label>Département</label>
					<select name="departement">
						<?php
						$departement = $classDevis->getDepartement();
						foreach($departement as $departement){
							?>
							<option value="<?php echo $departement->code; ?>" <?php if(!empty($_POST['departement']) AND $_POST['departement'] == $departement->code) { ?>selected<?php } ?> ><?php echo $departement->code.' - '.$departement->nom; ?></option>
							<?php
						}
						?>
					</select>
				</div>
				<div class="form">
					<label>Ville</label>
					<select id="ville" name="ville">
						<?php
						$ville = $classDevis->getVille((int) $_POST['departement']);
						foreach($ville as $ville){
							?>
							<option value="<?php echo $ville->id; ?>" <?php if(!empty($_POST['ville']) AND $_POST['ville'] == $ville->id) { ?>selected<?php } ?> ><?php echo $ville->nom; ?></option>
							<?php
						}
						?>
					</select>
				</div>
				<div class="form">
					<label class="obligatoire">Date des travaux</label>
					<select name="date_travaux">
						<option>Choisissez</option>
						<?php
						$date_travaux = $classDevis->getDateTravaux();
						foreach($date_travaux as $date_travaux){
							?>
							<option value="<?php echo $date_travaux->id; ?>" <?php if(!empty($_POST['date_travaux']) AND $_POST['date_travaux'] == $date_travaux->id) { ?>selected<?php } ?> ><?php echo $date_travaux->nom; ?></option>
							<?php
						}
						?>
					</select>
				</div>
				<div class="form">
					<label class="obligatoire">Type d'habitat</label>
					<select name="type_construction">
						<option>Choisissez</option>
						<?php
						$type_construction = $classDevis->getTypeConstruction();
						foreach($type_construction as $type_construction){
							?>
							<option value="<?php echo $type_construction->id; ?>" <?php if(!empty($_POST['type_construction']) AND $_POST['type_construction'] == $type_construction->id) { ?>selected<?php } ?> ><?php echo $type_construction->nom; ?></option>
							<?php
						}
						?>
					</select>
				</div>
			</section>
			
			<section class="section-devis">
				<h2>Travaux <span class="font-normal size-14">(Plusiers choix possibles)</span></h2>
				<?php
				$travaux = $classDevis->getTravaux();
				foreach($travaux as $travaux){
					?>
					<div class="devis_travaux">
						<div class="nom">
							<input autocomplete="off" type="checkbox" rel="<?php echo $travaux->id; ?>" class="travaux" name="travaux_<?php echo $travaux->id; ?>" <?php if(!empty($_POST['travaux_'.$travaux->id]) AND $_POST['travaux_'.$travaux->id] == 'on') { ?>checked<?php } ?> /> <b><?php echo $travaux->nom; ?></b>
						</div>
						<div class="clear"></div>
					</div>
					<?php
				}
				?>
			</section>
			
			<section class="section-devis">
				<h2>Description des travaux</h2>
				<div class="form textarea">
					<label>
						Précisez votre projet *
						<div class="infos-textarea">Indiquez toutes les informations complémentaires importantes pour que nous puissions traiter au mieux votre demande</div>
					</label>
					<textarea id="message_devis" name="message_devis" ><?php if(!empty($_POST['message_devis'])){ echo $_POST['message_devis']; }  ?></textarea>
				</div>
			</section>
			
			<section class="section-devis">
				<h2>Vos coordonnées</h2>
				<div class="form">
					<label>Civilité *</label>
					<input autocomplete="off" type="radio" id="civilite" name="civilite" value="1" <?php if(empty($_POST['civilite'])){ ?>checked<?php } elseif(!empty($_POST['civilite']) AND $_POST['civilite'] == 1) { ?>checked<?php } ?> /> Mr
					<input autocomplete="off" type="radio" id="civilite" name="civilite" value="2" <?php if(!empty($_POST['civilite']) AND $_POST['civilite'] == 2) { ?>checked<?php } ?> /> Mme
					<input autocomplete="off" type="radio" id="civilite" name="civilite" value="3" <?php if(!empty($_POST['civilite']) AND $_POST['civilite'] == 3) { ?>checked<?php } ?> /> Mlle
				</div>
				<div class="form">
					<label>Nom et prénom *</label>
					<input type="text" id="nom" name="nom" <?php if(!empty($_POST['nom'])) { echo 'value="'.stripslashes($_POST['nom']).'"'; } ?> />
				</div>
				<div class="form">
					<label>Adresse *</label>
					<input type="text" id="adresse" name="adresse" <?php if(!empty($_POST['adresse'])) { echo 'value="'.stripslashes($_POST['adresse']).'"'; } ?> />
				</div>
				<div class="form">
					<label>Code postal *</label>
					<input type="text" id="code_postal" name="code_postal" <?php if(!empty($_POST['code_postal'])) { echo 'value="'.stripslashes($_POST['code_postal']).'"'; } ?> />
				</div>
				<div class="form">
					<label>Ville *</label>
					<input type="text" id="commune" name="commune" <?php if(!empty($_POST['commune'])) { echo 'value="'.stripslashes($_POST['commune']).'"'; } ?> />
				</div>
				<div class="form">
					<label>Email *</label>
					<input type="email" id="email" name="email" <?php if(!empty($_POST['email'])) { echo 'value="'.$_POST['email'].'"'; } ?> />
				</div>
				<div class="form">
					<label>Téléphone &nbsp;</label>
					<input type="tel" id="tel" name="tel" <?php if(!empty($_POST['tel'])) { echo 'value="'.$_POST['tel'].'"'; } ?> />
				</div>
				<div class="form">
					<button type="submit">Envoyer</button>
				</div>
			</section>
			
		</form>
		<?php
	}
	?>
</section>




<section id="footer">
	<a class="contact" href="contact">Nous contacter</a>
	<div class="nom">
		<?php echo $contacts->nom; ?> © 2012
	</div>
	<div class="adresse">
		<?php echo nl2br($contacts->adresse); ?>
		<br/><?php echo $contacts->ville; ?> <?php echo $contacts->cp; ?>
		<br/><?php echo $contacts->tel; ?>
	</div>
	<div class="realisations">
		Réalisation : <a target="_blank" href="http://www.solutionsweb.pro/">Solutions Web</a>
	</div>
</section>
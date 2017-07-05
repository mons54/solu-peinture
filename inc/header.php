<div id="header">
	<a id="logo" href="/"></a>
	<?php
	if(!empty($_SESSION['admin'])) {
		?>
		<a id="administration" href="admin">Administration</a>
		<?php
	}
	else {
		?>
		<a id="devis" href="devis">Demander un devis</a>
		<?php
	}
	?>
	<div id="tel"><?php echo $contacts->tel; ?></div>
</div>
	
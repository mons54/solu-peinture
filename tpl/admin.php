<?php
$classAdmin=new admin();

if(!$classAdmin->connect())
	header('location:connexion');
?>
<section class="contenu">
	<h1>Administration</h1>
	<ul id="menu-admin">
		<li><a <?php if(empty($get[1]) || $get[1] == 'coordonnees') echo 'class="selected"'; ?> href="admin/coordonnees">Coordonnées</a></li>
		<li><a <?php if(!empty($get[1]) && $get[1] == 'mdp') echo 'class="selected"'; ?> href="admin/mdp">Mot de passe</a></li>
		<li><a href="admin/deconnexion">Déconnexion</a></li>
	</ul>
<?php

$dir = 'tpl/admin';
$file = false;
foreach($get as $key => $value) {
	if($key > 0) {
		$dir .= '/'.$value;
		if(file_exists($dir.'.php')) {
			require $dir.'.php';
			$file = true;
			break;
		}
	}
}
if(!$file)
	require 'tpl/admin/coordonees.php';
?>
</section>





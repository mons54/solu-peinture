<ul>
	<?php
	$menus = array(
		1 => array(
			'name' => 'peinture',
			'text' => 'Peinture'
		),
		2 => array(
			'name' => 'decoration',
			'text' => 'Décoration'
		),
		3 => array(
			'name' => 'revetements',
			'text' => 'Revêtements'
		),
		4 => array(
			'name' => 'facade',
			'text' => 'Façade'
		),
		5 => array(
			'name' => 'placo',
			'text' => 'Placo'
		),
		6 => array(
			'name' => 'parquets',
			'text' => 'Parquets'
		)
	);
	
	foreach($menus as $key => $menu) {
		?>
		<li><a class="menu menu-<?php echo $key; if($get[0] == $menu['name']) echo ' menu-'.$key.'-selected'; ?>" href="<?php echo $menu['name']; ?>"><?php echo $menu['text']; ?></a></li>
		<?php
		if($key < 6) echo '<li class="sep"></li>';
	}
	?>
</ul>
	
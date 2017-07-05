
<!DOCTYPE html>
<html>
	
	<head>
		
		<base href="<?php echo PATH;?>/">
		
		<title><?php echo $title;?></title>
		
		<meta name="description" content="<?php echo $desc;?>"/>
		<meta name = "reply-to" content="<?php echo $contacts->email;?>"/>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<meta name="author" content="Solutions Web">
		
		<link href='http://fonts.googleapis.com/css?family=Jockey+One|Lobster|Rye' rel='stylesheet' type='text/css'>
		<link href="css/style.css?<?php echo $version; ?>" type="text/css" rel="stylesheet" media="all">
		<link rel="shortcut icon" href="img/favicon.ico?<?php echo $version; ?>">
		
		<script src="js/jquery.js?<?php echo $version; ?>"></script>
		<script src="js/jquery.min.js?<?php echo $version; ?>"></script>
		<script src="js/jquery-ui.min.js?<?php echo $version; ?>"></script>
		<script src="js/function.js?<?php echo $version; ?>"></script>
		<script src="js/sliders.js?<?php echo $version; ?>"></script>
		<script src="js/image_text.js?<?php echo $version; ?>"></script>
		<script src="js/albums.js?<?php echo $version; ?>"></script>
		<script src="js/devis.js?<?php echo $version; ?>"></script>
		<script src="js/contact.js?<?php echo $version; ?>"></script>
		
		<?php 
		if(connect()) {
			?>
			<link href="css/admin/style.css?<?php echo $version; ?>" type="text/css" rel="stylesheet" media="all">
			<script src="js/admin/admin.function.js?<?php echo $version; ?>"></script>
			<script src="js/admin/admin.modules.js?<?php echo $version; ?>"></script>
			<script src="js/admin/modules/admin.editor.js?<?php echo $version; ?>"></script>
			<script src="js/admin/modules/admin.sliders.js?<?php echo $version; ?>"></script>
			<script src="js/admin/modules/admin.image_text.js?<?php echo $version; ?>"></script>
			<script src="js/admin/modules/admin.albums.js?<?php echo $version; ?>"></script>
			
			<link href="redactor/css/redactor.css" rel="stylesheet" />
			<script src="redactor/js/redactor.js"></script>
			<script src="redactor/plugins/youtube.js"></script>
			<script src="redactor/lang/fr.js"></script>
			<?php
		}
		
		?>
		
	</head>
	
	<body>
		
		<div id="fb-root"></div>
		<script>(function() {
		var e = document.createElement('script'); e.async = true;
		e.src = document.location.protocol +
		'//connect.facebook.net/fr_FR/all.js#xfbml=1';
		document.getElementById('fb-root').appendChild(e);
		}());</script>
		
		<section id="dial"></section>
		
		<header class="header"><?php include 'inc/header.php'; ?></header>
		
		<section id="menu"><?php include 'inc/menu.php'; ?></section>
		
		<section id="content"><?php echo $html; ?></section>
			
		<footer class="footer"><?php include 'inc/footer.php'; ?></footer>
		
	</body>	
	
</html>
<script>
	$(document).ready(function() {
		$('input').focus(function() {
			$('.message').remove();
		});
	});
</script>

<section id="login">
	<h1>Connexion</h1>
	<form id="form" action="" method="post">
		<div id="form-password">
			<label for="password">Mot de passe</label>
			<input name="password" type="password" />
		</div>
		<?php
		if(!empty($_SESSION['connexion']) && $_SESSION['connexion'] > 10) {
			?>
			<script type="text/javascript">
				var RecaptchaOptions = {
					lang : 'fr',
					theme : 'custom',
					custom_theme_widget: 'recaptcha_widget'
				};
			</script>
			 <div id="recaptcha_widget" style="display:none">

				<div id="recaptcha_image"></div>

				<span class="recaptcha_only_if_image">Saisissez les mots ci-dessus</span>

				<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />

				<a id="reload_bt" class="bt" href="javascript:Recaptcha.reload()"></a>
				<a id="help_bt" class="bt" href="javascript:Recaptcha.showhelp()"></a>
			</div>
			
			<script src="http://www.google.com/recaptcha/api/challenge?k=6LcaQuMSAAAAALVgXsTvvjuggRwmXW3DfhhF-qf9"></script>
			<?php
			
			require_once('recaptcha.php');

			$privatekey = "6LcaQuMSAAAAAMACYNdcD9uHk4t8kX1xNjUSJg66";

			$resp = null;

			if (isset($_POST["recaptcha_response_field"])) {
				
				$resp = recaptcha_check_answer (
					$privatekey,
					$_SERVER["REMOTE_ADDR"],
					$_POST["recaptcha_challenge_field"],
					$_POST["recaptcha_response_field"]
				);

				if (!$resp->is_valid)
					echo '<p class="message">Les mots saisis sont incorrects</p>';
				else
					echo '<p class="message">'.$classConnexion->connexion($_POST['password']).'</p>';
			}
		}
		else if(isset($_POST['password'])) {
			echo '<p class="message">'.$classConnexion->_connexion($_POST).'</p>';
		}
		?>
		<div id="form-rememberme">
			<label for="rememberme">
				<input name="rememberme" type="checkbox" id="rememberme"> Se souvenir de moi
			</label>
		</div>
		<div id="form-submit">
			<button type="submit">Connexion</button>
		</div>
		<div class="clear"></div>
	</form>
	<p><a href="forget-password">Mot de passe oublié ?</a> | <a href="../">Retour au site</a></p>
</section>





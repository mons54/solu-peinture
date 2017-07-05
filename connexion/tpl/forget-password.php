<script>
	$(document).ready(function() {
		$('input').focus(function() {
			$('.message').remove();
		});
	});
</script>

<section id="login">
	<h1>Mot de passe oublié ?</h1>
	<form id="form" action="forget-password" method="post">
		<script type="text/javascript">
			var RecaptchaOptions = {
				lang : 'fr',
				theme : 'custom',
				custom_theme_widget: 'recaptcha_widget'
			};
		</script>
		 <div id="recaptcha_widget" style="display:none">

			<div id="recaptcha_image"></div>
			<div class="recaptcha_only_if_incorrect_sol" style="color:red">Incorrect please try again</div>

			<span class="recaptcha_only_if_image">Saisissez les mots ci-dessus</span>
			<span class="recaptcha_only_if_audio">Saisissez ce que vous entendez</span>

			<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />

			<a id="reload_bt" class="bt" href="javascript:Recaptcha.reload()"></a>
			<a id="help_bt" class="bt" href="javascript:Recaptcha.showhelp()"></a>
		</div>
		
		<?php
		require_once('recaptcha.php');

		$publickey = "6LcaQuMSAAAAALVgXsTvvjuggRwmXW3DfhhF-qf9";
		$privatekey = "6LcaQuMSAAAAAMACYNdcD9uHk4t8kX1xNjUSJg66";

		$resp = null;
		$valide = false;

		if (isset($_POST["recaptcha_response_field"])) {
			$resp = recaptcha_check_answer (
						$privatekey,
						$_SERVER["REMOTE_ADDR"],
						$_POST["recaptcha_challenge_field"],
						$_POST["recaptcha_response_field"]
					);

			if (!$resp->is_valid) {
				echo '<p class="message">Les mots saisis sont incorrects</p>';
			} 
			else {
				$classConnexion->mdpOublier();
			}
		}
		
		?>
		
		<script src="http://www.google.com/recaptcha/api/challenge?k=6LcaQuMSAAAAALVgXsTvvjuggRwmXW3DfhhF-qf9"></script>
		<div id="form-submit">
			<button type="submit">Suivant</button>
		</div>
		<div class="clear"></div>
	</form>
	<p><a href="">Connexion</a> | <a href="../">Retour au site</a></p>
	
	
</section>





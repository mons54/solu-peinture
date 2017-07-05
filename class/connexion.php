<?php

@session_start();

class connexion extends admin {

	public function _connexion($post){
		
		$mdp = $this->hacherMdp($post['password']);
		
		if($mdp != $this->getMdp()) {
			@$_SESSION['connexion']++;
			return 'Le mot de passe est incorrect';
		}
		
		if(!empty($post['rememberme']))
			setcookie('password', $mdp, time() + (365*24*3600), '/', null, false, true);
		
		$_SESSION['admin'] = true;
		$_SESSION['connexion']=0;
		header('location:'.PATH.'/');
	}
	
	public function getCode(){
		return json_decode(file_get_contents(FILE.'json/mdp-oublier.json'), true);
	}
	
	public function verifCode($code){
		if($code != $this->getCode()) {
			@$_SESSION['code']++;
			return false;
		}
		
		$_SESSION['code']=0;
		return true;
	}
	
	public function mdpOublier() {
		
		$str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$shuffled = substr(str_shuffle($str), 0, 8);
		
		$fp = fopen(FILE.'json/mdp-oublier.json', 'w+');
		
		fwrite($fp, json_encode($shuffled));
		
		fclose($fp);
		
		$objet = "Oubli de mot de passe";
		
		$message_txt = "Bonjour, Voici votre code pour obtenir un nouveau mot de passe : ".$shuffled;
				
		$message_html = "
		<html>
			<head>
				<title>Oubli de mot de passe</title>
			</head>
			<body>
				<div style=\"padding:15px\">
					<h3>Oubli de mot de passe</h3>
					<p style=\"padding-top:10px\">Bonjour,</p>
					<p>Voici votre code pour obtenir un nouveau mot de passe :
					<br/>".$shuffled."</p>
				</div>
			</body>
		</html>";
		$this->mail($this->getEmail(), $this->getNom(), $objet, $message_txt, $message_html);
		$_SESSION['code']=0;
		header('location:'.PATH.'/code-password');
	}
}
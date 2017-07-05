<?php
class contacts extends db{
	
	public function sendMail($nom, $email, $tel, $objet, $message){
		
		$tel = !empty($tel) ? $tel : 'Non précisé';
		
		$message_txt = $message;
		
		$message_html = "
		<html>
			<head>
				<title>".$objet."</title>
			</head>
			<body style=\"color:#000\">
				<p>Tél : <b>".$tel."</b></p>
				<h3 style=\"margin-top:10px;border-top:1px solid #DADADA;padding-top:10px\">".$objet."</h3>
				<p>".$message."</p>
			</body>
		</html>";
				
		$this->mail($email, $nom, $objet, $message_txt, $message_html);
		header('location:'.PATH.'/contact/message-envoyer');
	}
	
	protected function mail($email, $nom, $objet, $message_txt, $message_html){
		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $email))
			$passage_ligne = "\r\n";
		else
			$passage_ligne = "\n";
		
		$boundary = "-----=".md5(rand());
		
		$header = "From: \"".$nom."\"<".$email.">".$passage_ligne;
		$header.= "Reply-to: \"".$nom."\"<".$email.">".$passage_ligne;
		$header.= "MIME-Version: 1.0".$passage_ligne;
		$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"".$boundary."\"".$passage_ligne;
		
		$message = $passage_ligne."--".$boundary.$passage_ligne;
		$message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$message_txt.$passage_ligne;
		$message.= $passage_ligne."--".$boundary.$passage_ligne;
		$message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$message_html.$passage_ligne;
		$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
		$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
		
		mail($this->getEmail(),utf8_decode($objet),$message,$header);
	}
	
	public function getContacts() {
		return json_decode(file_get_contents(FILE.'json/contacts.json'));
	}
	
	public function getEmail() {
		$data = json_decode(file_get_contents(FILE.'json/contacts.json'));
		return $data->email;
	}
	
	public function getNom() {
		$data = json_decode(file_get_contents(FILE.'json/contacts.json'));
		return $data->nom;
	}
}
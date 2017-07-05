<?php
class devis extends contacts {
	
	public function sendDevis($post) {
		
		
		$objet = 'Demande de devis';
		
		if(!empty($post['civilite']) && $post['civilite'] == 3)
			$civilite='Mlle';
		elseif(!empty($post['civilite']) && $post['civilite'] == 2)
			$civilite='Mme';
		else
			$civilite='Mr';
			
		$nom = $post['nom'];
		$adresse = $post['adresse'];
		$code_postal = $post['code_postal'];
		$commune = $post['commune'];
		$email= $post['email']; 
		$tel = !empty($post['tel']) ? $post['tel'] : 'Non précisé';
		$departement = $this->getNomDepartement((int) $post['departement']); 
		$ville = $this->getNomVille((int) $post['ville']); 
		$date= $this->getNomDateTravaux((int) $post['date_travaux']);
		$type_construction= $this->getNomTypeConstruction((int) $post['type_construction']);
		
		$_travaux = '';
		$travaux = $this->getTravaux();
		foreach($travaux as $travaux){
			if(!empty($post['travaux_'.$travaux->id]) && $post['travaux_'.$travaux->id] == "on") {
				$__travaux = '<b>'.$this->getNomTravaux($travaux->id).'</b>';
				$_travaux .= $__travaux.'<br/>';
			}
		}
		
		if(empty($_travaux))
			$_travaux='Non précisé';
		
		if(!empty($post['message_devis']))
			$message=nl2br(stripslashes($post['message_devis']));
		else
			$message='Non précisé';
		
		$message_txt = $message;
		
		$message_html = "
		<html>
			<head>
				<title>".$titre."</title>
			</head>
			<body style=\"color:#000;line-height:1.8em\">
				<p>
					<b>".$civilite." ".$nom."</b>
					<br/>".$adresse."
					<br/>".$code_postal." ".$commune."
					<br/>Tel : ".$tel."
				</p>
				<h3 style=\"margin-top:10px;border-top:1px solid #DADADA;padding-top:10px\">Lieu et date des travaux</h3>
				<p>
					Lieu des travaux : <b>".$ville." - ".$departement."</b>
					<br/>Date souhaitée : <b>".$date."</b>
					<br/>Type d'habitat : <b>".$type_construction."</b>
				</p>
				<h3 style=\"margin-top:10px;border-top:1px solid #DADADA;padding-top:10px\">Travaux à effectuer</h3>
				<p>
					".$_travaux."
				</p>
				<h3 style=\"margin-top:10px;border-top:1px solid #DADADA;padding-top:10px\">Description des travaux</h3>
				<p>
					".$message."
				</p>
			</body>
		</html>";
				
		$this->mail($email, $nom, $objet, $message_txt, $message_html);
		header('location:'.PATH.'/devis/message-envoyer');
	}
	
	
	public function getDepartement() {
		$this->sql = 'SELECT * FROM lieu_departements ORDER BY nom';
		$data = $this->fetchAll();
		return $data;
	}
	
	public function getNbDepartement($code) {
		unset($this->exe);
		$this->exe['code'] = $code;
		$this->sql = 'SELECT COUNT(*) nb FROM lieu_departements WHERE code=:code';
		$data = $this->fetch();
		return !empty($data->nb);
	}
	
	public function getNomDepartement($code) {
		if(!$this->getNbDepartement($code))
			return false;
		
		unset($this->exe);
		$this->exe['code'] = $code;
		$this->sql = 'SELECT nom FROM lieu_departements WHERE code=:code';
		$data = $this->fetch();
		return $data->nom;
	}
	
	public function getVille($departement) {
		
		if(!$this->getNbDepartement($departement))
			$departement = 54;
		
		unset($this->exe);
		$this->exe['departement'] = $departement;
		$this->sql = 'SELECT * FROM lieu_communes WHERE departement=:departement ORDER BY nom';
		$data = $this->fetchAll();
		return $data;
	}
	
	public function getNbVille($id) {
		unset($this->exe);
		$this->exe['id'] = $id;
		$this->sql = 'SELECT COUNT(*) nb FROM lieu_communes WHERE id=:id';
		$data = $this->fetch();
		return !empty($data->nb);
	}
	
	public function getNomVille($id) {
		if(!$this->getNbVille($id))
			return false;
		
		unset($this->exe);
		$this->exe['id'] = $id;
		$this->sql = 'SELECT nom FROM lieu_communes WHERE id=:id';
		$data = $this->fetch();
		return $data->nom;
	}
	
	public function getTypeConstruction() {
		$this->sql = 'SELECT * FROM constructions_type ORDER BY nom';
		$data = $this->fetchAll();
		return $data;
	}
	
	public function getNbTypeConstruction($id) {
		unset($this->exe);
		$this->exe['id'] = $id;
		$this->sql = 'SELECT COUNT(*) nb FROM constructions_type WHERE id=:id';
		$data = $this->fetch();
		return !empty($data->nb);
	}
	
	public function getNomTypeConstruction($id) {
		if($this->getNbVille($id)){
			unset($this->exe);
			$this->exe['id'] = $id;
			$this->sql = 'SELECT nom FROM constructions_type WHERE id=:id';
			$data = $this->fetch();
			return $data->nom;
		}
		else{
			return 'Non précisé';
		}
	}
	
	public function getAgeConstruction() {
		$this->sql = 'SELECT * FROM constructions_age ORDER BY id';
		$data = $this->fetchAll();
		return $data;
	}
	
	public function getNbAgeConstruction($id) {
		unset($this->exe);
		$this->exe['id'] = $id;
		$this->sql = 'SELECT COUNT(*) nb FROM constructions_age WHERE id=:id';
		$data = $this->fetch();
		return !empty($data->nb);
	}
	
	public function getNomAgeConstruction($id) {
		if($this->getNbVille($id)){
			unset($this->exe);
			$this->exe['id'] = $id;
			$this->sql = 'SELECT nom FROM constructions_age WHERE id=:id';
			$data = $this->fetch();
			return $data->nom;
		}
		else{
			return 'Non précisé';
		}
	}
	
	public function getDateTravaux() {
		$this->sql = 'SELECT * FROM travaux_date ORDER BY id';
		$data = $this->fetchAll();
		return $data;
	}
	
	public function getNbDateTravaux($id) {
		unset($this->exe);
		$this->exe['id'] = $id;
		$this->sql = 'SELECT COUNT(*) nb FROM travaux_date WHERE id=:id';
		$data = $this->fetch();
		return !empty($data->nb);
	}
	
	public function getNomDateTravaux($id) {
		if($this->getNbDateTravaux($id)){
			unset($this->exe);
			$this->exe['id'] = $id;
			$this->sql = 'SELECT nom FROM travaux_date WHERE id=:id';
			$data = $this->fetch();
			return $data->nom;
		}
		else{
			return 'Non précisé';
		}
	}
	
	public function getTravaux() {
		$this->sql = 'SELECT * FROM travaux ORDER BY id';
		$data = $this->fetchAll();
		return $data;
	}
	
	public function getNomTravaux($id) {
		unset($this->exe);
		$this->exe['id'] = $id;
		$this->sql = 'SELECT nom FROM travaux WHERE id=:id';
		$data = $this->fetch();
		return $data->nom;
	}
}
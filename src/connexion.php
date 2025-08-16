<?php 
// On se connecte à la base de donnée 
	// Je met un try catch pour attraper l'erreur en cas d'echec de connexion à la base de donnée // 
	try{
		$bdd = new PDO('mysql:host=localhost;port=8889;dbname=netflix;charset=utf8', 'root','root'); 
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		

	} catch(PDOException $e) {
		die('Erreur de connexion : ' . $e->getMessage());
	}

  
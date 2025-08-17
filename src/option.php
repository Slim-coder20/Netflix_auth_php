<?php 
if(isset($_COOKIE['auth']) && !isset($_SESSION['connect'])){
  // Connexion à la base de donnée 
  require_once('connexion.php');

  // Variables 
  $secret = htmlspecialchars($_COOKIE['auth']);

  // le secret existe-t-il ? 
  $requete = $bdd->prepare('SELECT COUNT(*) AS secretNumber FROM user WHERE secret = ?');
  $requete->execute([$secret]);

  while($user = $requete->fetch()){
    if($user['secretNumber'] == 1){
      // Lire tout ce qui concerne l'utilisateur 
        $informations = $bdd->prepare('SELECT * FROM user WHERE secret = ?');
        $informations->execute([$secret]);

        while($userInformations = $informations->fetch()){
          		$_SESSION['connect'] = 1;
			        $_SESSION['email'] = $userInformations['email'];
        }
      
    }
  }


}


<?php 
 // Initialisation de session // 
 session_start();

 // On vérifie que le formulaire d'inscription a bien été soumis // 
 if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_two'])){
	

	// connexion à la base de donnée // 
	require_once('src/connexion.php');

	// Variables // 
	$email = htmlspecialchars($_POST['email']); 
	$password = htmlspecialchars($_POST['password']); 
	$passwordTwo = htmlspecialchars($_POST['password_two']);

	// Vérification du mot de passe sont-ils différent ? // 
	if($password != $passwordTwo){
		header('location: inscription.php?error=1&message=Vos mots de passe ne sont pas identique.');
		exit();

	}
	// L'adresse email est elle correct ? 
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		header('location: inscription.php?error=1&message=Votre adresse eamail est invalide.');
		exit();
	}

	// Vérifier que l'adresse email n'a pas été déjà utilisé // 
	$requete = $bdd->prepare('SELECT COUNT(*) as numberEmail FROM user WHERE email = ?');
	$requete->execute([$email]);

	while($emailVerification = $requete->fetch()){
		if($emailVerification['numberEmail'] != 0){
			header('location: inscription.php?error=1&message=Votre adresse email est déjà utilisé par un autre utilisateur.');
			exit();
		}
	}

	// Chiffrement ou hashage  du mot de passe // 
	$password = "aq1".sha1($password."123")."25";

	// générer le secret // 

	$secret = sha1($email).time();
	$secret = sha1($secret).time();

	// Ajouter un utilisateur // 

	$requete = $bdd->prepare('INSERT INTO user(email, password, secret) VALUES (?, ?, ?)');
	$requete->execute([$email,$password, $secret]);

	header('location: inscription.php?success=1');
	exit();

 }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Netflix</title>
	<link rel="stylesheet" type="text/css" href="design/default.css">
	<link rel="icon" type="image/pngn" href="assets/favicon.png">
</head>
<body>

	<?php require_once('src/header.php'); ?>
	
	<section>
		<div id="login-body">
			<h1>S'inscrire</h1>

			<?php 
			 if(isset($_GET['error'] ) && isset($_GET['message'])){
					echo '<div class="alert error">'.htmlspecialchars($_GET['message']).'</div>';
			 } else if(isset($_GET['success'])){
					echo '<div class="alert success">Vous êtes désormais inscrit.<a href="index.php">Connectez-vous</a>.</div>';
			 }
			
			?>

			<form method="post" action="inscription.php">
				<input type="email" name="email" placeholder="Votre adresse email" required />
				<input type="password" name="password" placeholder="Mot de passe" required />
				<input type="password" name="password_two" placeholder="Retapez votre mot de passe" required />
				<button type="submit">S'inscrire</button>
			</form>

			<p class="grey">Déjà sur Netflix ? <a href="index.php">Connectez-vous</a>.</p>
		</div>
	</section>

	<?php require_once('src/footer.php'); ?>
</body>
</html>
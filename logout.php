<?php 
// initialisation de session // 
  session_start();
// desactiver la session // 
  session_unset();
// destruction de la session // 
  session_destroy();
// On détruit le cookies // 
setcookie('auth', '', time() - 1);
  
header('location: index.php');
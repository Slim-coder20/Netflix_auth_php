<?php 
// initialisation de session // 
  session_start();
// desactiver la session // 
  session_unset();
// destruction de la session // 
  session_destroy();
  
header('location: index.php');
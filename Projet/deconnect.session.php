<?php
    // Récupération de la session en cours
	session_start();
	
	// Préparation de la redirection
	header('Location: create.session.php');
	
	// Supression des données de session
	$_SESSION = array();
	$_SESSION['connection_error'] = false;
	$_SESSION['connection_message'] = "";
	
	// Redirection vers la page de connexion
	exit();
?>
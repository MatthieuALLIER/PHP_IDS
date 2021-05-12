<?php
	// Récupération de la session en cours
	session_start();
	
	// Inclusion des fichiers génériques
	include("class.php");
	include("style.css");
	
	// Création Rapide du haut de page
	include("entete.sup.html");
	echo "Connexion";
	include("entete.inf.html");
	
	// Affichage du formulaire de connexion grâce au gabarit form.session.html
	$gab = new Template("./");
	$gab->set_filenames(array("body" => "form.session.html"));	
	$gab->assign_vars(array("error_message" => $_SESSION['connection_message']));
	$gab->pparse("body");
	
	// Inclusion du pied de page
	include("pied.inc.html");
?>
<?php
	// Récupération de la session en cours
	session_start();
	
	// Inclusion des fichiers génériques
	include("class.php");
	include("style.css");
	
	// Création Rapide du haut de page
	include("entete.sup.html");
	echo "Publication";
	include("entete.inf.html");
	include('show.user.php');
	
	// Affichage du formulaire form.post.html
	include("form.post.html");
	
	// Inclusion du pie de page
	include("pied.inc.html");
?>
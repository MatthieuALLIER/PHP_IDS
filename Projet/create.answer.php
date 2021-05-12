<?php
    // Récupération de la session en cours
	session_start();
	
	// Inclusion des fichiers génériques
	include("class.php");
	include("style.css");
	
	// Création Rapide du haut de page
	include("entete.sup.html");
	echo "Répondre";
	include("entete.inf.html");
	include('show.user.php');
	
	// Récupération de l'ID du post et de l'ID de la réponse à laquelle on veut répondre
	$id_post = $_GET["id_post"];
	$reference = $_GET["reference"];
	
	// Affichage du formulaire de création grâce au gabarit form.answer.html
	$gab = new Template("./");
	$gab->set_filenames(array("body" => "form.answer.html"));	
	$gab->assign_vars(array("id_post" => $id_post));
	$gab->assign_vars(array("reference" => $reference));
	$gab->pparse("body");
	
	// Inclusion du pied de page
	include("pied.inc.html");
?>
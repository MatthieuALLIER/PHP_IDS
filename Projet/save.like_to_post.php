<?php
	// Récupération de la session en cours
	session_start();
	
	// Préparation de la redirection
	header('Location: index.php');
	
	// Inclusion des fichiers génériques
	include("connect.inc.php");
	include("class.php");
	
	// Connexion à la base donnée
	try{
	$pdo = new PDO('mysql:host='.$dbhost.';dbname='.$db.'', $dbuser, $dbpasswd);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}catch(PDOExeption $error){
		echo $error->getMessage();
	}
	
	// Récupération des données du formulaire interne à template.post.html
	$id_post = $_GET["id_post"];
	$id_user = $_SESSION["id_user"];
	
	// Recherche pour savoir si le like existe ou pas
	$request_new_id = new request_database($pdo, "SELECT * from post_like as l where l.id_post=".$id_post." and l.id_user=".$id_user);
	$request_new_id->executer();
	$exist_like = $request_new_id->existResult();
	
	if ($exist_like == "false"){
		//Enregistrer en base
		$save_post = new request_database($pdo, "INSERT INTO post_like VALUES ('".$id_post."','".$id_user."')");
		$save_post->executer();
	}
	if ($exist_like == "true"){
		//Supprimer de la base
		$save_post = new request_database($pdo, "DELETE from post_like where id_post=".$id_post." and id_user=".$id_user);
		$save_post->executer();
	}
	
	// Redirection vers la page d'accueil
	exit();
 ?>
<?php
	session_start();
	
	include("connect.inc.php");
	include("class.php");
	
	try{
	$pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}catch(PDOExeption $error){
		echo $error->getMessage();
	}
	
	$data = new formData($_POST);
	$post_ligne = $data->getPostData();
	$title = current(array_slice($post_ligne, 0, 1));
	$text = current(array_slice($post_ligne, 1, 1));
	
	$request_new_id = new request_database($pdo, "SELECT max(post.id_post)+1 from post");
	$request_new_id->executer();
	$id_new_post = $request_new_id->getIndex();
	
	//Recupération de la date actuelle
	$date_new_post = date('Y-m-d H:i:s');
	
	//Enregistrer en base
	$save_post = new request_database($pdo, "INSERT INTO post VALUES ('".$id_new_post."','".$_SESSION['id_user']."','".$title."','".$text."','".$date_new_post."')");
	$save_post->executer();
	
	header('Location: main.php');
	exit;	
 ?>
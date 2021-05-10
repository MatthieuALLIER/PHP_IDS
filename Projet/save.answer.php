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
	$answer_ligne = $data->getPostData();
	$text = $answer_ligne['answer_text'];
	$id_post = $answer_ligne['id_post'];
	$reference = $answer_ligne['reference'];
	
	$request_new_id = new request_database($pdo, "SELECT max(id_answer)+1 from answer");
	$request_new_id->executer();
	$id_new_answer = $request_new_id->getIndex();
	
	//Recupération de la date actuelle
	$date_new_answer = date('Y-m-d H:i:s');
	
	//Enregistrer en base
	$save_post = new request_database($pdo, "INSERT INTO answer VALUES ('".$id_new_answer."','".$id_post."','".$reference."','".$_SESSION['id_user']."','".$text."','".$date_new_answer."')");
	$save_post->executer();
	
	header('Location: main.php');
	exit;	
	
 ?>
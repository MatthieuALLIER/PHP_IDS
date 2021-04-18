<?php
	session_set_cookie_params(0);
	session_start();
	
	include("connect.inc.php");
	include("class.php");
	include("style.css");
	
	//Test si le paramêtre de session 'id_user' existe
	if(!isset($_SESSION['id_user'])){	
		$_SESSION['connection_message'] = "";
		header("Location: create.session.php");
		exit();
	}
	
	//Entête de page
	include("entete.sup.html");
	echo "Forum";
	include("entete.inf.html");
	include('show.user.php');	

	try{
	$pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}catch(PDOExeption $error){
		echo $error->getMessage();
	}
	
	include("link.create.post.html");
	
	$posts = new request_database($pdo, "SELECT pseudo, title, post_text, post_date, a.id_post, count_like, count_answer, COUNT(id_user)
										 FROM (
										 SELECT pseudo, title, post_text, post_date, imb.id_post, count_like, COUNT(id_answer) AS count_answer
										 FROM (
										 SELECT u.pseudo, p.title, p.post_text, p.post_date, p.id_post, COUNT(l.id_user) AS count_like  
										 FROM user as u, post AS p LEFT JOIN liker AS l ON l.id_post=p.id_post
										 WHERE u.id_user=p.id_user 
										 GROUP BY p.id_post) AS imb 
										 LEFT JOIN answer AS a ON a.id_post=imb.id_post
										 GROUP BY imb.id_post) AS a LEFT JOIN (
										 SELECT id_post, id_user
										 FROM liker
										 WHERE id_user=".$_SESSION['id_user'].") AS b ON a.id_post=b.id_post
										 GROUP BY id_post");
	$posts->executer();
	
	foreach ($posts->getResult() as $post){
		$post = new post($post);
		$id_post = $post->getID();
		$post->afficherPost();
		$answers = new request_database($pdo, "SELECT u.pseudo, a.answer_text, a.date 
												FROM user as u, answer as a 
												WHERE u.id_user=a.id_user and a.id_post=".$id_post);
		$answers->executer();
		if ($answers->existResult() == "true"){
			foreach ($answers->getResult() as $answer){
				$answer = new Answer($answer);
				$answer->afficherAnswer();
			}
		}
		include("div.end.html");
	}
	
	include("pied.inc.html");	
?>
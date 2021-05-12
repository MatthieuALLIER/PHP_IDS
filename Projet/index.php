<?php
    // Création de la session PHP (ou récupération)
	session_set_cookie_params(0);
	session_start();
	
	// Test si le paramêtre de session 'id_user' existe
	if(!isset($_SESSION['id_user'])){
	    // Renvoi vers la page de connexion
		$_SESSION['connection_message'] = "";
		header("Location: create.session.php");
		exit();
	}
	
	// Inclusion des fichiers génériques
	include("connect.inc.php");
	include("class.php");
	include("style.css");
	
	// Création Rapide du haut de page
	include("entete.sup.html");
	echo "Forum";
	include("entete.inf.html");
	include('show.user.php');	
    
    // Connexion à la base donnée
	try{
	$pdo = new PDO('mysql:host='.$dbhost.';dbname='.$db.'', $dbuser, $dbpasswd);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}catch(PDOExeption $error){
		echo $error->getMessage();
	}
	
	// Inclusion du bouton de création de post
	include("link.create.post.html");
	
	// Récupération des posts
	$posts = new request_database($pdo, "SELECT pseudo, title, post_text, post_date, a.id_post, count_like, count_answer, COUNT(id_user) as is_liked
										 FROM (
										 SELECT pseudo, title, post_text, post_date, imb.id_post, count_like, COUNT(id_answer) AS count_answer
										 FROM (
										 SELECT u.pseudo, p.title, p.post_text, p.post_date, p.id_post, COUNT(l.id_user) AS count_like  
										 FROM user as u, post AS p LEFT JOIN post_like AS l ON l.id_post=p.id_post
										 WHERE u.id_user=p.id_user 
										 GROUP BY p.id_post) AS imb 
										 LEFT JOIN answer AS a ON a.id_post=imb.id_post
										 GROUP BY imb.id_post) AS a LEFT JOIN (
										 SELECT id_post, id_user
										 FROM post_like
										 WHERE id_user=".$_SESSION['id_user'].") AS b ON a.id_post=b.id_post
										 GROUP BY id_post
										 ORDER BY count_like DESC");
	$posts->executer();
	
	// Pour chaque post
	foreach ($posts->getResult() as $post){
		$post = new post($post);
		$id_post = $post->getID();
		
		// Affichage du post
		$post->afficherPost();
		
        // Recherche des réponses du post
		$answers = new request_database($pdo, "SELECT a.id_answer, pseudo, answer_text, date, reference_answer, count_like, count_answer, is_liked, parent_pseudo
												FROM (
												SELECT a.id_answer, pseudo, answer_text, date, id_post, reference_answer, count_like, count_answer, COUNT(id_user) as is_liked
												FROM (
												SELECT imb.id_answer, pseudo, imb.answer_text, imb.date, imb.id_post, imb.reference_answer, count_like, COUNT(a.id_answer) AS count_answer
												FROM (
												SELECT a.id_answer, u.pseudo, a.answer_text, a.date, a.id_post, a.reference_answer, COUNT(l.id_user) AS count_like  
												FROM post AS p, user as u, answer AS a LEFT JOIN answer_like AS l ON l.id_answer=a.id_answer
												WHERE u.id_user=a.id_user AND p.id_post=a.id_post AND a.id_post=".$id_post." AND reference_answer=0
												GROUP BY a.id_answer) AS imb 
												LEFT JOIN answer AS a ON a.reference_answer=imb.id_answer
												GROUP BY imb.id_answer) AS a LEFT JOIN (
												SELECT id_answer, id_user
												FROM answer_like
												WHERE id_user=".$_SESSION['id_user'].") AS b ON a.id_answer=b.id_answer
												GROUP BY a.id_answer
												ORDER BY count_like DESC) AS a, (
												SELECT pseudo AS parent_pseudo, id_post
												FROM user AS u, post AS p
												WHERE u.id_user=p.id_user) AS b
												WHERE a.id_post=b.id_post
												LIMIT 1");
		$answers->executer();
		
		// Si il y a des réponses :
		if ($answers->existResult() == "true"){
			include("div.bloc.answer.html");
			$answer = current(array_slice($answers->getResult(), 0, 1));
			$answer = new Answer($answer, $id_post);
			// Affichage de la première réponse
			$answer->afficherAnswer();
			$gab = new Template("./");
			// Inclusion du bouton d'affichage du détail des réponses grâce au gabarit template.button.detail.html
			$gab->set_filenames(array("body"=>"template.button.detail.html"));	
			$gab->assign_vars(array("id_post"=>$id_post));
			$gab->pparse("body");
			include("div.end.html");
			include("div.end.html");			
		}
		include("div.end.html");
	}
	
	//Inclusion du pied de page
	include("pied.inc.html");	
?>
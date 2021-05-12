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
	
	// Récupération des données du formulaire de la page create.session.php
	$data = new formData($_POST);
	$session_ligne = $data->getPostData();
	$pseudo = $session_ligne['user'];
	$passwd = $session_ligne['passwd'];
	$type = $session_ligne['submit'];	
	
	// Recherche le pseudo entré dans la BDD
	$save_session = new request_database($pdo, "SELECT * from user where pseudo='".$pseudo."'");
	$save_session->executer();
	
	//Si c'est une connexion
	if ($type == "Connexion"){		
		//Si le pseudo est bien dans la base
		if ($save_session->existResult() == 'true'){			
			//Récupération des données d'user sur le pseudo entré
			$id_user = current(array_slice(current(array_slice($save_session->getResult(), 0, 1)), 0, 1));
			$saved_pseudo = current(array_slice(current(array_slice($save_session->getResult(), 0, 1)), 1, 1));
			$saved_passwd = current(array_slice(current(array_slice($save_session->getResult(), 0, 1)), 2, 1));
			
			//Si les mots de passe correspondent
			if($saved_passwd == $passwd){			
				//Valide la session et donne à l'attribut de session "id_user" la valeur "id_user" du pseudo entré
				$_SESSION["id_user"] = $id_user;
				$_SESSION['user_pseudo'] = $pseudo;
				$_SESSION['connection_error'] = false;
				
			// Si les mots de passe sont différents
			}else{			
				//Affiche une erreur et réaffiche la page de connexion
				$_SESSION = array();
				$_SESSION['connection_error'] = true;
				$_SESSION['connection_message'] = "Mot de passe incorrect";
				header('Location: create.session.php');
				exit();
			}
		//Si il n'y a pas d'user avec ce pseudo
		}else{
			//Affiche une erreur et réaffiche la page de connexion
			$_SESSION = array();
			$_SESSION['connection_error'] = true;
			$_SESSION['connection_message'] = "Ce nom d'utilisateur n'existe pas";
			header('Location: create.session.php');
			exit();
		}
	//Si c'est une inscription
	}else{
		//Si le pseudo entré est nul
		if ($pseudo == '') {
			//Affiche une erreur et réaffiche la page de connexion
			$_SESSION = array();
			$_SESSION['connection_error'] = true;
			$_SESSION['connection_message'] = "Le pseudo ne peut pas être nul";
			header('Location: create.session.php');
			exit();
		}else{
		    //Si le pseudo existe déja
			if ($save_session->existResult() == 'true'){
				//Affiche une erreur et réaffiche la page de connexion
				$_SESSION = array();
				$_SESSION['connection_error'] = true;
				$_SESSION['connection_message'] = "Le pseudo est déjà utilisé";
				header('Location: create.session.php');
				exit();
			//Si le pseudo est libre
			}else{
				//Récupération d'un nouvel ID pour l'user
				$request_new_id = new request_database($pdo, "SELECT max(id_user)+1 from user");
				$request_new_id->executer();
				$id_new_user = $request_new_id->getIndex();
				
				//Enregistrement du nouvel utilisateur en base
				$save_post = new request_database($pdo, "INSERT INTO user VALUES ('".$id_new_user."','".$pseudo."','".$passwd."')");
				$save_post->executer();
				
				//Donne à l'attribut de session "id_user" la valeur "id_user" du pseudo entré
				$_SESSION["id_user"] = $id_new_user;
				$_SESSION['user_pseudo'] = $pseudo;
				$_SESSION['connection_error'] = false;	
			}			
		}
	}
	
	// Redirection vers la page d'accueil
	exit();
?>
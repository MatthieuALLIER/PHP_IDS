<?php
	session_set_cookie_params(0);
	session_start();
	
	include("class.php");
	include("style.css");
	
	include("entete.sup.html");
	echo "Connexion";
	include("entete.inf.html");
	$gab = new Template("./");
	$gab->set_filenames(array("body" => "form.session.html"));	
	$gab->assign_vars(array("error_message" => $_SESSION['connection_message']));
	$gab->pparse("body");
	include("pied.inc.html");
?>
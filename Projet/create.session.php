<?php
	session_set_cookie_params(0);
	session_start();
	
	include("class.php");
	include("style.css");
	
	include("entete.sup.html");
	echo "Connexion";
	include("entete.inf.html");
	if ($_SESSION['connection_error']) {
		$gab = new Template("./");
		$gab->set_filenames(array("body" => "error.connection.message.html"));	
		$gab->assign_vars(array("error_message" => $_SESSION['connection_message']));
		$gab->pparse("body");
	}
	include("form.session.html");
	include("pied.inc.html");
?>
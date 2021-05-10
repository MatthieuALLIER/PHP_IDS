<?php
	session_set_cookie_params(0);
	session_start();
	
	include("class.php");
	include("style.css");
	
	include("entete.sup.html");
	echo "Répondre";
	include("entete.inf.html");
	include('show.user.php');
	
	$id_post = $_GET["id_post"];
	$reference = $_GET["reference"];
	
	$gab = new Template("./");
	$gab->set_filenames(array("body" => "form.answer.html"));	
	$gab->assign_vars(array("id_post" => $id_post));
	$gab->assign_vars(array("reference" => $reference));
	$gab->pparse("body");
	
	include("pied.inc.html");
	
?>
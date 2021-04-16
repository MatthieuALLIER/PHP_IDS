<?php
	session_set_cookie_params(0);
	session_start();
	
	include("class.php");
	include("style.css");
	
	include("entete.sup.html");
	echo "Répondre";
	include("entete.inf.html");
	include('show.user.php');
	
	$id_post=$_GET["id_post"];
	
	$gab = new Template("./");
	$gab->set_filenames(array("body" => "create.answer.tpl.html"));	
	$gab->assign_vars(array("id_post" => $id_post));
	$gab->pparse("body");
	
	include("pied.inc.html");
	
?>
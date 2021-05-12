<?php	
	//Affichage du bandeau utilisateur grâce au gabarit template.message.user.html
	$gab = new Template("./");
	$gab->set_filenames(array("body" => "template.message.user.html"));	
	$gab->assign_vars(array("user_pseudo" => $_SESSION['user_pseudo']));
	$gab->pparse("body");
?>
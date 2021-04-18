<?php
	session_set_cookie_params(0);
	session_start();
	
	include('class.php');
	include("style.css");
	
	include("entete.sup.html");
	echo "Publication";
	include("entete.inf.html");
	include('show.user.php');
	
	include("form.post.html");
	
	include("pied.inc.html");
?>
<?php
	session_start();
	
	$_SESSION = array();
	$_SESSION['connection_error'] = false;
	$_SESSION['connection_message'] = "";
	header('Location: create.session.php');
	exit();
?>
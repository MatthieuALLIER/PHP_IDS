<?php
	session_start();
	
	$_SESSION = array();
	$_SESSION['connection_error'] = false;
	
	header('Location: create.session.php');
	exit();
?>
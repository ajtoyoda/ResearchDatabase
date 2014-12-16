<?php
	require_once("php/login-functions.php");
	if(!verifyLoggedIn()){
		header('Location: /m/login.php');
	}
?>
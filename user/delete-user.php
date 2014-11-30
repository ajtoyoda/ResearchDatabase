<?php
	require_once("../php/user-permissions.php");
	require_once("../php/login-functions.php");
	require_once("../php/delete-user-functions.php");
	verifyLoggedIn();
	if(!isAdministrator()){
		header("Location: /");
	}
	deleteUser();
?>
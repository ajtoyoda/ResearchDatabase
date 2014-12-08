<?php
	require_once("../php/delete-results-functions.php");
	require_once("../php/login-functions.php");
	require_once("../php/gf.php");
	isLoggedOn();
	if(!canWrite($_GET['studyname'], $_SESSION['userid'])){
		header('Location: /');
	}
	deleteResult($_GET['id']);

?>
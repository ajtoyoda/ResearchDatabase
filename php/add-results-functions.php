<?php
function addResult(){
	$mysqli= new mysqli("localhost", "root", "", "researchdatabase");
	if(empty($_POST['username'])||empty($_POST['password']) 
		|| empty($_POST['confirm'])|| empty($_POST['type'])|| empty($_POST['name']) 
		|| empty($_POST['birthmonth'])|| empty($_POST['birthday'])|| empty($_POST['birthyear'])
		|| empty($_POST['gender']) || empty($_POST['addressLine1']) ||!isset($_POST['addressLine2'])
		||empty($_POST['city'])||empty($_POST['country'])
		||empty($_POST['phone'])||empty($_POST['email'])){
		if(isset($_GET['createAttempt'])){
			header("Location: /study/add-result.php?failure&emergencyContact");
		}
		else{
			return;
		}
	}
	if(!$mysqli->query("USE researchdatabase")){
		die("failed to use database");
	}
}
?>
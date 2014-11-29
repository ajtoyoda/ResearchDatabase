<?php
function add_user(){
	$mysqli= new mysqli("localhost", "root", "", "researchdatabase");
	if(!(isset($_POST['username'])&&isset($_POST['password']) && isset($_POST['confirm'])&& isset($_POST['type']))){
		return;
	}
	$username = $_POST['username'];
	$password = $_POST['password'];
	$confirm = $_POST['confirm'];
	$type = $_POST['type'];
	if(!$mysqli->query("USE researchdatabase")){
		die("failed to use database");
	}
	$username = $mysqli->real_escape_string($username);
	$password = $mysqli->real_escape_string($password);
	$confirm = $mysqli->real_escape_string($confirm);
	if($confirm != $password){
		header('Location: add-user.php?failure');
		return;
	}
	$password = password_hash($password, PASSWORD_DEFAULT);
	$query = "INSERT INTO user
			  VALUES(DEFAULT,'$username', '$password', '$type')";
	$result = $mysqli->query($query);
	echo $result;
	if(!$result){
		die('invalid query');
	}
	else
	{
		header('Location: add-user.php?success');
	}
}
?>
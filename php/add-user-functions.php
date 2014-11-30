<?php
//Add users to database, including person and user. DOES NOT DO EMERGENCY CONTACTS YET
function add_user(){
	$mysqli= new mysqli("localhost", "root", "", "researchdatabase");
	if(!(isset($_POST['username'])&&isset($_POST['password']) 
		&& isset($_POST['confirm'])&& isset($_POST['type'])&& isset($_POST['name']) 
		&& isset($_POST['birthmonth'])&& isset($_POST['birthday'])&& isset($_POST['birthyear'])
		&& isset($_POST['gender']) && isset($_POST['addressLine1']) &&isset($_POST['addressLine2'])
		&&isset($_POST['city'])&&isset($_POST['country'])
		&&isset($_POST['phone'])&&isset($_POST['email']))){
		if(isset($_GET['createAttempt'])){
			header("Location: /user/add-user.php?failure");
			return;
		}
		else{
			return;
		}
	}
	$username = $_POST['username'];
	$password = $_POST['password'];
	$confirm = $_POST['confirm'];
	$name = $_POST['name'];
	$birthmonthString = $_POST['birthmonth'];
	$birthmonth = 1;
	if($birthmonthString == "january")$birthmonth = 1;
	elseif($birthmonthString =="february")$birthmonth = 2;
	elseif($birthmonthString =="march")$birthmonth = 3;
	elseif($birthmonthString =="april")$birthmonth = 4;
	elseif($birthmonthString =="may")$birthmonth = 5;
	elseif($birthmonthString =="june")$birthmonth = 6;
	elseif($birthmonthString =="july")$birthmonth = 7;
	elseif($birthmonthString =="august")$birthmonth = 8;
	elseif($birthmonthString =="september")$birthmonth = 9;
	elseif($birthmonthString =="october")$birthmonth = 10;
	elseif($birthmonthString =="november")$birthmonth = 11;
	else $birthmonth = 12;
	
	//Getting birthday into date format
	$time = mktime(0,0,0, $birthmonth, (int)$_POST['birthday'], (int)$_POST['birthyear']);
	if($time < mktime(0,0,0,1,1,1900) || $time >time()){
		die("Invalid birthday magic");
	}
	$birthday = date('Y-m-d', $time);
	
	$type = $_POST['type'];
	$gender= $_POST['gender'];
	$address = $_POST['addressLine1'] ."|". $_POST['addressLine2'] ."|". $_POST['city'] ."|". $_POST['country'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	if(!$mysqli->query("USE researchdatabase")){
		die("failed to use database");
	}
	$username = $mysqli->real_escape_string($username);
	$password = $mysqli->real_escape_string($password);
	$confirm = $mysqli->real_escape_string($confirm);
	$name = $mysqli->real_escape_string($name);
	$address = $mysqli->real_escape_string($address);
	$phone = $mysqli->real_escape_string($phone);
	$email = $mysqli->real_escape_string($email);
	
	if($confirm != $password){
		echo "Invalid Password";
		header('Location: add-user.php?failure');
		return;
	}
	$password = password_hash($password, PASSWORD_DEFAULT);
	
	$query = 	"INSERT INTO person
				VALUES(DEFAULT, '$birthday', '$gender', '$name', '$phone', '$address', '$email', NULL)";
	if(!$result = $mysqli->query($query)){
		die("invalid query 1");
	}
	else
	{
		$query = "SELECT max(id) AS id FROM person";
		if(!($result =$mysqli->query($query))){
			die("invalid query 3");
		}
		$userID = (int)$result->fetch_assoc()['id'];
		$query = "INSERT INTO user
			VALUES($userID,'$username', '$password', '$type')";
		$result = $mysqli->query($query);
		if(!$result){
			echo $query;
			die('invalid query1');
		}
		if(!$result){
			$mysqli->query("DELETE FROM user WHERE user.username = '$username'");
			die('invalid query2');
		}
		else{
			header('Location: add-user.php?success');
			return;
		}
	}
}
?>
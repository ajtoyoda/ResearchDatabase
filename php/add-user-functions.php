<?php
function addEmergencyContact($ID){
	$mysqli = new mysqli("localhost", "root", "", "researchdatabase");
	
	if(!$mysqli->query("USE researchdatabase")){
		die("failed to use database");
	}
	if( empty($_POST['emergname']) || empty($_POST['emergbirthmonth'])|| empty($_POST['emergbirthday'])|| empty($_POST['emergbirthyear'])
		|| empty($_POST['emerggender']) || empty($_POST['emergaddressLine1']) ||!isset($_POST['emergaddressLine2'])
		||empty($_POST['emergcity'])||empty($_POST['emergcountry'])
		||empty($_POST['emergphone'])||empty($_POST['emergemail'])){
			header("Location: /user/add-user.php?failure&emergencyContact");
	}
	$name = $_POST['emergname'];
	$birthmonthString = $_POST['emergbirthmonth'];
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
	$time = mktime(0,0,0, $birthmonth, (int)$_POST['emergbirthday'], (int)$_POST['emergbirthyear']);
	if($time < mktime(0,0,0,1,1,1900) || $time >time()){
		die("Invalid birthday magic");
	}
	$birthday = date('Y-m-d', $time);
	
	$gender= $_POST['emerggender'];
	$address = $_POST['emergaddressLine1'] ."|". $_POST['emergaddressLine2'] ."|". $_POST['emergcity'] ."|". $_POST['emergcountry'];
	$phone = $_POST['emergphone'];
	$email = $_POST['emergemail'];
	$name = $mysqli->real_escape_string($name);
	$address = $mysqli->real_escape_string($address);
	$phone = $mysqli->real_escape_string($phone);
	$email = $mysqli->real_escape_string($email);
	$query = "INSERT INTO person VALUES(DEFAULT, '$birthday', '$gender', '$name', '$phone', '$address', '$email', NULL)";
	if(!$result = $mysqli->query($query)){
		echo $query;
		die("invalid query 1");
	}else{
		$query = "SELECT max(id) AS id FROM person";
		if(!($result = $mysqli->query($query))){
			die("invalid query 2");
		}
		$userID = (int)$result->fetch_assoc()['id'];
		$query ="UPDATE TABLE person SET emergency_id =$userID WHERE id = $ID";
		if(!$mysqli->query($query)){
			$mysqli->query("DELETE FROM person WHERE id = $userID");
		}
		return;
	}
}
//Add users to database, including person and user. DOES NOT DO EMERGENCY CONTACTS YET
function add_user(){
	$mysqli= new mysqli("localhost", "root", "", "researchdatabase");
	if(empty($_POST['username'])||empty($_POST['password']) 
		|| empty($_POST['confirm'])|| empty($_POST['type'])|| empty($_POST['name']) 
		|| empty($_POST['birthmonth'])|| empty($_POST['birthday'])|| empty($_POST['birthyear'])
		|| empty($_POST['gender']) || empty($_POST['addressLine1']) ||!isset($_POST['addressLine2'])
		||empty($_POST['city'])||empty($_POST['country'])
		||empty($_POST['phone'])||empty($_POST['email'])){
		if(isset($_GET['createAttempt'])){
			if(isset($_GET['emergencyContact'])){
			header("Location: /user/add-user.php?failure&emergencyContact");
			}
			else{
			header("Location: /user/add-user.php?failure");
			}
			return;
		}
		else{
			return;
		}
	}
	if(!$mysqli->query("USE researchdatabase")){
		die("failed to use database");
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
	$username = $mysqli->real_escape_string($username);
	$password = $mysqli->real_escape_string($password);
	$confirm = $mysqli->real_escape_string($confirm);
	$name = $mysqli->real_escape_string($name);
	$address = $mysqli->real_escape_string($address);
	$phone = $mysqli->real_escape_string($phone);
	$email = $mysqli->real_escape_string($email);
	
	if($confirm != $password){
		echo "Invalid Password";
		if(isset($_GET['emergencyContact'])){
			header("Location: /user/add-user.php?failureInvalidPassword&emergencyContact");
		}
		else{
			header("Location: /user/add-user.php?failureInvalidPassword");
		}
		return;
	}
	$password = password_hash($password, PASSWORD_DEFAULT);
	
	$query = 	"INSERT INTO person
				VALUES(DEFAULT, '$birthday', '$gender', '$name', '$phone', '$address', '$email', NULL)";
	if(!$result = $mysqli->query($query)){
		echo "first part".$query;
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
			$mysqli->query("DELETE FROM person WHERE id = $userID");
			die('invalid query2');
		}
		else{
			if(isset($_GET['emergencyContact'])){
				addEmergencyContact($userID);
			}
			header('Location: /users.php?successfulAddUser');
			return;
		}
	}
}
?>
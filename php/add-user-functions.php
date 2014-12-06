<?php
	require_once("gf.php");
	
	//Given person id adds another person to the database and sets $ID's emergencyContact to be them
	function addEmergencyContact($ID){
		$mysqli = mysqliInit();
		if( empty($_POST['emergname']) || empty($_POST['emergbirthmonth'])|| empty($_POST['emergbirthday'])|| empty($_POST['emergbirthyear'])
			|| empty($_POST['emerggender']) || empty($_POST['emergaddressLine1']) ||!isset($_POST['emergaddressLine2'])
			||empty($_POST['emergcity'])||empty($_POST['emergcountry'])
			||empty($_POST['emergphone'])||empty($_POST['emergemail'])){
				header("Location: /user/add-user.php?failure&emergencyContact");
		}
	
		$name = $_POST['emergname'];
		$birthmonthString = $_POST['emergbirthmonth'];
		$birthday = formatDate((int)$_POST['emergbirthday'], $birthmonthString, (int)$_POST['emergbirthyear']);
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
			$data = queryAssoc($mysqli, $query);
			$userID = $data['id'];
			$query ="UPDATE person SET emergency_id =$userID WHERE id = $ID";
			if(!$mysqli->query($query)){
				$mysqli->query("DELETE FROM person WHERE id = $userID");
				echo $query;
				die("Failed query outside function");
			}
		}
	}
	//Add users to database, including person and user. DOES NOT DO EMERGENCY CONTACTS YET
	function add_user(){
		if(!isset($_GET['createAttempt'])){
			return;
		}
		echo 1;
		$mysqli= mysqliInit();
		if(empty($_POST['username'])||empty($_POST['password']) 
			|| empty($_POST['confirm'])|| empty($_POST['type'])|| empty($_POST['name']) 
			|| empty($_POST['birthmonth'])|| empty($_POST['birthday'])|| empty($_POST['birthyear'])
			|| empty($_POST['gender']) || empty($_POST['addressLine1']) ||!isset($_POST['addressLine2'])
			||empty($_POST['city'])||empty($_POST['country'])
			||empty($_POST['phone'])||empty($_POST['email'])){
			if(isset($_GET['emergencyContact'])){
				header("Location: /user/add-user.php?failure&emergencyContact");
			}
			else{
				header("Location: /user/add-user.php?failure");
			}
			return;
		}
		
		//Get info from post
		$username = $_POST['username'];
		$password = $_POST['password'];
		$confirm = $_POST['confirm'];
		$name = $_POST['name'];
		$birthmonthString = $_POST['birthmonth'];
		$birthday = formatDate((int)$_POST['birthday'], $birthmonthString, (int)$_POST['birthyear']);
		$type = $_POST['type'];
		$gender= $_POST['gender'];
		$address = $_POST['addressLine1'] ."|". $_POST['addressLine2'] ."|". $_POST['city'] ."|". $_POST['country'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
	
		//Escape strings
		$username = $mysqli->real_escape_string($username);
		$password = $mysqli->real_escape_string($password);
		$confirm = $mysqli->real_escape_string($confirm);
		$name = $mysqli->real_escape_string($name);
		$address = $mysqli->real_escape_string($address);
		$phone = $mysqli->real_escape_string($phone);
		$email = $mysqli->real_escape_string($email);
	
		//Check passwords match
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
			echo $query;
			die("Failure query outside");
		}
		else
		{
			//Newest user will have max id
			$query = "SELECT max(id) AS id FROM person";
			$data = queryAssoc($mysqli, $query);
			$userID = $data['id'];
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
			
			}
		}
	}
?>
<?php
	require_once("gf.php");
	
	//Given person id adds another person to the database and sets $ID's emergencyContact to be them
	function addEmergencyContact($ID){
		$mysqli = mysqliInit();
		if( empty($_POST['emergname']) || empty($_POST['emergbirthmonth'])|| empty($_POST['emergbirthday'])|| empty($_POST['emergbirthyear'])
			|| empty($_POST['emerggender']) || empty($_POST['emergaddressLine1']) ||!isset($_POST['emergaddressLine2'])
			||empty($_POST['emergcity'])||empty($_POST['emergcountry'])
			||empty($_POST['emergphone'])||empty($_POST['emergemail'])){
				header("Location: /user/add-user.php?failureNotSet&emergencyContact");
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
	
	//Add patient to database, including person and patient. DOES NOT DO EMERGE SIMULTANEOUSLY
	function addPatient(){
		if (!isset($_GET['createAttempt'])){
			return;
		}
		
		$mysqli = mysqliInit();
		if(empty($_POST['name'])||empty($_POST['birthday'])||empty($_POST['birthmonth'])||empty($_POST['birthyear'])||empty($_POST['gender'])||empty($_POST['addressLine1'])||empty($_POST['addressLine2'])||empty($_POST['city'])||empty($_POST['country'])||empty($_POST['phone'])||empty($_POST['email'])||empty($_POST['healthcareNumber'])||empty($_POST['hieght'])||empty($_POST['weight']))
		{
			if(isset($_GET['emergencyContact']))
			{
				header("Location: /patient/add-patient.php?failure&emergencyContact");
			}
			else{
				header("Location: /patient/add-patient.php?failure");
			}
		}
		
		//Get info from post
		$name = $_POST['name'];
		$birthdmonthString = $_POST['birthmonth'];
		$birthday = formatDate((int)$_POST['birthday'], $birthdmonthString, (int)$_POST['birthyear']);
		$gender = $_POST['gender'];
		$address = $_POST['addressLine1'] ."|". $_POST['addressLine2'] ."|". $_POST['city'] ."|". $_POST['country'];
		$phone = validatePhoneNumber($_POST['phone']);
		$email = $_POST['email'];
		$hcN = $_POST['healthcareNumber'];
		$height = (int)$_POST['height'];
		$weight = (int)$_POST['weight'];

		if($phone == ""){
			header("Location: /patient/add-patient.php?failureBadPhone");
			return;
			
		}
		
		//Escape strings
		$name = $mysqli->real_escape_string($name);
		$address = $mysqli->real_escape_string($address);
		$phone = $mysqli->real_escape_string($phone);
		$email = $mysqli->real_escape_string($email);
		$hcN = $mysqli -> real_escape_string($hcN);
		
		$query = 	"INSERT INTO person
					VALUES(DEFAULT, '$birthday', '$gender', '$name', '$phone', '$address', '$email', NULL)";
		if(!$result = $mysqli->query($query)){
			echo $query;
			die("Failure query outside");
		}
		else{
			//Newest user will have max id
			$query = "SELECT max(id) AS id FROM person";
			$data = queryAssoc($mysqli, $query);
			$userID = $data['id'];
			$query = 	"INSERT INTO patient
						VALUES($userID, '$hcN', '$weight', '$height')";
			$result = $mysqli->query($query);
			if(!$result){
				$mysqli->query("DELETE FROM person WHERE id = $userID");
				die('invalid query2');
			}
			else{
				if(isset($_GET['emergencyContact'])){
					addEmergencyContact($userID);
				}
				header('Location: /patients.php?successfulAddUser');
						
		}
	}
	}
	
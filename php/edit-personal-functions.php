<?php
	require_once("gf.php");
	function editEmergencyContactPersonal($ID){
		$mysqli = mysqliInit();
		if( empty($_POST['emergname']) || empty($_POST['emergbirthmonth'])|| empty($_POST['emergbirthday'])|| empty($_POST['emergbirthyear'])
			|| empty($_POST['emerggender']) || empty($_POST['emergaddressLine1']) ||!isset($_POST['emergaddressLine2'])
			||empty($_POST['emergcity'])||empty($_POST['emergcountry'])
			||empty($_POST['emergphone'])||empty($_POST['emergemail'])){
				header("Location: /patient/edit-personal.php?ID=".$_GET['ID']."&amp;failure&emergencyContact");
		}
		//Check if person already has emergency contact
		if(!($result =$mysqli->query("SELECT emergency_id FROM person WHERE id = $ID"))){
			die("Invalid query for check");
		}else{
			if($result->num_rows == 0){
				$emergencyID = NULL;
			}
			else{
				$data = $result->fetch_assoc();
				$emergencyID=$data['emergency_id'];
			}
		}
		
		//Get posted values
		$name = $_POST['emergname'];
		$birthmonthString = $_POST['emergbirthmonth'];
		$birthday = formatDate((int)$_POST['emergbirthday'], $birthmonthString, (int)$_POST['emergbirthyear']);
		$gender= $_POST['emerggender'];
		$address = $_POST['emergaddressLine1'] ."|". $_POST['emergaddressLine2'] ."|". $_POST['emergcity'] ."|". $_POST['emergcountry'];
		$phone = $_POST['emergphone'];
		$email = $_POST['emergemail'];
		//Add in escape characters
		$name = $mysqli->real_escape_string($name);
		$address = $mysqli->real_escape_string($address);
		$phone = $mysqli->real_escape_string($phone);
		$email = $mysqli->real_escape_string($email);
		
		if($emergencyID == NULL){
			$query = "INSERT INTO person VALUES(DEFAULT, '$birthday', '$gender', '$name', '$phone', '$address', '$email', NULL)";
			if(!$result = $mysqli->query($query)){
				echo $query;
				die("invalid query 1");
			}
			else{
				$query = "SELECT max(id) AS id FROM person";
				$data = queryAssoc($mysqli, $query);
				$userID = $data['id'];
				$query ="UPDATE person SET emergency_id =$userID WHERE id = $ID";
				queryNoReturn($mysqli, $query);
			}
		}
		else{
			$query = "UPDATE person SET birthday = '$birthday', gender = '$gender', name = '$name', phone = '$phone',
				address = '$address', email = '$email' WHERE id = $emergencyID";
			queryNoReturn($mysqli, $query);
		}
	}
	function editPersonal(){
		if(!isset($_GET['editAttempt'])){
			return;
		}
		$userID = $_GET['ID'];
		$mysqli= mysqliInit();
		if(empty($_POST['name']) 
			|| empty($_POST['birthmonth'])|| empty($_POST['birthday'])|| empty($_POST['birthyear'])
			|| empty($_POST['gender']) || empty($_POST['addressLine1']) ||!isset($_POST['addressLine2'])
			||empty($_POST['city'])||empty($_POST['country'])
			||empty($_POST['phone'])||empty($_POST['email'])){
			if(isset($_GET['emergencyContact'])){
				header("Location: /patient/edit-personal.php?ID=".$userID."&failure&emergencyContact");
			}
			else{
				header("Location: /patient/edit-personal.php?ID=".$userID."&failure");
			}
		}
		//get posted data
		$name = $_POST['name'];
		$birthmonthString = $_POST['birthmonth'];
		$birthday= formatDate((int)$_POST['birthday'], $birthmonthString,  (int)$_POST['birthyear']);
		$gender= $_POST['gender'];
		$address = $_POST['addressLine1'] ."|". $_POST['addressLine2'] ."|". $_POST['city'] ."|". $_POST['country'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		//Escape characters
		$name = $mysqli->real_escape_string($name);
		$address = $mysqli->real_escape_string($address);
		$phone = $mysqli->real_escape_string($phone);
		$email = $mysqli->real_escape_string($email);
	
		$query = 	"UPDATE person
				SET birthday ='$birthday', gender = '$gender', name = '$name', phone= '$phone', address= '$address', email='$email'
				WHERE id = $userID";
		$result = $mysqli->query($query);
		if(!$result){
			die('Failure query outside');
			return;
		}
		else{
			if(isset($_GET['emergencyContact'])){
				editEmergencyContactPersonal($userID);
			}
			if($place == 'self'){
				header("Location: /account.php?userID=".$userID);
			}else{
				header("Location: /patient/view-personal.php?ID=".$_GET['ID']."&amp;successfulEditPersonal");
			}
		}
	}
?>
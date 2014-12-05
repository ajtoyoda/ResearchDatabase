<?php
	require_once("gf.php");
	//This function edits the emergency contact of the person whose id is given
	function editEmergencyContact($ID){
		$mysqli = mysqliInit();
		if( empty($_POST['emergname']) || empty($_POST['emergbirthmonth'])|| empty($_POST['emergbirthday'])|| empty($_POST['emergbirthyear'])
			|| empty($_POST['emerggender']) || empty($_POST['emergaddressLine1']) ||!isset($_POST['emergaddressLine2'])
			||empty($_POST['emergcity'])||empty($_POST['emergcountry'])
			||empty($_POST['emergphone'])||empty($_POST['emergemail'])){
				header("Location: /user/add-user.php?failure&emergencyContact");
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
			$query = "UPDATE person SET birthday = '$birthday', gender = $gender, name = '$name', phone = '$phone'
				address = '$address', email = '$email' WHERE id = $emergencyID";
			queryNoReturn($mysqli, $query);
		}
	}
	
	//This output specifically formatted numbers from range $startRange to $endRange
	function outputOptionNumbers($startRange, $endRange){
		if($startRange > 31 or $startRange < 1 or $endRange < $startRange or $endRange > 31){
			return;
		}
		for($count = $startRange; $count <= $endRange; $count++){
			echo "<option value=\"".$count."\">".$count."</option>";
		}
	}
	
	//This function return an associated array related to the person with id== userID
	function getPerson($userID){
		$mysqli = mysqliInit();
		$query = "SELECT id, birthday, gender, name, phone, address, email, emergency_id FROM person WHERE id = '$userID'";
		return queryAssoc($mysqli, $query);
	}
	
	//This function return an associated user related to the user with user==userID
	function getUser($userID){
		$mysqli = mysqliInit();
		$query = "SELECT id,username, password, type_flag AS type FROM user WHERE id = '$userID'";
		return queryAssoc($mysqli, $query);
	}
	//This function outputs the months with the monthSelected as selected. 
	//This is also needlessly long
	function outputOptionMonths($monthSelected){
	if($monthSelected == 1){
	echo "<option value=\"january\" selected=\"selected\">January</option>
                        <option value=\"february\">February</option>
                        <option value=\"march\">March</option>
                        <option value=\"april\">April</option>
                        <option value=\"may\">May</option>
                        <option value=\"june\">June</option>
                        <option value=\"july\">July</option>
                        <option value=\"august\">August</option>
                        <option value=\"september\">September</option>
                        <option value=\"october\">October</option>
                        <option value=\"november\">November</option>
                        <option value=\"december\">December</option>";
	}
	elseif($monthSelected ==2){
		echo "<option value=\"january\" >January</option>
                        <option value=\"february\" selected=\"selected\">February</option>
                        <option value=\"march\">March</option>
                        <option value=\"april\">April</option>
                        <option value=\"may\">May</option>
                        <option value=\"june\">June</option>
                        <option value=\"july\">July</option>
                        <option value=\"august\">August</option>
                        <option value=\"september\">September</option>
                        <option value=\"october\">October</option>
                        <option value=\"november\">November</option>
                        <option value=\"december\">December</option>";
	}
	elseif($monthSelected ==3){
		echo "<option value=\"january\">January</option>
                        <option value=\"february\">February</option>
                        <option value=\"march\" selected=\"selected\">March</option>
                        <option value=\"april\">April</option>
                        <option value=\"may\">May</option>
                        <option value=\"june\">June</option>
                        <option value=\"july\">July</option>
                        <option value=\"august\">August</option>
                        <option value=\"september\">September</option>
                        <option value=\"october\">October</option>
                        <option value=\"november\">November</option>
                        <option value=\"december\">December</option>";
	}
	elseif($monthSelected ==4){
		echo "<option value=\"january\" >January</option>
                        <option value=\"february\">February</option>
                        <option value=\"march\">March</option>
                        <option value=\"april\" selected=\"selected\">April</option>
                        <option value=\"may\">May</option>
                        <option value=\"june\">June</option>
                        <option value=\"july\">July</option>
                        <option value=\"august\">August</option>
                        <option value=\"september\">September</option>
                        <option value=\"october\">October</option>
                        <option value=\"november\">November</option>
                        <option value=\"december\">December</option>";
	}
	elseif($monthSelected ==5){
		echo "<option value=\"january\" >January</option>
                        <option value=\"february\">February</option>
                        <option value=\"march\">March</option>
                        <option value=\"april\">April</option>
                        <option value=\"may\" selected=\"selected\">May</option>
                        <option value=\"june\">June</option>
                        <option value=\"july\">July</option>
                        <option value=\"august\">August</option>
                        <option value=\"september\">September</option>
                        <option value=\"october\">October</option>
                        <option value=\"november\">November</option>
                        <option value=\"december\">December</option>";
	}
	elseif($monthSelected ==6){
		echo "<option value=\"january\" >January</option>
                        <option value=\"february\">February</option>
                        <option value=\"march\">March</option>
                        <option value=\"april\">April</option>
                        <option value=\"may\">May</option>
                        <option value=\"june\" selected=\"selected\">June</option>
                        <option value=\"july\">July</option>
                        <option value=\"august\">August</option>
                        <option value=\"september\">September</option>
                        <option value=\"october\">October</option>
                        <option value=\"november\">November</option>
                        <option value=\"december\">December</option>";
	}
	elseif($monthSelected ==7){
		echo "<option value=\"january\" >January</option>
                        <option value=\"february\">February</option>
                        <option value=\"march\">March</option>
                        <option value=\"april\">April</option>
                        <option value=\"may\">May</option>
                        <option value=\"june\">June</option>
                        <option value=\"july\" selected=\"selected\">July</option>
                        <option value=\"august\">August</option>
                        <option value=\"september\">September</option>
                        <option value=\"october\">October</option>
                        <option value=\"november\">November</option>
                        <option value=\"december\">December</option>";
	}
	elseif($monthSelected ==8){
		echo "<option value=\"january\" >January</option>
                        <option value=\"february\">February</option>
                        <option value=\"march\">March</option>
                        <option value=\"april\">April</option>
                        <option value=\"may\">May</option>
                        <option value=\"june\">June</option>
                        <option value=\"july\">July</option>
                        <option value=\"august\" selected=\"selected\">August</option>
                        <option value=\"september\">September</option>
                        <option value=\"october\">October</option>
                        <option value=\"november\">November</option>
                        <option value=\"december\">December</option>";
	}
	elseif($monthSelected ==9){
		echo "<option value=\"january\" >January</option>
                        <option value=\"february\">February</option>
                        <option value=\"march\">March</option>
                        <option value=\"april\">April</option>
                        <option value=\"may\">May</option>
                        <option value=\"june\">June</option>
                        <option value=\"july\">July</option>
                        <option value=\"august\">August</option>
                        <option value=\"september\" selected=\"selected\">September</option>
                        <option value=\"october\">October</option>
                        <option value=\"november\">November</option>
                        <option value=\"december\">December</option>";
	}
	elseif($monthSelected ==10){
		echo "<option value=\"january\" >January</option>
                        <option value=\"february\">February</option>
                        <option value=\"march\">March</option>
                        <option value=\"april\">April</option>
                        <option value=\"may\">May</option>
                        <option value=\"june\">June</option>
                        <option value=\"july\">July</option>
                        <option value=\"august\">August</option>
                        <option value=\"september\">September</option>
                        <option value=\"october\" selected=\"selected\">October</option>
                        <option value=\"november\">November</option>
                        <option value=\"december\">December</option>";
	}
	elseif($monthSelected ==11){
		echo "<option value=\"january\" >January</option>
                        <option value=\"february\">February</option>
                        <option value=\"march\">March</option>
                        <option value=\"april\">April</option>
                        <option value=\"may\">May</option>
                        <option value=\"june\">June</option>
                        <option value=\"july\">July</option>
                        <option value=\"august\">August</option>
                        <option value=\"september\">September</option>
                        <option value=\"october\">October</option>
                        <option value=\"november\" selected=\"selected\">November</option>
                        <option value=\"december\">December</option>";
	}
	else{
		echo "<option value=\"january\" >January</option>
                        <option value=\"february\">February</option>
                        <option value=\"march\">March</option>
                        <option value=\"april\">April</option>
                        <option value=\"may\">May</option>
                        <option value=\"june\">June</option>
                        <option value=\"july\">July</option>
                        <option value=\"august\">August</option>
                        <option value=\"september\">September</option>
                        <option value=\"october\">October</option>
                        <option value=\"november\">November</option>
                        <option value=\"december\" selected=\"selected\">December</option>";
	}
	
	
	
	}
	//This function takes the values of the user to be edited and updates the database
	function editUser(){
		if(!isset($_GET['editAttempt'])){
			return;
		}
		$userID = $_GET['userID'];
		$mysqli= mysqliInit();
		if(empty($_POST['username'])||empty($_POST['password']) 
			|| empty($_POST['confirm'])|| empty($_POST['type'])|| empty($_POST['name']) 
			|| empty($_POST['birthmonth'])|| empty($_POST['birthday'])|| empty($_POST['birthyear'])
			|| empty($_POST['gender']) || empty($_POST['addressLine1']) ||!isset($_POST['addressLine2'])
			||empty($_POST['city'])||empty($_POST['country'])
			||empty($_POST['phone'])||empty($_POST['email'])){
			if(isset($_GET['emergencyContact'])){
				header("Location: /user/edit-user.php?userID=".$userID."&failure&emergencyContact");
			}
			else{
				header("Location: /user/edit-user.php?userID=".$userID."&failure");
			}
		}
		//get posted data
		$username = $_POST['username'];
		$password = $_POST['password'];
		$confirm = $_POST['confirm'];
		$name = $_POST['name'];
		$birthmonthString = $_POST['birthmonth'];
		$birthday= formatDate((int)$_POST['birthday'], $birthmonthString,  (int)$_POST['birthyear']);
		$type = $_POST['type'];
		$gender= $_POST['gender'];
		$address = $_POST['addressLine1'] ."|". $_POST['addressLine2'] ."|". $_POST['city'] ."|". $_POST['country'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		//Escape characters
		$username = $mysqli->real_escape_string($username);
		$password = $mysqli->real_escape_string($password);
		$confirm = $mysqli->real_escape_string($confirm);
		$name = $mysqli->real_escape_string($name);
		$address = $mysqli->real_escape_string($address);
		$phone = $mysqli->real_escape_string($phone);
		$email = $mysqli->real_escape_string($email);
	
		//Make sure passwords match
		if($confirm != $password){
			if(isset($_GET['emergencyContact'])){
				header("Location: /user/edit-user.php?userID=".$userID."&failureInvalidPassword&emergencyContact");
			}
			else{
				header("Location: /user/edit-user.php?userID=".$userID."&failureInvalidPassword");
			}
			return;
		}
		$password = password_hash($password, PASSWORD_DEFAULT);
 
		$query = "UPDATE user
			SET username = '$username', password = '$password', type_flag = '$type' 
			WHERE id = $userID";
		$result = $mysqli->query($query);
		if(!$result){
			echo $query;
			die('Failure query outside');
			return;
		}
		else
		{
			$query = 	"UPDATE person
					SET birthday ='$birthday', gender = '$gender', name = '$name', phone= '$phone', address= '$address', email='$email'
					WHERE id = $userID";
			$result = $mysqli->query($query);
			if(!$result){
				$mysqli->query("DELETE FROM user WHERE user.name = '$username'");
				echo $query;
				die('Failure query outside');
				return;
			}
			else{
				if(isset($_GET['emergencyContact'])){
					editEmergencyContact($userID);
				}
				header("Location: /users.php?successfulEditUser");
			}
		}
}
?>
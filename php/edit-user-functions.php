<?php
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
		$mysqli = new mysqli("localhost", "root", "", "researchdatabase");
		if(!$mysqli->query("USE researchdatabase")){
			die("Failed to use database");
		}
		$query = "SELECT id, birthday, gender, name, phone, address, email, emergency_id FROM person WHERE id = '$userID'";
		$result = $mysqli->query($query);
		if(!$result){
			die("Invalid query 1");
			return;
		}
		if($result->num_rows < 1){
			die("Invalid page programming error");
			return;
		}
		$data = $result->fetch_assoc();
		return $data;
	}
	//This function return an associated user related to the user with user==userID
	function getUser($userID){
		$mysqli = new mysqli("localhost", "root", "", "researchdatabase");
		if(!$mysqli->query("USE researchdatabase")){
			die("Failed to use database");
		}
		$query = "SELECT id,username, password, type_flag AS type FROM user WHERE id = '$userID'";
		$result = $mysqli->query($query);
		if(!$result){
			die("Invalid query 1");
		}
		if($result->num_rows < 1){
			die("Invalid page programming error");
		}
		$data = $result->fetch_assoc();
		return $data;
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
                        <option value=\"february\"selected=\"selected\">February</option>
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
                        <option value=\"april\"selected=\"selected\">April</option>
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
                        <option value=\"august\"selected=\"selected\">August</option>
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
                        <option value=\"november\"selected=\"selected\">November</option>
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
                        <option value=\"december\"selected=\"selected\">December</option>";
	}
	
	
	
	}
	//This function takes the values of the user to be edited and updates the database
	function editUser(){

	$userID = $_GET['userID'];
	$mysqli= new mysqli("localhost", "root", "", "researchdatabase");
	if(empty($_POST['username'])||empty($_POST['password']) 
		|| empty($_POST['confirm'])|| empty($_POST['type'])|| empty($_POST['name']) 
		|| empty($_POST['birthmonth'])|| empty($_POST['birthday'])|| empty($_POST['birthyear'])
		|| empty($_POST['gender']) || empty($_POST['addressLine1']) ||!isset($_POST['addressLine2'])
		||empty($_POST['city'])||empty($_POST['country'])
		||empty($_POST['phone'])||empty($_POST['email'])){
		if(isset($_GET['editAttempt'])){
			header("Location: /user/edit-user.php?userID=".$userID."&failure");
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
		header('Location: edit-user.php?userID='.$userID.'&failureInvalidPassword');
		return;
	}
	$password = password_hash($password, PASSWORD_DEFAULT);
 
	$query = "UPDATE user
			SET username = '$username', password = '$password', type_flag = '$type' 
			WHERE id = $userID";
	echo $query;
	$result = $mysqli->query($query);
	if(!$result){
		die('invalid query1');
		return;
	}
	else
	{
		$query = 	"UPDATE person
					SET birthday ='$birthday', gender = '$gender', name = '$name', phone= '$phone', address= '$address', email='$email'
					WHERE id = $userID";
		$result = $mysqli->query($query);
		if(!$result){
			$mysqli->query("DELETE FROM user WHERE user.username = '$username'");
			die('invalid query2');
			return;
		}
		else{
			header("Location: /users.php?successfulEditUser");
			return;
		}
	}
}
?>
<?php
function addResult(){
	$mysqli= new mysqli("localhost", "root", "", "researchdatabase");
	if(empty($_POST['patient'])||empty($_POST['dateDay']) 
		|| empty($_POST['dateMonth'])|| empty($_POST['dateYear'])|| empty($_POST['description'])){
		if(isset($_GET['addResultAttempt'])){
			header("Location: /study/add-result.php?failure&studyname=".$_GET['studyname']."&numTypes=".$_GET['numTypes']."");
		}
		else{
			return;
		}
	}
	if(!isset($_GET['addResultAttempt'])){
		return;
	}
	$typeArray = array();
	for($count = 0; $count < $_GET['numTypes']; $count++){
		if(empty($_POST["type".$count])){
			header("Location: /study/add-result.php?failure&studyname=".$_GET['studyname']."&numTypes=".$_GET['numTypes']."");
		}
		array_push($typeArray, $_POST["type".$count]);
	}
	
	if(!$mysqli->query("USE researchdatabase")){
		die("failed to use database");
	}
	
	$studyName = $_GET['studyname'];
	$patient = $_POST['patient'];
	$birthmonthString = $_POST['dateMonth'];
	echo $birthmonthString;
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
	$time = mktime(0,0,0, $birthmonth, (int)$_POST['dateDay'], (int)$_POST['dateYear']);
	if($time < mktime(0,0,0,1,1,1900) || $time >time()){
		die("Invalid birthday magic");
	}
	$date = date('Y-m-d', $time);
	$description = $_POST['description'];
	
	$query= "SELECT person.id FROM person INNER JOIN patient ON person.id = patient.id WHERE person.name = '$patient'";
	$result = $mysqli->query($query);
	if(!$result){
		die("invalid query 1");
	}
	if($result->num_rows < 1){
		header("Location: /study/add-result.php?failure&studyname=".$_GET['studyname']."&numTypes=".$_GET['numTypes']);
	}
	$data = $result->fetch_assoc();
	$patientID = $data['id'];
	
	$query = "INSERT INTO results VALUES(DEFAULT, '$studyName', '$patientID', '$date', '$description')";
	if(!$mysqli->query($query)){
		echo $query;
		die("invalid query 2");
	}
	
	//Get highest result id will be most recently added
	$query= "SELECT max(id) AS id FROM results";
	$result = $mysqli->query($query);
	if(!$result){
		die("invalid query 3");
	}
	if($result->num_rows < 1){
		header("Location: /study/add-result.php?failure&studyname=".$_GET['studyname']."&numTypes=".$_GET['numTypes']);
	}
	$data = $result->fetch_assoc();
	$resultID = $data['id'];
	
	for($count = 0; $count < $_GET['numTypes']; $count++){
		$query = "INSERT INTO type VALUES($resultID, '$studyName', $patientID, '".$typeArray[$count]."')";
		if(!$mysqli->query($query)){
			echo $query;
			die("Invalid query ".$count);
		}	
	}
	header('Location: /study/view-study.php?studyname='.$studyName.'&successfulAddResult');
}
?>
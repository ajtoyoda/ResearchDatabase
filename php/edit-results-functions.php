<?php
	require_once("edit-user-functions.php");
	function deleteType(){
		if(!isset($_GET['deleteTypeAttempt'])){
			return;
		}
		$mysqli= new mysqli("localhost", "root", "", "researchdatabase");
		if(!$mysqli->query("USE researchdatabase")){
			die("failed to use database");
		}
		$query = "DELETE FROM type WHERE result_id = ".$_GET['id']." AND type = '".$_GET['deleteTypeAttempt']."'";
		if(!$mysqli->query($query)){
			echo $query;
			die("Invalid query in deleteType");
		}
		header('Location: /study/edit-result.php?id='.$_GET['id'].'&numTypes='.$_GET['numTypes'].'&studyname='.$_GET['studyname']);
		
	}
	function editResult(){
	$mysqli= new mysqli("localhost", "root", "", "researchdatabase");
	if(empty($_POST['patient'])||empty($_POST['resultDay']) 
		|| empty($_POST['resultMonth'])|| empty($_POST['resultYear'])|| empty($_POST['description'])){
		if(isset($_GET['editResultsAttempt'])){
			header("Location: /study/edit-result.php?failureNotSet&id=".$_GET['id']."&studyname=".$_GET['studyname']."&numTypes=".$_GET['numTypes']."");
		}
		else{
			return;
		}
	}
	if(!isset($_GET['editResultsAttempt'])){
		echo 3;
		return;
	}
	$typeArray = array();
	for($count = 0; $count < $_GET['numTypes']; $count++){
		if(empty($_POST["type".$count])){
			header("Location: /study/edit-result.php?id=".$_GET['id']."&failureTypeNotSet&studyname=".$_GET['studyname']."&numTypes=".$_GET['numTypes']."");
		}
		array_push($typeArray, $_POST["type".$count]);
	}
	
	if(!$mysqli->query("USE researchdatabase")){
		die("failed to use database");
	}
	
	$studyName = $_GET['studyname'];
	$patient = $_POST['patient'];
	$birthmonthString = $_POST['resultMonth'];
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
	$time = mktime(0,0,0, $birthmonth, (int)$_POST['resultDay'], (int)$_POST['resultYear']);
	if($time < mktime(0,0,0,1,1,1900) || $time >time()){
		header("Location: /?failure");
	}
	$date = date('Y-m-d', $time);
	$description = $_POST['description'];
	$query= "SELECT person.id FROM person INNER JOIN patient ON person.id = patient.id WHERE person.name = '$patient'";
	$result = $mysqli->query($query);
	if(!$result){
		die("invalid query 1");
	}
	if($result->num_rows < 1){
		header("Location: /study/edit-result.php?failureInvalidPatient&id=".$_GET['id']."&studyname=".$_GET['studyname']."&numTypes=".$_GET['numTypes']);
	}
	$data = $result->fetch_assoc();
	$patientID = $data['id'];
	$resultID = $_GET['id'];
	$query = "UPDATE results SET study_name ='$studyName', patient_number = '$patientID', date ='$date', description='$description' WHERE id=".$resultID;
	if(!$mysqli->query($query)){
		echo $query;
		die("invalid query 2");
	}
	$query = "SELECT result_id, count(result_id) as numTypes
			FROM type
			WHERE result_id = ".$_GET['id']."
			GROUP BY result_id";
	$result = $mysqli->query($query);
	if(!$result){
		echo $query;
		die("Invalid query 1");
	}
	if($result->num_rows ==0){
		if($_GET['numTypes']==0){
			header('Location: /study/view-study.php?studyname='.$studyName.'&successfulEditResult');
		}
		else{
			$data=array('numTypes'=>0);
		}
	}else{
		$data = $result->fetch_assoc();
	}
	if($_GET['numTypes'] > $data['numTypes']){
		for($count = $data['numTypes']; $count<$_GET['numTypes']; $count++){
			$query = "INSERT INTO type VALUES($resultID, '$studyName', $patientID, '".$typeArray[$count]."')";
			if(!$mysqli->query($query)){
				echo $query;
				die("invalid query".$count);
			}
		}
	}
	$query = "SELECT type FROM type WHERE result_id = $resultID";
	$result = $mysqli->query($query);
	if(!$result){
		echo $query;
		die("Invalid query 1");
	}
	if($result->num_rows ==0){
		header('Location: /study/view-study.php?studyname='.$studyName.'&successfulEditResult');
	}
	for($count = 0; $count < $data['numTypes']; $count++){
		$typeData = $result->fetch_assoc();
		$query = "UPDATE type SET type = '".$typeArray[$count]."' WHERE type = '".$typeData['type']."'";
		if(!$mysqli->query($query)){
			echo $query;
			die("Invalid query ".$count);
		}
	}
	header('Location: /study/view-study.php?studyname='.$studyName.'&successfulEditResult');
}

	function checkNumType(){
		if(isset($_GET['setNumTypes'])){
			return;
		}
		$mysqli = new mysqli("localhost", "root", "", "researchdatabase");
		if(!$mysqli->query("USE researchdatabase")){
			die("Failed to use database");
		}
		$query = "SELECT result_id, count(result_id) as numTypes
				FROM type
				WHERE result_id = ".$_GET['id']."
				GROUP BY result_id";
		$result = $mysqli->query($query);
		if(!$result){
			echo $query;
			die("Invalid query 1");
		}
		if($result->num_rows ==0){
			return;
		}
		else{
			$data = $result->fetch_assoc();
			$numTypes = $data['numTypes'];
			if($numTypes == $_GET['numTypes']){
				return;
			}
			else{
				header('Location: /study/edit-result.php?id='.$_GET['id'].'&studyname='.$_GET['studyname'].'&numTypes='.$numTypes);
			}
		}
	}
	function getStudyFromResult($resultID){
		$result = getResult($resultID);
		return $result['study_name'];
	}
	function getPatientFromResult($resultID){
		$mysqli = new mysqli("localhost", "root", "", "researchdatabase");
		if(!$mysqli->query("USE researchdatabase")){
			die("Failed to use database");
		}
		$query = 	"SELECT pe.name AS name 
					FROM results AS r 
					INNER JOIN person as pe ON pe.id = r.patient_number
					WHERE r.id = $resultID";
		$result = $mysqli->query($query);
		if(!$result){
			echo $query;
			die("Query 1 failed");
		}
		$patient = $result->fetch_assoc();
		$patientName = $patient['name'];
		return $patientName;
	}
	function getTypeFromResult($id){
		$mysqli = new mysqli("localhost", "root", "", "researchdatabase");
		if(!$mysqli->query("USE researchdatabase")){
			die("Failed to use database");
		}
		$query = 	"SELECT type FROM type WHERE result_id = $id";
		$result = $mysqli->query($query);
		if(!$result){
			die("Query 1 failed");
		}
		$type = array();
		for($count = 0; $count < $result->num_rows; $count++){
			$resultData = $result->fetch_assoc();
			array_push($type, $resultData['type']);
		}
		return $type;
	}
	function getResult($resultID){
		$mysqli = new mysqli("localhost", "root", "", "researchdatabase");
		if(!$mysqli->query("USE researchdatabase")){
			die("Failed to use database");
		}
		$query = 	"SELECT study_name, patient_number, date, description FROM results WHERE id = '$resultID'";
		$result = $mysqli->query($query);
		if(!$result){
			die("Query 1 failed");
		}
		$resultData = $result->fetch_assoc();
		return $resultData;
	}
?>
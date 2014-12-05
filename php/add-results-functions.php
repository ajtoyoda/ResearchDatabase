<?php
	require_once("gf.php");
	function addResult(){
		if(!isset($_GET['addResultAttempt'])){
			return;
		}
		
		$mysqli = mysqliInit();
		if(empty($_POST['patient'])||empty($_POST['dateDay']) 
			|| empty($_POST['dateMonth'])|| empty($_POST['dateYear'])|| empty($_POST['description'])){
				header("Location: /study/add-result.php?failureNotSet&studyname=".$_GET['studyname']."&numTypes=".$_GET['numTypes']."");
		}
		
		//Validate and check types
		$typeArray = array();
		for($count = 0; $count < $_GET['numTypes']; $count++){
			if(empty($_POST["type".$count])){
				header("Location: /study/add-result.php?failureNotSet&studyname=".$_GET['studyname']."&numTypes=".$_GET['numTypes']."");
			}
			array_push($typeArray, $_POST["type".$count]);
		}
	
		$studyName = $_GET['studyname'];
		$patient = $_POST['patient'];
		$birthmonthString = $_POST['dateMonth'];
		$date = formatDate((int)$_POST['dateDay'], $birthmonthString, (int)$_POST['dateYear']);
		$description = $_POST['description'];
	
		$query= "SELECT person.id FROM person INNER JOIN patient ON person.id = patient.id WHERE person.name = '$patient'";
		$data = queryCheckAssoc($mysqli, $query, "/study/add-result.php?failureInvalidPatient&studyname=".$_GET['studyname']."&numTypes=".$_GET['numTypes']);
		$patientID = $data['id'];
	
		$description = $mysqli->real_escape_string($description);
		$studyName = $mysqli->real_escape_string($studyName);
	
		//Insert into results
		$query = "INSERT INTO results VALUES(DEFAULT, '$studyName', '$patientID', '$date', '$description')";
		queryNoReturn($mysqli, $query);
	
		//Get highest result id will be most recently added
		$query= "SELECT max(id) AS id FROM results";
		$data = queryCheckAssoc($mysqli, $query, "/study/add-result.php?failure&studyname=".$_GET['studyname']."&numTypes=".$_GET['numTypes']); 
		$resultID = $data['id'];
	
		for($count = 0; $count < $_GET['numTypes']; $count++){
			$query = "INSERT INTO type VALUES($resultID, '$studyName', $patientID, '".$typeArray[$count]."')";
			queryNoReturn($mysqli, $query);
		}
		header('Location: /study/view-study.php?studyname='.$studyName.'&successfulAddResult');
}
?>
<?php
	require_once("edit-user-functions.php");
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
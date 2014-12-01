<?php
	function getStudyFromResult($resultID){
		$mysqli = new mysqli("localhost", "root", "", "researchdatabase");
		if(!$mysqli->query("USE researchdatabase")){
			die("Failed to use database");
		}
		$query = 	"SELECT study_name FROM results WHERE id = '$resultID'";
		$result = $mysqli->query($query);
		if(!$result){
			die("Query 1 failed");
		}
		$study = $result->fetch_assoc();
		$studyName = $study['study_name'];
		return $studyName;
	}
?>
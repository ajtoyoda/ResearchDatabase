<?php
	function deleteResult($resultID){
		$mysqli= new mysqli("localhost", "root", "", "researchdatabase");
		if(!$mysqli->query("USE researchdatabase")){
			die("failed to use database");
		}
		$query = "DELETE FROM type WHERE result_id=$resultID";
		if(!$mysqli->query($query)){
			echo $query;
			die("Invalid query 1");
		}
		$query = "DELETE FROM results WHERE id=$resultID";
		if(!$mysqli->query($query)){
			echo $query;
			die("Invalid query 2");
		}
		header("Location: /study/view-study.php?studyname=".$_GET['studyname']);
	}
?>
<?php
	require_once("gf.php");
	function deleteResult($resultID){
		$mysqli= mysqliInit();
		$query = "DELETE FROM type WHERE result_id=$resultID";
		queryNoReturn($mysqli, $query);
		$query = "DELETE FROM results WHERE id=$resultID";
		queryNoReturn($mysqli, $query);
		header("Location: /study/view-study.php?studyname=".$_GET['studyname']);
	}
?>
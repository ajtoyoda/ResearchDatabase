<?php
	require_once("gf.php");
	//This function checks how many the given patient already has for medications and health issues and 
	//sets the get values
	function setNum(){
		if(isset($_GET['setNumTypes'])){
			return;
		}
		$mysqli= mysqliInit();
		$query = "SELECT count(issues) as numIssues
				FROM patient_health_issues
				WHERE id = ".$_GET['ID']."
				GROUP BY id";
		$data = queryAssoc($mysqli, $query);
		$numIssues = $data['numIssues'];
		$query = "SELECT count(medications) as numMeds
				FROM patient_medications
				WHERE id = ".$_GET['ID']."
				GROUP BY id";
		$data = queryAssoc($mysqli, $query);
		$numMeds= $data['numMeds'];
		if($numMeds == NULL){
			$numMeds = 0;
		}
		if($numIssues == NULL){
			$numIssues = 0;
		}
		if(empty($_GET['numIssues']) || empty($_GET['numMeds']) || $_GET['numIssues'] != $numIssues || $_GET['numMeds'] != $numMeds){
			header('Location: /patient/edit-medical.php?ID='.$_GET['ID'].'&numIssues='.$numIssues.'&numMeds='.$numMeds.'&setNumTypes');
		}
	}

	//This function deletes the issue specified by the get
	function deleteIssue(){
		if(!isset($_GET['deleteIssueAttempt'])){
			return;
		}
		$mysqli = mysqliInit();
		$query = "DELETE FROM patient_health_issues WHERE id=".$_GET['ID']." AND issues =\"".$_GET['deleteIssueAttempt']."\"";
		queryNoReturn($mysqli, $query);
		header("Location: /patient/edit-medical.php?ID=" . $_GET['ID'] . "&numIssues=".$_GET['numIssues']."&numMeds=".$_GET['numMeds']."&setNumTypes");
	}

	//This function deletes the medication specified by the get
	function deleteMed(){
		if(!isset($_GET['deleteMedsAttempt'])){
			return;
		}
		$mysqli = mysqliInit();
		$query = "DELETE FROM patient_medications WHERE id=".$_GET['ID']." AND medications =\"".$_GET['deleteMedsAttempt']."\"";
		queryNoReturn($mysqli, $query);
		header("Location: /patient/edit-medical.php?ID=" . $_GET['ID'] . "&numIssues=".$_GET['numIssues']."&numMeds=".$_GET['numMeds']."&setNumTypes");
	}

	//This function updates medication and issue
	function edit(){
		$mysqli = mysqliInit();
		$id = $_GET['ID'];
		if(!isset($_GET['editAttempt'])){
			return;
		}
		$issueArray = array();
		for($count = 0; $count < $_GET['numIssues']; $count++){
			if(empty($_POST["issue".$count])){
				header("Location: /patient/edit-medical.php?ID=".$_GET['ID']."&failureNotSet&numIssues=".$_GET['numIssues']."&numMeds=".$_GET['numMeds']."&setNumTypes");
			}
			array_push($issueArray, $mysqli->real_escape_string($_POST["issue".$count]));
		}
		$medsArray= array();
		for($count = 0; $count < $_GET['numMeds']; $count++){
			if(empty($_POST["med".$count])){
				header("Location: /patient/edit-medical.php?ID=".$_GET['ID']."&failureNotSet&numIssues=".$_GET['numIssues']."&numMeds=".$_GET['numMeds']."&setNumTypes");
			}
			array_push($medsArray, $mysqli->real_escape_string($_POST["med".$count]));
		}
		$query = "SELECT count(id) as numIssues
				FROM patient_health_issues
				WHERE id= ".$id."
				GROUP BY id";
		$result = $mysqli->query($query);
		if(!$result){
			echo $query;
			die("Invalid outside query");
		}
		if($result->num_rows==0){
			if($_GET['numIssues'] == 0)
				goto editMeds;
			else{
				$data = array('numIssues'=>0);
			}
		}	
		else{
			$data = $result->fetch_assoc();
		}
		$query = "SELECT issues FROM patient_health_issues WHERE id = ".$id;
		$result = $mysqli->query($query);
		if($_GET['numIssues'] > $data['numIssues']){
			for($count = $data['numIssues']; $count < $_GET['numIssues']; $count++){
				$query = "INSERT INTO patient_health_issues VALUES('$id', '".$issueArray[$count]."')";
				queryNoReturn($mysqli, $query);
			}
		}
		if(!$result){
			echo $query;
			die("Invalid outside query");
		}
		for($count = 0; $count < $data['numIssues']; $count++){
			$issueData =$result->fetch_assoc();
			$query = "UPDATE patient_health_issues SET issues = '".$issueArray[$count]."' WHERE issues = '".$issueData['issues']."' AND id =".$id;
			queryNoReturn($mysqli, $query);
		}
	editMeds:
		$query = "SELECT count(id) as numMeds
				FROM patient_medications
				WHERE id= ".$id."
				GROUP BY id";
		$result = $mysqli->query($query);
		if(!$result){
			echo $query;
			die("Invalid outside query");
		}
		if($result->num_rows==0){
			if($_GET['numMeds'] == 0)
				header('Location: /patient/view-medical.php?ID='.$id);
			else{
				$data = array('numMeds'=>0);
			}
		}	
		else{
			$data = $result->fetch_assoc();
		}
		$query = "SELECT medications FROM patient_medications WHERE id = ".$id;
		$result = $mysqli->query($query);
		if($_GET['numMeds'] > $data['numMeds']){
			for($count = $data['numMeds']; $count < $_GET['numMeds']; $count++){
				$query = "INSERT INTO patient_medications VALUES('$id', '".$medsArray[$count]."')";
				queryNoReturn($mysqli, $query);
			}
		}
		if(!$result){
			echo $query;
			die("Invalid query outside");
		}
		for($count = 0; $count < $data['numMeds']; $count++){
			$medData =$result->fetch_assoc();
			$query = "UPDATE patient_medications SET medications = '".$medsArray[$count]."' WHERE medications = '".$medData['medications']."' AND id = ".$id;
			queryNoReturn($mysqli, $query);
		}
		header('Location: /patient/view-medical.php?ID='.$id.'&successfulEdit');
	}
?>
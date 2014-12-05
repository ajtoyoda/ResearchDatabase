<?php
	require_once("edit-user-functions.php");
	require_once("gf.php");
	
	//This function deletes a row from the type table using the given string as a partial key
	function deleteType(){
		if(!isset($_GET['deleteTypeAttempt'])){
			return;
		}
		$mysqli= mysqliInit();
		$query = "DELETE FROM type WHERE result_id = ".$_GET['id']." AND type = '".$_GET['deleteTypeAttempt']."'";
		queryNoReturn($mysqli, $query);
		header('Location: /study/edit-result.php?id='.$_GET['id'].'&numTypes='.$_GET['numTypes'].'&studyname='.$_GET['studyname']);
		
	}

	//This function updates the result and type table
	function editResult(){
		$mysqli= mysqliInit();
		if(!isset($_GET['editResultsAttempt'])){
			return;
		}
		if(	empty($_POST['patient'])||empty($_POST['resultDay']) 
			|| empty($_POST['resultMonth'])|| empty($_POST['resultYear'])|| empty($_POST['description'])){
				header("Location: /study/edit-result.php?failureNotSet&id=".$_GET['id']."&studyname=".$_GET['studyname']."&numTypes=".$_GET['numTypes']."");
		}
		//Make sure types are valid and store them into array
		$typeArray = array();
		for($count = 0; $count < $_GET['numTypes']; $count++){
			if(empty($_POST["type".$count])){
				header("Location: /study/edit-result.php?id=".$_GET['id']."&failureNotSet&studyname=".$_GET['studyname']."&numTypes=".$_GET['numTypes']."");
			}
			array_push($typeArray, $_POST["type".$count]);
		}
	
	
		$studyName = $_GET['studyname'];
		$patient = $_POST['patient'];
		$birthmonthString = $_POST['resultMonth'];
		$date = formatDate((int)$_POST['resultDay'], $birthmonthString, (int)$_POST['resultYear']);
		$description = $_POST['description'];
		$query= "SELECT person.id FROM person INNER JOIN patient ON person.id = patient.id WHERE person.name = '$patient'";
		$data = queryCheckAssoc($mysqli, $query, "/study/edit-result.php?failureInvalidPatient&id=".$_GET['id']."&studyname=".$_GET['studyname']."&numTypes=".$_GET['numTypes']);
		$patientID = $data['id'];
		$resultID = $_GET['id'];
		$query = "UPDATE results SET study_name ='$studyName', patient_number = '$patientID', date ='$date', description='$description' WHERE id=".$resultID;
		queryNoReturn($mysqli, $query);
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
				queryNoReturn($mysqli, $query);
			}
		}
		$query = "SELECT type FROM type WHERE result_id = $resultID";
		queryCheckAssoc($mysqli, $query, '/study/view-study.php?studyname='.$studyName.'&successfulEditResult');
		for($count = 0; $count < $data['numTypes']; $count++){
			$typeData = $result->fetch_assoc();
			$query = "UPDATE type SET type = '".$typeArray[$count]."' WHERE type = '".$typeData['type']."'";
			queryNoReturn($mysqli, $query);
		}
		header('Location: /study/view-study.php?studyname='.$studyName.'&successfulEditResult');
	}
	
	//This function set numTypes to the number of types in the database for the study
	function checkNumType(){
		if(isset($_GET['setNumTypes'])){
			return;
		}
		$mysqli = mysqliInit();
		$query = "SELECT result_id, count(result_id) as numTypes
				FROM type
				WHERE result_id = ".$_GET['id']."
				GROUP BY result_id";
		$data = queryAssoc($mysqli, $query);
		if($data == NULL){
			return;
		}
		else{
			$numTypes = $data['numTypes'];
			if($numTypes == $_GET['numTypes']){
				return;
			}
			else{
				header('Location: /study/edit-result.php?id='.$_GET['id'].'&studyname='.$_GET['studyname'].'&numTypes='.$numTypes);
			}
		}
	}

	//This function return the study correlating to the resultID
	function getStudyFromResult($resultID){
		$result = getResult($resultID);
		return $result['study_name'];
	}

	//This function returns the patient name for the given result
	function getPatientFromResult($resultID){
		$mysqli= mysqliInit();
		$query = 	"SELECT pe.name AS name 
					FROM results AS r 
					INNER JOIN person as pe ON pe.id = r.patient_number
					WHERE r.id = $resultID";
		$patient = queryAssoc($mysqli, $query);
		return $patient['name'];
	}

	//This function returns the type field for the given result as an array
	function getTypeFromResult($id){
		$mysqli= mysqliInit();
		$query = 	"SELECT type FROM type WHERE result_id = $id";
		$type = queryArray($mysqli, $query, 'type');
		return $type;
	}
	
	//This function returns all values associated with given result
	function getResult($resultID){
		$mysqli = mysqliInit();
		$query = 	"SELECT study_name, patient_number, date, description FROM results WHERE id = '$resultID'";
		return queryAssoc($mysqli, $query);
	}
?>
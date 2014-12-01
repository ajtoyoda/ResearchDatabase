<?php
	//This function returns an array of view_edit info for the given study
	function getViewEdit($study){
		$mysqli = new mysqli("localhost", "root", "", "researchdatabase");
		if(!$mysqli->query("USE researchdatabase")){
			die("Failed to use database");
		}
		$query = "SELECT u.ID AS id, p.name, p.name AS name, canRead, canWrite
		FROM user AS u CROSS JOIN study AS s LEFT OUTER JOIN view_edit as ve ON u.id = ve.user_id AND s.name = ve.study_name
		INNER JOIN person AS p ON u.id=p.id WHERE s.name = '$study'";
		$result = $mysqli->query($query);
		if(!$result){
			die("Query 1 failed");
		}
		$viewEdit = array();
		for($count = 0; $count < $result->num_rows; $count++){
			$result_vd = $result->fetch_assoc();
			array_push($viewEdit, $result_vd);
		}
		return $viewEdit;
	}
	function editUserPermissions(){
		if(!isset($_GET['attemptEditUserPermissions'])){
			return;
		}
		$mysqli = new mysqli("localhost", "root", "", "researchdatabase");
		if(!$mysqli->query("USE researchdatabase")){
			die("Failed to use database");
		}
		$ve = getViewEdit($_GET['studyName']);
		for($count = 0; $count < count($ve); $count ++){
			if(isset($_POST['canRead'.$count])){
				$canRead = 1;
			}else{
				$canRead = 0;
			}
			if(isset($_POST['canWrite'.$count])){
				$canWrite = 1;
			}else{
				$canWrite = 0;
			}
			$userID = $ve[$count]['id'];
			$studyName = $_GET['studyName'];
			$result = $mysqli->query("SELECT user_id FROM view_edit WHERE user_id = $userID AND study_name = '$studyName'");
			if($result->num_rows > 0){
				$query = "UPDATE view_edit SET canRead = $canRead, canWrite = $canWrite WHERE view_edit.user_id = $userID AND study_name = '$studyName'";
			}else{
				$query= "INSERT INTO view_edit VALUES('$studyName', $userID, $canWrite, $canRead)";
			}
			if(!$mysqli->query($query)){
				die("Invalid query 1");
			}
			else{
				header('Location: /users.php?successfulEditPermissions#permissions');
			}
		}
	}
?>
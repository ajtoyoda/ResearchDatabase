<?php
	//This function deletes a user including dependencies in view_edit, study(supervisor_id), person,
	function deleteUser(){
		$userID = $_GET['userID'];
		$mysqli = new mysqli("localhost", "root", "", "researchdatabase");
		if(!$mysqli->query("USE researchdatabase")){
			die("Failed to use database");
		}
		//If a supervisor need to replace first before finishing deletion
		$query = "SELECT name FROM study WHERE supervisor_id = $userID";
		$result = $mysqli->query($query);
		if(!$result){
			die("Bad Query 2");
		}
		if($result->num_rows >0){
			header('Location: /user/delete-md.php?userID='.$userID);
			return;
		}
		$query = "DELETE FROM view_edit WHERE user_id = $userID";
		if(!$mysqli->query($query)){
			die("Bad query");
		}
		$query = "DELETE FROM works_on WHERE assistant_id = $userID";
		if(!$mysqli->query($query)){
			die("Bad query6");
		}
		$query = "DELETE FROM user WHERE id = $userID";
		if(!$mysqli->query($query)){
			die("Bad query3");
		}		
		$query = "DELETE FROM person WHERE id = $userID";
		if(!$mysqli->query($query)){
			die("Bad query4");
		}
		$query = "UPDATE person SET emergency_id=NULL WHERE emergency_id = $userID";
		if(!$mysqli->query($query)){
			die("Bad query5");
		}
		header('Location: /users.php?successfulDeleteUser');
	}
	function deleteMD(){
		
		if(!isset($_GET['deleteMD'])){
			return;
		}
		$userID = $_GET['userID'];
		$mysqli = new mysqli("localhost", "root", "", "researchdatabase");
		if(!$mysqli->query("USE researchdatabase")){
			die("Failed to use database");
		}
		$newSupervisorName = $_POST['supervisor'];
		$query = "SELECT id FROM person WHERE name = '$newSupervisorName'";
		$result = $mysqli->query($query);
		if(!$result){
			echo $query;
			die("Bad query2");
		}
		$data = $result->fetch_assoc();
		$newSupervisorID = $data['id'];
		$query = "UPDATE study SET supervisor_id = $newSupervisorID WHERE supervisor_id = $userID";
		if(!$mysqli->query($query)){
			echo $query;
			die("bad Query 1");
		}else{
			deleteUser();
		}
	
	}

?>
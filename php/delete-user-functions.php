<?php
	//This function deletes a user including dependencies in view_edit, study(supervisor_id), person,
	function deleteUser(){
		$userID = $_GET['userID'];
		$mysqli = new mysqli("localhost", "root", "", "researchdatabase");
		if(!$mysqli->query("USE researchdatabase")){
			die("Failed to use database");
		}
		$query = "DELETE FROM view_edit WHERE user_id = $userID";
		if(!$mysqli->query($query)){
			die("Bad query");
		}
		$query = "UPDATE study SET supervisor_id=NULL WHERE supervisor_id = $userID";
		if(!$mysqli->query($query)){
			die("Bad query2");
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
		header('Location: /users.php?successfulDelete');
	}

?>
<?php
	//This function deletes a user including dependencies in view_edit, study(supervisor_id), person,
	function deleteUser(){
		$userID = $_GET['userID'];
		$mysqli = new mysqli("localhost", "root", "", "researchdatabase");
		if(!$mysqli->query("USE researchdatabase")){
			die("Failed to use database");
		}
    // Don't allow the user to delete themselves.
    session_start();
    if ($_SESSION["userid"] == $userID)
    {
      header("Location: /users.php?failureLoggedIn");
      return;
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
		$query = "SELECT emergency_id FROM person WHERE id = $userID";
		$result = $mysqli->query($query);
		if(!$result){
			die("Bad Query 7");
		}
		if($result->num_rows>0){
			$data = $result->fetch_assoc();
			$emergencyContact = $data['emergency_id'];
			$query = "DELETE FROM person WHERE id = '$emergencyContact'";
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
		if(empty($_POST['supervisor'])){
			die("No post");
		}
		$newSupervisorID = $_POST['supervisor']; 
		$query = "UPDATE study SET supervisor_id = $newSupervisorID WHERE supervisor_id = $userID";
		if(!$mysqli->query($query)){
			echo $query;
			die("bad Query 1");
		}else{
			deleteUser();
		}
	
	}

?>
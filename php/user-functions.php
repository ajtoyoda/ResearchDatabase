<?php
	//This function displays all user info given the userID
	function showAllUserInfo($userID){
        $mysqli = new mysqli("localhost", "root", "", "researchdatabase");
        $query = "SELECT p.name AS name, u.type_flag AS type FROM person AS p INNER JOIN user AS u ON p.ID = u.ID WHERE u.ID = $userID";
        $result = $mysqli->query($query);
        if(!$result){
            die("Query 2 failed");
        }
        $data = $result->fetch_assoc();
        $type = "";
		if($data['type'] == 'A'){
			$type = "Administrator";
		}elseif($data['type'] == 'R'){
			$type = "Research Assistant";
		}else{
			$type = "MD";
		}
		echo "<tr>
			<td><p>".$data['name']."</p></td>
			<td><p>".$userID."</p></td>
			<td><p>".$type."</p></td>
			<td><a href=\"/user/edit-user.php?".$userID."\">Edit</a><a href=\"/user/delete-user.php?".$userID."\">Delete</a></p></td>
			</tr>";
    }
	//This function returns all users in an array. To access all of them in a loop use
	//for($count = 0; $count < count($userID); $count++) where $userID is where the return of this function is stored
	//access inside loop by $userID[$count]
	function getUsers(){
		$mysqli = new mysqli("localhost", "root", "", "researchdatabase");
		if(!$mysqli->query("USE researchdatabase")){
			die("Failed to use database");
		}
		$query = "SELECT id FROM user";
		$result = $mysqli->query($query);
		if(!$result){
			die("Query 1 failed");
		}
		$userID = array();
		for($count = 0; $count < $result->num_rows; $count++){
			$result_vd = $result->fetch_assoc();
			array_push($userID, $result_vd['id']);
		}
		return $userID;
	}
	//Displays view_edit table info for each study in a very specific way for page user.php
	//This is probably not transferrable
	function showView_EditInfo($studyName){
		echo "<tr>";
		echo"<td><p>".$studyName."</p></td>";
		$mysqli = new mysqli("localhost", "root", "", "researchdatabase");
		//This query is correct but outer joins are ugly
        $query = "SELECT u.ID AS id, s.name, username, canRead, canWrite
FROM user AS u CROSS JOIN study AS s LEFT OUTER JOIN view_edit as ve ON u.id = ve.user_id AND s.name = ve.study_name
WHERE s.name = '$studyName'";
        $result = $mysqli->query($query);
        if(!$result){
            die("Query 2 failed");
        }
		$usernameArray = array();
		$canReadArray = array();
		$canWriteArray = array();
		for($count = 0; $count < $result->num_rows; $count++){
			$data = $result->fetch_assoc();
			if($data['canRead'] != NULL and $data['canWrite'] != NULL){
				array_push($usernameArray, $data['username']);
				array_push($canReadArray, $data['canRead']);
				array_push($canWriteArray, $data['canWrite']);
			}
			else{
				array_push($usernameArray, $data['username']);
				array_push($canReadArray, 0);
				array_push($canWriteArray, 0);
			}
		}
		echo "<td class=\"subtable\">";
		for($count = 0; $count < count($usernameArray); $count++){
			echo "<p>".$usernameArray[$count]."</p>";
		}
		echo "</td>";
		echo "<td class=\"subtable\">";
		for($count = 0; $count < count($canReadArray); $count++){
			echo "<p>".$canReadArray[$count]."</p>";
		}
		echo "</td>";
		echo "<td class=\"subtable\">";
		for($count = 0; $count < count($canWriteArray); $count++){
			echo "<p>".$canWriteArray[$count]."</p>";
		}
		echo "</td>		
		<td><a href=\"/user/edit-user-permission.php?".$studyName."\">Edit</a></p></td>
		</tr>";
	}
	//This function returns all studies regardless of view_edit privledges of user(only should be used by admin)
	function getAllStudies(){
	$mysqli= new mysqli("localhost", "root", "", "researchdatabase");
	if(!$mysqli->query("USE researchdatabase")){
		die("failed to use database");
	}
	if(!isset($_SESSION['userid'])){
		return;
	}
	$userid = $_SESSION['userid'];
	$query = 	"SELECT name FROM study";
	$result = $mysqli->query($query);
	if(!$result){
		die("Query 1 failed");
	}
	$studyNames= array();
	for($count = 0; $count < $result->num_rows; $count++){
		$study_vd = $result->fetch_assoc();
		array_push($studyNames, $study_vd['name']);
	}
	return $studyNames;
}
	
?>
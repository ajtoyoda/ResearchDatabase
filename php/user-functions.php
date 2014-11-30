<?php
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
	
?>
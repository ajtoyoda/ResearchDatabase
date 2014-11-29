<?php
    //This function displays study info for the view_study page
    function showAllStudyInfo($studyName){
        $mysqli = new mysqli("localhost", "root", "", "researchdatabase");
        $query = "SELECT person.name AS name, start_date, end_date, budget FROM study INNER JOIN person ON study.supervisor_id = person.id WHERE study.name = '$studyName'";
        $result = $mysqli->query($query);
        if(!$result){
            die("Query 1 failed");
        }
        $data = $result->fetch_assoc();
        echo "<h1>".$studyName."</h1>
            <div id=\"study-info\">
              <ul>
                <li><p>Start date:</p></li>
                <li><p>".$data['start_date']."</p></li>
              </ul>
              <ul>
                <li><p>End date:</p></li>
                <li><p>".$data['end_date']."</p></li>
              </ul>
              <ul>
                <li><p>Budget:</p></li>
                <li><p>$".$data['budget']."</p></li>
              </ul>
              <ul>
                <li><p>Supervisor:</p></li>
                <li><p>".$data['name']."</p></li>
              </ul>
            </div>";
    }
	//This function displays the result info of the passed in result ID
	function showAllResultInfo($resultID){
		$mysqli = new mysqli("localhost", "root", "", "researchdatabase");
		$query = "select p.name AS name, date, description from results AS r INNER JOIN person AS p ON p.id = r.patient_number WHERE r.id = $resultID";
		$result = $mysqli->query($query);
        if(!$result){
            die("Query 1 failed");
        }
		$data = $result->fetch_assoc();
		echo " <tr>
				<td><p>".$data['name']."</p></td>
                <td><p>".$data['date']."</p></td>
                <td><p>".$data['description']."</p></td>
                <td><a href=\"edit-result.php?id=".$resultID."\">Edit</a><a href=\"delete-result.php?id=".$resultID."\">Delete</a></p></td> 
				</tr>";
	}
	//This function returns an array of results associated with the study(PK aka study_name) which is passed in
	function getResults($study){
	$mysqli = new mysqli("localhost", "root", "", "researchdatabase");
	if(!$mysqli->query("USE researchdatabase")){
		die("Failed to use database");
	}
	$query = 	"SELECT id FROM results WHERE study_name = '$study'";
	$result = $mysqli->query($query);
	if(!$result){
		die("Query 1 failed");
	}
	$resultID = array();
		for($count = 0; $count < $result->num_rows; $count++){
		$result_vd = $result->fetch_assoc();
		array_push($resultID, $result_vd['id']);
	}
	return $resultID;
}


?>
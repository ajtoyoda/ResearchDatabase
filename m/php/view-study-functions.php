<?php
	require_once("index-functions.php");
	require_once("gf.php");
    //This function displays study info for the view_study page
    function showAllStudyInfo($studyName){
        $mysqli = mysqliInit();
        $query = "SELECT person.name AS name, start_date, end_date, budget FROM study INNER JOIN person ON study.supervisor_id = person.id WHERE study.name = '$studyName'";
		$data = queryAssoc($mysqli, $query);
        echo "<h1>".$studyName."</h1>
            <p><a href=\"/\">&lt; My studies</a></p>
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
		$mysqli = mysqliInit();
		$query = "select p.name AS name, date, description from results AS r INNER JOIN person AS p ON p.id = r.patient_number WHERE r.id = $resultID";
		$data = queryAssoc($mysqli, $query);
    
		// Get result type(s).
		$query = "SELECT t.type, r.ID FROM type AS t INNER JOIN results AS r ON r.ID = t.Result_ID WHERE r.ID = '" . $resultID . "'";
		$types = $mysqli->query($query);
		if (!$types)
			die("Query 2 failed"); 
		echo " <tr>
				<td><p>".$data['name']."</p></td>
                <td><p>".$data['date']."</p></td><td>";
                
		if ($types->num_rows != 0){
			for ($i = 0; $i < $types->num_rows; $i++)
				echo "<p>" . $types->fetch_assoc()["type"] . "</p>";
		}
    
		echo "</td><td><p>".$data['description']."</p></td>
                <td><p><a href=\"edit-result.php?id=".$resultID."&amp;numTypes=0&amp;studyname=".$_GET['studyname']."\">Edit</a><a href=\"delete-result.php?id=".$resultID."&amp;studyname=".$_GET['studyname']."\">Delete</a></p></td> 
				</tr>";
	}
	//This function returns an array of results associated with the study(PK aka study_name) which is passed in
	function getResults($study){
		$mysqli = mysqliInit();
		$query = 	"SELECT id FROM results WHERE study_name = '$study'";
		return queryArray($mysqli, $query, 'id');
	}
	function verifyStudy(){
		if(isset($_GET['studyname'])){
			$studiesCanView = getStudies();
			for($count = 0; $count < count($studiesCanView); $count++){
				if($studiesCanView[$count] == $_GET['studyname']){
					return;
				}
			}
			//If it doesnt return in for loop should redirect
			header("Location: /");
		}
		else{
			header("Location: /");
		}
	}


?>
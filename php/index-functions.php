<?php
	//This function checks is a user has permission to view a study than displays info
function getStudies(){
	$mysqli= new mysqli("localhost", "root", "", "researchdatabase");
	if(!$mysqli->query("USE researchdatabase")){
		die("failed to use database");
	}
	if(!isset($_SESSION['userid'])){
		return;
	}
	$userid = $_SESSION['userid'];
	$query = 	"SELECT study_name, canread, canwrite FROM view_edit WHERE user_id = $userid";
	$result = $mysqli->query($query);
	if(!$result){
		die("Query 1 failed");
	}
	if($result->num_rows == 0){
		echo " 
            <p>You are not currently participating in any studies.</p>";
			return;
	}
	$count;
	$studyNames= array();
	for($count = 0; $count < $result->num_rows; $count++){
		$study_vd = $result->fetch_assoc();
		if($study_vd['canread'] || $study_vd['canwrite']){
			array_push($studyNames, $study_vd['study_name']);
		}
	}
	return $studyNames;
}

//This function displays the html code for each study given its name
function showStudy($study_name){
	static $count = 0;
	$mysqli = new mysqli("localhost", "root", "", "researchdatabase");
	$query = 	"SELECT person.name, start_date
				FROM study INNER JOIN person ON person.id = study.supervisor_id
				WHERE study.name = '$study_name'";
	$result = $mysqli->query($query);
	if(!$result){
		die("Query 2 failed");
	}
	$data = $result->fetch_assoc();
	if($count==0){
	echo "<li class=\"first\">
                 <div class=\"view-edit\">
                   <p><a href=\"/study/view-study.php?studyname=".$study_name."\" class=\"view\">View</a>
                   <a href=\"/study/edit-study.php?studyname=".$study_name."\" class=\"edit\">Edit</a></p>
                 </div>
                 <div class=\"padding\">
                   <h1>".$study_name."</h1>
                   <p>".$data['start_date']."</p>
                   <p>".$data['name']."</p>
                 </div>
               </li>";
	$count = 1;
	}else{
	echo "<li>
                 <div class=\"view-edit\">
                   <p><a href=\"/study/view-study.php\" class=\"view\">View</a>
                   <a href=\"/study/edit-study.php\" class=\"edit\">Edit</a></p>
                 </div>
                 <div class=\"padding\">
                   <h1>".$study_name."</h1>
                   <p>".$data['start_date']."</p>
                   <p>".$data['name']."</p>
                 </div>
               </li>";
	$count = 0;
	}
}
?>
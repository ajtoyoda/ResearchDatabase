<?php
	require_once("edit-user-functions.php");
	require_once("gf.php");
	//This function returns all study info given its name in a dictionary
	function getStudyInfo($studyName){
		$mysqli= mysqliInit();
		$query = "SELECT budget, start_date, end_date, supervisor_id, name FROM study WHERE name = '$studyName'";
		return queryAssoc($mysqli, $query);
	}
	
	//This function reads posts values and updates study
	function editStudy(){
		$studyName = $_GET['studyname'];
		if(!isset($_GET['editStudyAttempt'])){
			return;
		}
		$mysqli= mysqliInit();
		if(empty($_POST['name'])||empty($_POST['budget']) 
			|| empty($_POST['startDateDay'])|| empty($_POST['startDateMonth'])|| empty($_POST['startDateYear']) 
			|| empty($_POST['endDateDay'])|| empty($_POST['endDateMonth'])|| empty($_POST['endDateYear'])
			||empty($_POST['supervisorName'])){
			+header("Location: /study/edit-study.php?studyname=".$studyName."&failure");
		}
		
		//Get posted values
		$name = $_POST['name'];
		$budgetString = $_POST['budget'];
		$supervisorName = $_POST['supervisorName'];
		$budget = (double) $budgetString;
		$startMonthString = $_POST['startDateMonth'];
		$startMonth = 1;
		$startDate = formatDate((int)$_POST['startDateDay'], $startMonthString, (int)$_POST['startDateYear']);

		$endMonthString = $_POST['endDateMonth'];
		$endDate = formatDate((int)$_POST['endDateDay'], $endMonthString, (int)$_POST['endDateYear']);
		
		//Make sure inputs are valid
		if(!is_numeric($budget)){
			header('Location: /study/edit-study.php?studyname=".$studyName."&failureNotNumeric');
		}
		$name = $mysqli->real_escape_string($name);
		$supervisorName = $mysqli->real_escape_string($supervisorName);
		
		//Have supervisorName need supervisorID
		$query="SELECT user.id FROM person INNER JOIN user ON person.id = user.id WHERE name = '$supervisorName' and type_flag = 'M'";
		$data = queryAssoc($mysqli, $query);
		$supervisor_id = $data['id'];
		
		//actual query
		if($name == $_GET['studyname']){
			$query = "UPDATE study SET budget=$budget, end_date='$endDate', start_date='$startDate', supervisor_id=$supervisor_id
				WHERE name = '$name'";
				queryNoReturn($mysqli, $query);
		}
		header("Location: /index.php?successfulEditStudy");
	}
?>
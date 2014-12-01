<?php
	require_once("edit-user-functions.php");
	function getStudyInfo($studyName){
		$mysqli= new mysqli("localhost", "root", "", "researchdatabase");
		if(!$mysqli->query("USE researchdatabase")){
			die("failed to use database");
		}
		$query = "SELECT budget, start_date, end_date, supervisor_id, name FROM study WHERE name = '$studyName'";
		$result = $mysqli->query($query);
		if(!$result){
			die("Invalid query 1");
			return;
		}
		$studyInfo = $result->fetch_assoc();
		return $studyInfo;
	}
	function editStudy(){
		$studyName = $_GET['studyname'];
		$mysqli= new mysqli("localhost", "root", "", "researchdatabase");
		if(empty($_POST['name'])||empty($_POST['budget']) 
			|| empty($_POST['startDateDay'])|| empty($_POST['startDateMonth'])|| empty($_POST['startDateYear']) 
			|| empty($_POST['endDateDay'])|| empty($_POST['endDateMonth'])|| empty($_POST['endDateYear'])
			||empty($_POST['supervisorName'])){
			if(isset($_GET['editStudyAttempt'])){
				header("Location: /study/edit-study.php?studyname=".$studyName."&failure");
				return;
			}
			else{
				return;
			}
		}
		
		if(!$mysqli->query("USE researchdatabase")){
			die("failed to use database");
		}
		
		$name = $_POST['name'];
		$budgetString = $_POST['budget'];
		$supervisorName = $_POST['supervisorName'];
		$budget = (double) $budgetString;
		$startMonthString = $_POST['startDateMonth'];
		$startMonth = 1;
		if($startMonthString == "january")$startMonth = 1;
		elseif($startMonthString =="february")$startMonth = 2;
		elseif($startMonthString =="march")$startMonth = 3;
		elseif($startMonthString =="april")$startMonth = 4;
		elseif($startMonthString =="may")$startMonth = 5;
		elseif($startMonthString =="june")$startMonth = 6;
		elseif($startMonthString =="july")$startMonth = 7;
		elseif($startMonthString =="august")$startMonth = 8;
		elseif($startMonthString =="september")$startMonth = 9;
		elseif($startMonthString =="october")$startMonth = 10;
		elseif($startMonthString =="november")$startMonth = 11;
		else $startMonth = 12;
	
		//Getting startDate into date format
		$time = mktime(0,0,0, $startMonth, (int)$_POST['startDateDay'], (int)$_POST['startDateYear']);
		if($time < mktime(0,0,0,1,1,1900) || $time >time()){
			die("Invalid birthday magic");
		}
		$startDate = date('Y-m-d', $time);
		$endMonthString = $_POST['endDateMonth'];
		$endMonth = 1;
		if($endMonthString == "january")$endMonth = 1;
		elseif($endMonthString =="february")$endMonth = 2;
		elseif($endMonthString =="march")$endMonth = 3;
		elseif($endMonthString =="april")$endMonth = 4;
		elseif($endMonthString =="may")$endMonth = 5;
		elseif($endMonthString =="june")$endMonth = 6;
		elseif($endMonthString =="july")$endMonth = 7;
		elseif($endMonthString =="august")$endMonth = 8;
		elseif($endMonthString =="september")$endMonth = 9;
		elseif($endMonthString =="october")$endMonth = 10;
		elseif($endMonthString =="november")$endMonth = 11;
		else $endMonth = 12;
	
		//Getting endDate into date format
		$time = mktime(0,0,0, $endMonth, (int)$_POST['endDateDay'], (int)$_POST['endDateYear']);
		if($time < mktime(0,0,0,1,1,1900)){
			die("Invalid birthday magic");
		}
		$endDate = date('Y-m-d', $time);
		
		//Make sure inputs are valid
		if(!is_numeric($budget)){
			header('Location: /study/edit-study.php?studyname=".$studyName."&failureNotNumeric');
		}
		$name = $mysqli->real_escape_string($name);
		$supervisorName = $mysqli->real_escape_string($supervisorName);
		
		//Have supervisorName need supervisorID
		$query="SELECT user.id FROM person INNER JOIN user ON person.id = user.id WHERE name = '$supervisorName' and type_flag = 'M'";
		$result = $mysqli->query($query);
		if($result->num_rows < 1){
			header("Location: /study/edit-study.php?studyname=".$studyName."&failureInvalidSupervisor");
		}
		$data =$result->fetch_assoc();
		$supervisor_id = $data['id'];
		
		//actual query
		if($name == $_GET['studyname']){
			$query = "UPDATE study SET budget=$budget, end_date='$endDate', start_date='$startDate', supervisor_id=$supervisor_id
				WHERE name = '$name'";
			if(!$mysqli->query($query)){
				echo $query;
				die("Invalid query 1");
				return;
			}
		}
		header("Location: /index.php?successfulEditStudy");
	}
?>
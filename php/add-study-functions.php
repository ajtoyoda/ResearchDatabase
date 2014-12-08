<?php
	require_once("gf.php");
	function addStudy(){
		if(!isset($_GET['addStudyAttempt'])){
			return;
		}
		$mysqli= mysqliInit();
		if(empty($_POST['name'])||empty($_POST['budget']) 
			|| empty($_POST['startDateDay'])|| empty($_POST['startDateMonth'])|| empty($_POST['startDateYear']) 
			|| empty($_POST['endDateDay'])|| empty($_POST['endDateMonth'])|| empty($_POST['endDateYear'])
			||empty($_POST['supervisorName'])){
			header("Location: /study/add-study.php?failure");
		}
		
		//Get posted info
		$name = $_POST['name'];
		$budgetString = $_POST['budget'];
		$supervisorName = $_POST['supervisorName'];
		$budget = (double) $budgetString;

		$startMonthString = $_POST['startDateMonth'];
		$startDate = formatDate((int)$_POST['startDateDay'], $startMonthString, (int)$_POST['startDateYear']);

		$endMonthString = $_POST['endDateMonth'];
		$endDate = formatDate((int)$_POST['endDateDay'], $endMonthString,(int)$_POST['endDateYear']);
		
		//Make sure inputs are valid
		if(!is_numeric($budget)){
			header('Location: /study/add-study.php?failureNotNumeric');
		}
		$name = $mysqli->real_escape_string($name);
		$supervisorName = $mysqli->real_escape_string($supervisorName);
		$query="SELECT user.id FROM person INNER JOIN user ON person.id = user.id WHERE name = '$supervisorName' and type_flag = 'M'";
		$data = queryCheckAssoc($mysqli, $query, '/study/add-study.php?failureInvalidSupervisor');
		$supervisor_id = $data['id'];
		
		//Check if duplicate study name
		$checkQuery = "SELECT name FROM study";
		$result= $mysqli->query($checkQuery);
		for($count = 0; $count <$result->num_rows; $count++){
			$data = $result->fetch_assoc();
			if($data['name'] == $name){
				header('Location: /study/add-study.php?failureDuplicateName');
			}
		}
		/*$query = "INSERT INTO study VALUES('$name', $budget, '$endDate', '$startDate', $supervisor_id)";
		queryNoReturn($mysqli, $query);
		header('Location: /index.php?successfulAddStudy');
		*/
	}
?>
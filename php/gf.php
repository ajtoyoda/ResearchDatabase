<?php
	/* This file should be included in almost every file and defines general purpose query functions
	 * gf stands for general functions
	*/


	//This function initializes mysqli and returns a valid object of class mysqli
	//On error it dies to Failed to use database
	function mysqliInit(){
		$mysqli= new mysqli("localhost", "root", "", "researchdatabase");
		if(!$mysqli->query("USE researchdatabase")){
			die("Failed to use database");
		}
		return $mysqli;
	}
	//This function queries database using passed in object and returns nothing
	//On error it dies to Failed query no return and echos query
	function queryNoReturn($mysqli, $query){
		if(!$mysqli->query($query)){
			echo $query;
			die("Failed query no return");
		}
	}
	//This function queries database using passed in object and returns an dictionary based off a row
	//On error it dies to Failed query assoc and echos query
	function queryAssoc($mysqli, $query){
		$result = $mysqli->query($query);
		if(!$result){
			echo $query;
			die("Failed query check assoc");
		}
		$data = $result->fetch_assoc();
		return $data;
	}
	//This function queries database using passed in object and returns an dictionary based off a row
	//It also checks that there is at least one row		
	//On no rows returned it goes to location errorLocation
	function queryCheckAssoc($mysqli, $query, $errorLocation){
		$result = $mysqli->query($query);
		if(!$result){
			echo $query;
			die("Failed query check assoc");
		}
		if($result->num_rows < 1){
			header('Location = '.$errorLocation);
		}
		return $result->fetch_assoc();
	}
	//This function queries database using passed in object and returns an array of dictionarys based off of rows
	//On error it dies to Failed query array and echos query	
	function queryArray($mysqli, $query, $key){
		$result = $mysqli->query($query);
		if(!$result){
			echo $query;
			die("Failed query array");
		}
		$dataArray = array();
		for($count = 0; $count < $result->num_rows; $count++){
			$rowData = $result->fetch_assoc();
			array_push($dataArray, $rowData[$key]);
		}
		return $dataArray;
	}
	//This function takes a day (int) month(string) and year(int) and converts it to format 'YYYY-MM-DD'
	//It returns the date type on error it goes to /?failure
	function formatDate($day,$monthString,$year){
		$monthString = strtolower($monthString);
		$month = 1;
		if($monthString == "january")$month = 1;
		elseif($monthString =="february")$month = 2;
		elseif($monthString =="march")$month = 3;
		elseif($monthString =="april")$month = 4;
		elseif($monthString =="may")$month = 5;
		elseif($monthString =="june")$month = 6;
		elseif($monthString =="july")$month = 7;
		elseif($monthString =="august")$month = 8;
		elseif($monthString =="september")$month = 9;
		elseif($monthString =="october")$month = 10;
		elseif($monthString =="november")$month = 11;
		else $month = 12;
	
	//Getting birthday into date format
		$time = mktime(0,0,0, $month, $day, $year);
		if($time < mktime(0,0,0,1,1,1800)){
			header("Location: /?failure");
		}
		return date('Y-m-d', $time);
	}
?>
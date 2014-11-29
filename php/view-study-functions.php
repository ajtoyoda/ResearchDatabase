<?php
    //This function displays study info for the view_study page
    function showAllStudyInfo($studyName){
        $mysqli = new mysqli("localhost", "root", "", "researchdatabase");
        $query = "SELECT * FROM study WHERE name = '$studyName'";
        $result = $mysqli->query($query);
        if(!$result){
            die("Query 1 failed");
        }
        $data = $result->fetch_assoc();
        echo "<h1>Study name</h1>
            <div id="study-info">
              <ul>
                <li><p>Start date:</p></li>
                <li><p>1/1/1900</p></li>
              </ul>
              <ul>
                <li><p>End date:</p></li>
                <li><p>1/1/1900</p></li>
              </ul>
              <ul>
                <li><p>Budget:</p></li>
                <li><p>$100000000</p></li>
              </ul>
              <ul>
                <li><p>Supervisor:</p></li>
                <li><p>Dr. Soandso</p></li>
              </ul>
            </div>"
    }


?>
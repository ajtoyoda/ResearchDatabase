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


?>
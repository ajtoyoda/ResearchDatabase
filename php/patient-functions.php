<?php

require_once("gf.php");

// Retrieves a the record for a single patient.
//   id: The ID of the patient to retrieve the database record for.
//
// Returns: A map of key value pairs for the patient.
//
function getPatient($id)
{
    $mysqli = mysqliInit();
    $query  = "SELECT p.healthcare_no, p.weight, p.height FROM patient AS p WHERE p.id = '" . $id . "'";
    
    return queryAssoc($mysqli, $query);
}

?>

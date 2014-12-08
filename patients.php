<?php
  require_once("/php/user-permissions.php");
  require_once("/php/login-functions.php");
  require_once("/php/gf.php");
  verifyLoggedIn();
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Patients :: Medical Research Database</title>
    
    <link rel="stylesheet" href="/css/layout.css" />
    <link rel="stylesheet" href="/css/nav.css" />
    <link rel="stylesheet" href="/css/table.css" />
  </head>
  <body>
    <noscript>
      <div id="js-banner">
        <div class="container">
          <div class="padding">
            <p>This website works best with JavaScript enabled.</p>
          </div>
        </div>
      </div>
    </noscript>
    <header>
      <div class="container">
        <div id="logout-tab">
          <p><a href="/logout.php">Log out</a></p>
        </div>
        <div class="padding">
          <h1><a href="/" title="Home">Medical Research Database</a></h1>
        </div>
      </div>
    </header>
    <nav>
      <div class="container">
        <ul>
          <li><a href="/">My studies</a></li>
          <li id="current"><a href="/patients.php">Patients</a></li>
          <?php printManageUsers(false, false);?>
          <li><a href="/account.php?userID=<?php echo $_SESSION["userid"]; ?>">My account</a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
    </nav>
    <div id="content-outer">
      <div class="container">
        <div id="content-inner">
          <div class="padding">
            <div class="filter-header" id="top">
              <ul>
                <li style="width: 390px;"><h1>Patients</h1></li>
                <form action="/patients.php?filter" method="POST" >
				  <li>
				  <select name="studySelect" style="margin-right: 10px;">
				  <option name="default" value="">All Studies</option>
				  <?php
					$mysqli= mysqliInit();
					$query = "SELECT name FROM study";
					$dataArray = queryArray($mysqli, $query, 'name');
					for($count = 0; $count < count($dataArray); $count++){
						if(isset($_GET['filter']) && $dataArray[$count] == $_POST['studySelect']){
							echo "<option name=\"".$dataArray[$count]."\" value=\"".$dataArray[$count]."\" selected=\"selected\">".$dataArray[$count]."</option>";
						}
						else{
							echo "<option name=\"".$dataArray[$count]."\" value=\"".$dataArray[$count]."\">".$dataArray[$count]."</option>";
						}
					}
				  ?>
				  </select>
				  </li>
				<li class="button"><input type="submit" name="filterButton" value="Filter"/></li>
                <li class="button"><input type="button" name="addPatient" value="New" onclick="window.location = '/patient/add-patient.php';" /></li>
				</form>
              </ul>
            </div>
            <div class="clearfix"></div>
            <table class="patient-table">
              <tr id="header">
				<th><p>Name</th></p>
				<th colspan="3"></th>
              </tr>
			  <?php
			    $mysqli = mysqliInit();
				if(!isset($_GET['filter']) || empty($_POST['studySelect']) || $_POST['studySelect'] == ""){
					$query = "SELECT id FROM patient";
				}
				else{
					$query = "SELECT DISTINCT person.id AS id FROM patient INNER JOIN person ON patient.id = person.id INNER JOIN results ON person.id = results.patient_number WHERE results.study_name = '".$_POST['studySelect']."'"; 
				}
				$key="id";
				
				$dataArray = queryArray($mysqli, $query, $key);
				
				for($count = 0; $count < count($dataArray);$count++){
					$nameQuery = "SELECT name FROM person WHERE id=\"".$dataArray[$count]."\"";
					$name =queryAssoc($mysqli, $nameQuery);
					echo " <tr>
			    <td><p>".$name['name']."</p></td>
			    <td><p><a href=\"/patient/view-patient.php?ID=".$dataArray[$count]."\">Patient</a></p></td>
			    <td><p><a href=\"/patient/view-personal.php?ID=".$dataArray[$count]."\">Personal</a></p></td>
			    <td><p><a href=\"/patient/view-medical.php?ID=".$dataArray[$count]."\">Medical</a></p></td>
			  </tr> ";
				}
			  ?>
			  </table>
           
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div class="container">
        <div class="padding">
          <p><a href="/">My studies</a> | <a href="/patients.php">Patients</a> | <?php printManageUsers(true,true); ?> <a href="/account.php?userID=<?php echo $_SESSION["userid"]; ?>">My account</a></p>
          <p>Copyright &copy; 2014. Use of this website is permitted for authorized personnel only.</p>
        </div>
      </div>
    </footer>
  </body>
</html>
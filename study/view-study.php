<?php
  require_once("../php/user-permissions.php");
  require_once("../php/login-functions.php");
  require_once("../php/view-study-functions.php");
  require_once("../php/success-failure-functions.php");
  require_once("../php/index-functions.php");
  require_once("../php/gf.php");
  verifyLoggedIn();
  verifyStudy();
  //This code makes sure they cant try and filter by patients while still keeping a type as the filter with variable
  if(!isset($_SESSION['filterByResults'])){
	$_SESSION['filterByResults'] = "all";
  }
  if(!empty($_POST['filterBySelect'])){
	if($_SESSION['filterByResults']  != $_POST['filterBySelect']){
		$_POST['filterWithSelect']= 'all';
	}
	$_SESSION['filterByResults']	= $_POST['filterBySelect'];
  }
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title><?php
				if(isset($_GET['studyname'])){
				echo $_GET['studyname'];
              }
			  ?></title>
    
    <link rel="stylesheet" href="/css/layout.css" />
    <link rel="stylesheet" href="/css/nav.css" />
    <link rel="stylesheet" href="/css/study.css" />
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
          <li id="current"><a href="/">My studies</a></li>
          <li><a href="/patients.php">Patients</a></li>
          <?php printManageUsers(false, false); ?>
          <li><a href="/account.php?userID=<?php echo $_SESSION["userid"]; ?>">My account</a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
    </nav>
    <div id="content-outer">
      <div class="container">
        <div id="content-inner">
          <div class="padding">
            <?php
               $studyName = $_GET['studyname'];
               showAllStudyInfo($studyName);
            ?>
            <div class="clearfix"></div>
            
            <div class="filter-header">
              <ul>
                <li style="width:340px;"><h2>Results</h2></li>
				<?php echo "<form name=\"filterForm\" action=\"/study/view-study.php?filter&studyname=".$_GET['studyname']."\" method=\"POST\">";?>
				<li>
				  <?php echo "<select name=\"filterBySelect\", style=\"margin-right: 10px;\" onchange=\"filterForm.submit()\">";
					echo "<option name=\"default\" value=\"\">No Filter</option>";
					if(isset($_GET['filter']) && $_POST['filterBySelect']=='patients'){
						echo "<option name=\"patients\" value=\"patients\" selected=\"selected\">Patients</option>
						<option name=\"resultType\" value=\"resultType\">Type</option>";
					}
					elseif(isset($_GET['filter']) && $_POST['filterBySelect']=='resultType'){
						echo "<option name=\"patients\" value=\"patients\">Patients</option>
						<option name=\"resultType\" value=\"resultType\" selected=\"selected\">Type</option>";
					}
					else{
						echo "<option name=\"patients\" value=\"patients\">Patients</option>
						<option name=\"resultType\" value=\"resultType\">Type</option>";
					}
				  ?>
				  </select>
        </li>
        <li>
				  <select name="filterWithSelect", style="margin-right: 2px;" onchange="filterForm.submit()">
					<?php
						echo "<option name=\"all\" value=\"all\">All</option>";
						if(isset($_GET['filter'])){
							$filterBy = $_POST['filterBySelect'];
							$mysqli = mysqliInit();
							if($filterBy =='patients'){
								$query = "SELECT name FROM patient INNER JOIN person ON patient.id = person.id";
								$dataArray = queryArray($mysqli, $query, 'name');
							}
							if($filterBy == 'resultType'){
								$query = "SELECT DISTINCT type FROM type";
								$dataArray = queryArray($mysqli, $query, 'type');
							}
							for($count = 0; $count < count($dataArray); $count++){
								if(isset($_GET['filter']) && $_POST['filterWithSelect'] == $dataArray[$count]){
									echo "<option name=\"".$dataArray[$count]."\" value=\"".$dataArray[$count]."\" selected=\"selected\">".$dataArray[$count]."</option>";
								}
								else{
									echo "<option name=\"".$dataArray[$count]."\" value=\"".$dataArray[$count]."\">".$dataArray[$count]."</option>";
								}
							}
						}
					?>
				  </select>
				</li>
				</form>
				<?php
                echo "<li class=\"button\"><input type=\"button\" name=\"addResult\" value=\"New\" onclick=\"window.location = 'add-result.php?numTypes=0&amp;studyname=".$_GET['studyname']."';\" /></li>";
				?>
				</ul>
            </div>
            <div class="clearfix"></div>
            <?php successMessage("The result was successfully updated.", "successfulEditResult"); ?>
            <?php successMessage("The result was successfully created.", "successfulAddResult"); ?>
            <?php successMessage("The result was successfully deleted.", "successfulDeleteResult"); ?>
            <table>
              <tr id="header">
                <th><p>Patient</p></th>
                <th><p>Date</p></th>
                <th><p>Type</p></th>
                <th><p>Description</p></th>
                <th></th>
              </tr>
				<?php
					$studyName = $_GET['studyname'];
					$mysqli=mysqliInit();
					if(empty($_POST['filterWithSelect']) OR $_POST['filterWithSelect'] == 'all')
						$result = getResults($studyName);
					elseif($_POST['filterBySelect']== 'patients'){
						$query = "SELECT person.id AS id FROM patient INNER JOIN person ON patient.id = person.id WHERE name='".$_POST['filterWithSelect']."'";
						$data = queryAssoc($mysqli, $query);
						$query = "SELECT id FROM results WHERE study_name='".$studyName."' AND  patient_number=".$data['id'];
						$result = queryArray($mysqli, $query, 'id');
					}elseif($_POST['filterBySelect']== 'resultType'){
						$query = "SELECT result_id FROM type WHERE study_name='".$studyName."' AND type='".$_POST['filterWithSelect']."'";
						$result = queryArray($mysqli, $query, 'result_id');
					}else{
						$result = getResults($studyName);
					}
					for($count = 0; $count < count($result); $count++){
						showAllResultInfo($result[$count]);
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
          <p><a href="/">My studies</a> | <a href="/patients.php">Patients</a> | <?php printManageUsers(true, false); ?> <a href="/account.php?userID=<?php echo $_SESSION["userid"]; ?>">My account</a></p>
          <p>Copyright &copy; 2014. Use of this website is permitted for authorized personnel only.</p>
        </div>
      </div>
    </footer>
  </body>
</html>

<?php
  require_once("../php/user-permissions.php");
  require_once("../php/login-functions.php");
  require_once("../php/patient-functions.php");
  require_once("../php/edit-user-functions.php");
  require_once("../php/success-failure-functions.php");
  require_once("../php/gf.php");
  require_once("../php/edit-medical-functions.php");
  // Check URL arguments.
  if (!isset($_GET["ID"]))
      header("Location: /patients.php");
  setNum();
  deleteMed();
  deleteIssue();
  edit();
  verifyLoggedIn();
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Edit <?php echo getPerson($_GET["ID"])["name"]; ?> :: Medical Research Database</title>
    
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
            <div class="add-header" id="top">
              <ul>
                <li style="width: 440px;"><h1>Edit <?php echo getPerson($_GET["ID"])["name"]; ?></h1></li>
				        <li style="width: 320px; text-align: right;"><h2>Medical Information</h2></li>
              </ul>
            </div>
            <div class="clearfix"></div>
            <?php errorMessage("All fields must be filled.", "failureNotSet"); ?>
			      <a href="/patient/view-medical.php?ID=<?php echo $_GET["ID"]; ?>">&lt; Medical information</a>
            <form action="/patient/edit-medical.php?ID=<?php echo $_GET["ID"]."&amp;numIssues=".$_GET['numIssues']."&amp;numMeds=".$_GET['numMeds']; ?>&editAttempt&setNumTypes" method="post">
              <div class="form-container">
              <h2>Pre-existing medical conditions and notes</h2>
              <!-- 
                   Jamie: My guess is this needs to be like adding types to results, which I don't know how to do.
                   This makes the buttons appear but I don't know what to do after that, query-wise.
              -->
              <?php
				        $numIssues = $_GET['numIssues'];
						$mysqli = mysqliInit();
						$query = "SELECT issues FROM patient_health_issues WHERE id = ".$_GET['ID'];
						$issue = queryArray($mysqli, $query, 'issues');
						if(count($issue)<$numIssues){
							for($count = count($issue); $count < $numIssues; $count++){
								array_push($issue, "");
							}
						}
				        if(!$numIssues){
					        echo " <ul class=\"result-type\"><li><p>Condition:</p></li><li><input type=\"button\" name=\"addCondition\" style=\"width: 100px; margin-left: 0px;\" value=\"Add\" onclick=\"window.location='/patient/edit-medical.php?ID=" . $_GET["ID"] . "&amp;numIssues=1&amp;numMeds=".$_GET['numMeds']."&amp;setNumTypes';\" /></li></ul>";
				        }
				        else{
					        if($numIssues == 1){
					        echo "<ul class=\"result-type\"><li><p>Condition:</p></li><li>
                            <input type=\"text\" name=\"issue0\" value=\"".$issue[0]."\" />
                            <input type=\"button\" name=\"addCondition\" value=\"Remove\" onclick=\"window.location='/patient/edit-medical.php?ID=" . $_GET["ID"] . "&amp;numIssues=".($numIssues-1)."&amp;numMeds=".$_GET['numMeds']."&amp;setNumTypes&amp;deleteIssueAttempt=".$issue[0]."';\" />
					        <input type=\"button\" name=\"addCondition\" value=\"Add\" onclick=\"window.location='/patient/edit-medical.php?ID=" . $_GET["ID"] . "&amp;numIssues=".++$numIssues."&amp;numMeds=".$_GET['numMeds']."&amp;setNumTypes';\" />
					        </li>
					        </ul>";
					        }else{
					        echo "<ul class=\"result-type\"><li><p>Condition:</p></li>
							        <li>
							        <input type=\"text\" name=\"issue0\" value=\"".$issue[0]."\"/>
							        <input type=\"button\" name=\"removeCondition\" value=\"Remove\" onclick=\"window.location='/patient/edit-medical.php?ID=" . $_GET["ID"] . "&amp;numIssues=".($numIssues-1)."&amp;numMeds=".$_GET['numMeds']."&amp;setNumTypes&amp;deleteIssueAttempt=".$issue[0]."';\" />
							        </li>
						        </ul>";
					        for($count = 2; $count < $numIssues; $count++){
						        echo "<ul class=\"result-type\">
								        <li><p></p></li>
								        <li>
								        <input type=\"text\" name=\"issue".($count-1)."\" value=\"".$issue[$count-1]."\" />
								        <input type=\"button\" name=\"removeCondition\" value=\"Remove\" onclick=\"window.location='/patient/edit-medical.php?ID=" . $_GET["ID"] . "&amp;numIssues=".($numIssues-1)."&amp;numMeds=".$_GET['numMeds']."&amp;setNumTypes&amp;deleteIssueAttempt=".$issue[$count-1]."';\" />
								        </li>
							        </ul>";
					        }
					        echo"<ul class=\"result-type\">
					        <li><p></p></li>
					        <li>
                            <input type=\"text\" name=\"issue".($numIssues-1)."\" value=\"".$issue[$numIssues-1]."\" />
                            <input type=\"button\" name=\"removeCondition\" value=\"Remove\" onclick=\"window.location='/patient/edit-medical.php?ID=" . $_GET["ID"] . "&amp;numIssues=".($numIssues-1)."&amp;numMeds=".$_GET['numMeds']."&amp;setNumTypes&amp;deleteIssueAttempt=".$issue[$numIssues-1]."';\" />
							<input type=\"button\" name=\"addCondition\" value=\"Add\" onclick=\"window.location='/patient/edit-medical.php?ID=" . $_GET["ID"] . "&amp;numIssues=".(1+$numIssues)."&amp;numMeds=".$_GET['numMeds']."&amp;setNumTypes';\" />
					        </li>
					        </ul>";
				        }
				        }
				        ?>
                <div class="clearfix"></div>
                <h2>Medications</h2>
              <?php
				        $numMeds = $_GET['numMeds'];
						$mysqli = mysqliInit();
						$query = "SELECT medications FROM patient_medications WHERE id = ".$_GET['ID'];
						$meds = queryArray($mysqli, $query, 'medications');
						if(count($meds)<$numMeds){
							for($count = count($meds); $count < $numMeds; $count++){
								array_push($meds, "");
							}
						}
				        if(!$numMeds){
					        echo " <ul class=\"result-type\"><li><p>Medication:</p></li><li><input type=\"button\" name=\"addCondition\" style=\"width: 100px; margin-left: 0px;\" value=\"Add\" onclick=\"window.location='/patient/edit-medical.php?ID=" . $_GET["ID"] . "&amp;numIssues=".$_GET['numIssues']."&amp;numMeds=1&amp;setNumTypes';\" /></li></ul>";
				        }
				        else{
					        if($numMeds == 1){
					        echo "<ul class=\"result-type\"><li><p>Medication:</p></li><li>
                            <input type=\"text\" name=\"med0\" value=\"".$meds[0]."\" />
                            <input type=\"button\" name=\"addCondition\" value=\"Remove\" onclick=\"window.location='/patient/edit-medical.php?ID=" . $_GET["ID"] . "&amp;numIssues=".$_GET['numIssues']."&amp;numMeds=".($numMeds-1)."&amp;setNumTypes&amp;deleteMedsAttempt=".$meds[0]."';\" />
					        <input type=\"button\" name=\"addCondition\" value=\"Add\" onclick=\"window.location='/patient/edit-medical.php?ID=" . $_GET["ID"] . "&amp;numIssues=".$_GET['numIssues']."&amp;numMeds=".($numMeds+1)."&amp;setNumTypes';\" />
					        </li>
					        </ul>";
					        }else{
					        echo "<ul class=\"result-type\"><li><p>Medication:</p></li>
							        <li>
							        <input type=\"text\" name=\"med0\" value=\"".$meds[0]."\"/>
							        <input type=\"button\" name=\"addCondition\" value=\"Remove\" onclick=\"window.location='/patient/edit-medical.php?ID=" . $_GET["ID"] . "&amp;numIssues=".$_GET['numIssues']."&amp;numMeds=".($numMeds-1)."&amp;setNumTypes&amp;deleteMedsAttempt=".$meds[0]."';\" />
							        </li>
						        </ul>";
					        for($count = 2; $count < $numMeds; $count++){
						        echo "<ul class=\"result-type\">
								        <li><p></p></li>
								        <li>
								        <input type=\"text\" name=\"med".($count-1)."\" value=\"".$meds[$count-1]."\"/>
								        <input type=\"button\" name=\"addCondition\" value=\"Remove\" onclick=\"window.location='/patient/edit-medical.php?ID=" . $_GET["ID"] . "&amp;numIssues=".$_GET['numIssues']."&amp;numMeds=".($numMeds-1)."&amp;setNumTypes&amp;deleteMedsAttempt=".$meds[$count-1]."';\" />
								        </li>
							        </ul>";
					        }
					        echo"<ul class=\"result-type\">
					        <li><p></p></li>
					        <li>
                            <input type=\"text\" name=\"med".($numMeds-1)."\"value=\"".$meds[$numMeds-1]."\" />
                            <input type=\"button\" name=\"addCondition\" value=\"Remove\" onclick=\"window.location='/patient/edit-medical.php?ID=" . $_GET["ID"] . "&amp;numIssues=".$_GET['numIssues']."&amp;numMeds=".($numMeds-1)."&amp;setNumTypes&amp;deleteMedsAttempt=".$meds[$numMeds-1]."';\" />
							<input type=\"button\" name=\"addCondition\" value=\"Add\" onclick=\"window.location='/patient/edit-medical.php?ID=" . $_GET["ID"] . "&amp;numIssues=".$_GET['numIssues']."&amp;numMeds=".++$numMeds."&amp;setNumTypes';\" />
					        </li>
					        </ul>";
				        }
				        }
				        ?>
                <div class="clearfix"></div>
              </div>
              <div class="form-buttons">
                <input type="submit" name="submit" value="Update" />
                <input type="button" name="cancel" value="Cancel" onclick="window.location='/patient/view-medical.php?ID=<?php echo $_GET["ID"]."&amp;editAttempt"; ?>';" />
              </div>
            </form>
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
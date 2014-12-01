<?php
  require_once("../php/user-permissions.php");
  require_once("../php/login-functions.php");
  require_once("../php/view-study-functions.php");
  require_once("../php/index-functions.php");
  require_once("../php/edit-study-functions.php");
  require_once("../php/success-failure-functions.php");
  verifyLoggedIn();
  if (!isAdministrator())
        header("Location: /");
  editStudy();
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Edit $study :: Medical Research Database</title>
    
    <link rel="stylesheet" href="/css/layout.css" />
    <link rel="stylesheet" href="/css/nav.css" />
  </head>
  <body onload="document.getElementById('name').focus();">
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
          <li><a href="/account.php">My account</a></li>
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
            echo "<h1>Edit $studyName</h1>";
			?>
            <p><a href="/">&lt; My studies</a></p>
            <?php errorMessage("The study could not be updated.", "failure"); ?>
            <?php errorMessage("The budget must be a number.", "failureNotNumeric"); ?>
            <?php errorMessage("The supervisor specified does not exist.", "failureInvalidSupervisor"); ?>
            <?php
				$studyName = $_GET['studyname'];
				echo "<form action=\"/study/edit-study.php?studyname=".$studyName."&editStudyAttempt\" method=\"post\">";
			?>
				<div class="form-container">
                <ul>
                  <li><p>Study name:</p></li>
				  <?php
					$studyName = $_GET['studyname'];
				    echo "<li><input type=\"text\" name=\"name\" id=\"name\" value=\"".$studyName."\" readonly=\"readonly\"/></li>";
				  ?>
				  </ul>
				<ul class="supervisor">
                  <li><p>Supervisor Name:</p></li>
				  <?php
					$mysqli = new mysqli("localhost", "root", "", "researchdatabase");
					$studyName = $_GET['studyname'];
					$result = $mysqli->query("SELECT p.name AS name 
					FROM person AS p INNER JOIN study AS s ON s.supervisor_id = p.id 
					WHERE s.name = '$studyName'");
					if(!$result){
						echo "SELECT p.name AS name FROM person AS p INNER JOIN study AS s ON s.supervisor_id = p.id WHERE s.name = $studyName";
						die("Invalid Query");
					}
					if($result->num_rows >0){
					$data = $result->fetch_assoc();
					$supervisorName =$data['name'];
						echo "<li><input type=\"text\" name=\"supervisorName\" value=\"".$supervisorName."\"/></li>";
					}else{
						echo "<li><input type=\"text\" name=\"supervisorName\"/></li>";
					}
				  ?>
				  </ul>
                <ul class="budget">
                  <li><p>Budget:</p></li>
				  <?php
					$studyInfo = getStudyInfo($_GET['studyname']);
					echo "<li><p>$ <input type=\"text\" name=\"budget\" value=\"".$studyInfo['budget']."\" /></p></li>";
				  ?>
                </ul>
                <ul class="birthday">
                  <!-- Jamie: As with before, to select a particular option, add selected="selected" to it. -->
                  <li><p>Start date:</p></li>
                  <li>
                    <p>Day:
                      <select name="startDateDay">
                      <?php
					  		$study = getStudyInfo($_GET['studyname']);
							$studyday = (int)substr($study['start_date'], 8,2);
							outputOptionNumbers(1,$studyday-1);
							echo "<option value=\"".$studyday."\" selected =\"selected\">".$studyday."</option>";
							outputOptionNumbers($studyday+1, 31);
					  ?>
                      </select>
                    </p>
                    <p>Month:
                      <select name="startDateMonth">
                        <?php
							$study = getStudyInfo($_GET['studyname']);
							$studymonth = (int)substr($study['start_date'], 5,2);
							outputOptionMonths($studymonth);
						?>
                      </select>
                    </p>
                    <p>Year:
						<?php
						$study = getStudyInfo($_GET['studyname']);
						$studyyear = (int)substr($study['start_date'], 0,4);
						echo "<input type=\"text\" name=\"startDateYear\" value=\"".$studyyear."\" />";
						?>
                    </p>
                  </li> 
                </ul>
                <ul class="birthday">
                  <li><p>Start date:</p></li>
                  <li>
                    <p>Day:
                      <select name="endDateDay">
					  <?php
					  		$study = getStudyInfo($_GET['studyname']);
							$studyday = (int)substr($study['end_date'], 8,2);
							outputOptionNumbers(1,$studyday-1);
							echo "<option value=\"".$studyday."\" selected =\"selected\">".$studyday."</option>";
							outputOptionNumbers($studyday+1, 31);
						?>
						</select>
                    </p>
                    <p>Month:
                      <select name="endDateMonth">
				        <?php
							$study = getStudyInfo($_GET['studyname']);
							$studymonth = (int)substr($study['end_date'], 5,2);
							outputOptionMonths($studymonth);
						?>
                      </select>
                    </p>
                    <p>Year:
						<?php
						$study = getStudyInfo($_GET['studyname']);
						$studyyear = (int)substr($study['start_date'], 0,4);
						echo "<input type=\"text\" name=\"endDateYear\" value=\"".$studyyear."\" />";
						?>
                    </p>
                  </li> 
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="form-buttons">
                <input type="submit" name="submit" value="Create" />
                <input type="button" name="cancel" value="Cancel" onclick="window.location='/';" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div class="container">
        <div class="padding">
          <p><a href="/">My studies</a> | <a href="/patients.php">Patients</a> | <?php printManageUsers(true, false); ?> <a href="/account.php">My account</a></p>
          <p>Copyright &copy; 2014. Use of this website is permitted for authorized personnel only.</p>
        </div>
      </div>
    </footer>
  </body>
</html>

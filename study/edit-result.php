<?php
  require_once("../php/user-permissions.php");
  require_once("../php/login-functions.php");
  require_once("../php/view-study-functions.php");
  require_once("../php/index-functions.php");
  require_once("../php/edit-results-functions.php");
  verifyLoggedIn();
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Edit a Result :: Medical Research Database</title>
    
    <link rel="stylesheet" href="/css/layout.css" />
    <link rel="stylesheet" href="/css/nav.css" />
  </head>
  <body onload="document.getElementById('patient').focus();">
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
            <h1>Edit a result</h1>
			<?php
				$studyName = getStudyFromResult($_GET['id']);
				echo "<p><a href=\"/study/view-study.php?studyname=".$studyName."\">&lt;".$studyName." </a></p>";
				echo "<form action=\"/study/edit-results.php?id=".$_GET['id']."&editResultsAttempt\" method=\"post\">";
			?>
              <div class="form-container">
                <ul>
                  <li><p>Patient name:</p></li>
				  <?php
				    echo "<li><input type=\"text\" name=\"patient\" id=\"patient\" value=\"".getPatientFromResult($_GET['id'])."\" /></li>";
				  ?>
				</ul>
                <ul class="birthday">
                  <li><p>Result date:</p></li>
                  <li>
                    <p>Day:
                      <select name="resultDay">
						<?php
							$result = getResult($_GET['id']);
							$resultday = (int)substr($result['date'], 8,2);
							outputOptionNumbers(1,$resultday-1);
							echo "<option value=\"".$resultday."\" selected =\"selected\">".$resultday."</option>";
							outputOptionNumbers($resultday+1, 31);
						?>
                      </select>
                    </p>
                    <p>Month:
                      <select name="resultMonth">
						<?php
							$result = getResult($_GET['id']);
							$resultmonth = (int)substr($result['date'], 5,2);
							outputOptionMonths($resultmonth);
						?>
                      </select>
                    </p>
                    <p>Year:
					<?php
						$result = getResult($_GET['id']);
						$resultyear = (int)substr($result['date'], 0,4);
						echo "<input type=\"text\" name=\"resultYear\" value=\"".$resultyear."\" />";
					?>
                    </p>
                  </li> 
                </ul>
                <ul>
                  <li><p>Description:</p></li>
<<<<<<< HEAD
                  <li><input type="text" name="year" value="$description" /></li>
                </ul>
                <!-- Jamie: This ul block is what needs to be duplicated for each type. -->
                <ul class="result-type">
=======
				  <?php
				  $result = getResult($_GET['id']);
                  echo "<li><input type=\"text\" name=\"description\" value=\"".$result['description']."\" /></li>";
				  ?>
				  </ul>
                <ul>
>>>>>>> fed0b6b830fdb97f635932fc86e13f55052bc414
                  <!-- TODO: Not sure how to deal with result types... -->
                  <li><p>Type:</p></li>
                  <li>
                    <input type="text" name="type0" value="$type" />
                    <input type="button" name="addType" value="Add" onclick="something??" />
                  </li>
                </ul>
              </div>
              <div class="clearfix"></div>
              <div class="form-buttons">
                <input type="submit" name="submit" value="Update" />
                <!-- Jamie: This javascript needs to be updated properly. -->
				<?php
                echo "<input type=\"button\" name=\"cancel\" value=\"Cancel\" onclick=\"window.location='/study/view-study.php?studyname=".getStudyFromResult($_GET['id'])."'/>;" 
				?>
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

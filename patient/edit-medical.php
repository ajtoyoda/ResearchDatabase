<?php
  require_once("../php/user-permissions.php");
  require_once("../php/login-functions.php");
  require_once("../php/patient-functions.php");
  require_once("../php/edit-user-functions.php");

  // Check URL arguments.
  if (!isset($_GET["ID"]))
      header("Location: /patients.php");
  
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
			      <a href="/patient/view-medical.php?ID=<?php echo $_GET["ID"]; ?>">&lt; Medical information</a>
            <form action="/patient/edit-medical.php?ID=<?php echo $_GET["ID"]; ?>&amp;editAttempt" method="post">
              <div class="form-container">
              <h2>Pre-existing medical conditions and notes</h2>
              <!-- 
                   Jamie: My guess is this needs to be like adding types to results, which I don't know how to do.
                   This makes the buttons appear but I don't know what to do after that, query-wise.
              -->
              <?php
				        $numConditions = $_GET['numConditions'];
				        if(!$numConditions){
					        echo " <ul class=\"result-type\"><li><p>Condition:</p></li><li><input type=\"button\" name=\"addCondition\" style=\"width: 100px; margin-left: 0px;\" value=\"Add\" onclick=\"window.location='/patient/edit-medical.php?ID=" . $_GET["ID"] . "&amp;numConditions=1';\" /></li></ul>";
				        }
				        else{
					        if($numConditions == 1){
					        echo "<ul class=\"result-type\"><li><p>Condition:</p></li><li>
                            <input type=\"text\" name=\"condition0\" />
                            <input type=\"button\" name=\"addCondition\" value=\"Remove\" onclick=\"window.location='/patient/edit-medical.php?ID=" . $_GET["ID"] . "&amp;numConditions=".($numConditions-1)."';\" />
					        <input type=\"button\" name=\"addCondition\" value=\"Add\" onclick=\"window.location='/patient/edit-medical.php?ID=" . $_GET["ID"] . "&amp;numConditions=".++$numConditions."';\" />
					        </li>
					        </ul>";
					        }else{
					        echo "<ul class=\"result-type\"><li><p>Condition:</p></li>
							        <li>
							        <input type=\"text\" name=\"condition0\" />
							        <input type=\"button\" name=\"addCondition\" value=\"Remove\" onclick=\"window.location='/patient/edit-medical.php?ID=" . $_GET["ID"] . "&amp;numConditions=".($numConditions-1)."';\" />
							        </li>
						        </ul>";
					        for($count = 2; $count < $numConditions; $count++){
						        echo "<ul class=\"result-type\">
								        <li><p></p></li>
								        <li>
								        <input type=\"text\" name=\"condition".($count-1)."\" />
								        <input type=\"button\" name=\"addCondition\" value=\"Remove\" onclick=\"window.location='/patient/edit-medical.php?ID=" . $_GET["ID"] . "&amp;numConditions=".($numConditions-1)."';\" />
								        </li>
							        </ul>";
					        }
					        echo"<ul class=\"result-type\">
					        <li><p></p></li>
					        <li>
                            <input type=\"text\" name=\"condition".($numConditions-1)."\" />
                            <input type=\"button\" name=\"addCondition\" value=\"Add\" onclick=\"window.location='/patient/edit-medical.php?ID=" . $_GET["ID"] . "&amp;numConditions=".++$numConditions."';\" />
					        </li>
					        </ul>";
				        }
				        }
				        ?>
                <div class="clearfix"></div>
                <h2>Medications</h2>
                <!-- Similarely, not sure how to get this one to work. -->
                <!-- We need another add medication result thing here. -->
                <div class="clearfix"></div>
              </div>
              <div class="form-buttons">
                <input type="submit" name="submit" value="Update" />
                <input type="button" name="cancel" value="Cancel" onclick="window.location='/patient/view-medical.php?ID=<?php echo $_GET["ID"]; ?>';" />
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
<?php
  require_once("../php/user-permissions.php");
  require_once("../php/login-functions.php");
  require_once("../php/patient-functions.php");
  require_once("../php/edit-user-functions.php");

  // Check URL arguments.
  if (!isset($_GET["ID"]))
      header("Location: /patients.php");

  verifyLoggedIn();
  if(isset( $_GET['editAttempt']))
  {
	$mysqli = mysqliInit();
	$query = 	"UPDATE patient 
				SET Healthcare_No = '".$_POST['healthcareNumber']."',Height = ".$_POST['height'].",Weight = ".$_POST['weight']."
				WHERE patient.ID = ".$_GET['ID'];
	queryNoReturn($mysqli, $query);
	header("Location: /patient/view-patient.php?ID=".$_GET['ID']."&success");
  }
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
          <li><a href="/account.php">My account</a></li>
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
                <li style="width: 500px;"><h1>Edit <?php echo getPerson($_GET["ID"])["name"]; ?></h1></li>
				        <li style ="width: 260px; text-align: right;"><h2 style="padding-right: 10px;">Patient Information</h2></li>
              </ul>
            </div>
            <div class="clearfix"></div>
			      <a href="/patient/view-patient.php?ID=<?php echo $_GET["ID"]; ?>">&lt; Patient information</a>
			      <form action="/patient/edit-patient.php?ID=<?php echo $_GET["ID"]; ?>&amp;editAttempt" method="post">
				      <div class="form-container">
					      <ul>
					        <li><p>Healthcare no.:</p></li>
					        <li><input type="text" name="healthcareNumber" value="<?php echo getPatient($_GET["ID"])["healthcare_no"]; ?>" /></li>
					      </ul>
                <ul>
                  <li><p>Height:</p></li>
                  <li><input type="text" name="height" value="<?php echo getPatient($_GET["ID"])["height"]; ?>" /></li>
                </ul>
                <ul>
                  <li><p>Weight:</p></li>
                  <li><input type="text" name="weight" value="<?php echo getPatient($_GET["ID"])["weight"]; ?>" /></li>
                </ul>
					      <div class="clearfix"></div>
				      </div>
				      <div class="form-buttons">
                <input type="submit" name="submit" value="Update" />
                <input type="button" name="cancel" value="Cancel" onclick="window.location='/patient/view-patient.php?ID=<?php echo $_GET["ID"]; ?>';" />
              </div>
			      </form>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div class="container">
        <div class="padding">
          <p><a href="/">My studies</a> | <a href="/patients.php">Patients</a> | <?php printManageUsers(true,true); ?> <a href="/account.php">My account</a></p>
          <p>Copyright &copy; 2014. Use of this website is permitted for authorized personnel only.</p>
        </div>
      </div>
    </footer>
  </body>
</html>
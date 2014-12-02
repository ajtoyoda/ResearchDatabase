<?php
  require_once("php/user-permissions.php");
  require_once("php/login-functions.php");
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
                <li style="width: 525px;"><h1>Patients</h1></li>
				<li><select name="studySelect" style="margin-right: 10px;">
				<option name="default">All Studies</option>
				<option name="studyName1">studyName1 </option></select></li>
                <li><input type="button" name="addPatient" value="New" onclick="window.location = '/patient/add-patient.php';" /></li>
              </ul>
            </div>
            <div class="clearfix"></div>
            <table class="patient-table">
              <tr id="header">
				<th><p>Name</th></p>
				<th colspan="3"></th>
              </tr>
			  
			  <td><p>Patient Name1</p></td>
			  <td><p><a href="/patient/view-patient.php">Patient</a></p></td>
			  <td><p><a href="/patient/view-personal.php">Personal</a></p></td>
			  <td><p><a href="/patient/view-medical.php">Medical</a></p></td>
			  
            </table>
           
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
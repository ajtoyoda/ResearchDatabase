<?php
  require_once("../php/user-permissions.php");
  require_once("../php/login-functions.php");
  require_once("../php/view-study-functions.php");
  require_once("../php/index-functions.php");
  verifyLoggedIn();
  verifyStudy();
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
               showAllStudyInfo($studyName);
            ?>
            <div class="clearfix"></div>
            
            <div class="add-header">
              <ul>
                <li><h2>Results</h2></li>
				<?php
                echo "<li><input type=\"button\" name=\"addResult\" value=\"New\" onclick=\"window.location = 'add-result.php?numTypes=0&studyname=".$_GET['studyname']."';\" /></li>";
				?>
				</ul>
            </div>
            <div class="clearfix"></div>
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
					$result = getResults($studyName);
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
          <p><a href="/">My studies</a> | <a href="/patients.php">Patients</a> | <?php printManageUsers(true, false); ?> <a href="/account.php">My account</a></p>
          <p>Copyright &copy; 2014. Use of this website is permitted for authorized personnel only.</p>
        </div>
      </div>
    </footer>
  </body>
</html>

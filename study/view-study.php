<?php
  require_once("../php/user-permissions.php");
  require_once("../php/login-functions.php");
  require_once("../php/view-study.php");
  verifyLoggedIn();
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
              if(isset($_GET['studyname'])){
                $studyName = $_GET['studyname'];
                showAllStudyInfo($studyName);
              }
			  else{
				header("Location: /");
			  }
            ?>
            <div class="clearfix"></div>
            
            <div class="add-header">
              <ul>
                <li><h2>Results</h2></li>
                <li><input type="button" name="addResult" value="New" onclick="window.location = 'add-study.php';" /></li>
              </ul>
            </div>
            <div class="clearfix"></div>
            <table>
              <tr id="header">
                <th><p>Patient</p></th>
                <th><p>Date</p></th>
                <th><p>Description</p></th>
                <th></th>
              </tr>
              <tr>
                <td><p>John Doe</p></td>
                <td><p>January 1, 1900</p></td>
                <td><p>Patient has gone crazy</p></td>
                <td><a href="edit-result.php">Edit</a><a href="delete-result.php">Delete</a></p></td>
              </tr>
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

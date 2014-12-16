<?php
  require_once("/php/user-permissions.php");
  require_once("/php/login-functions.php");
  require_once("/php/index-functions.php");
  verifyLoggedIn();
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Studies</title>
    
    <link rel="stylesheet" href="/m/css/layout.css" />
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
          <?php printManageUsers(false,false); ?>
          <li><a href="/account.php?userID=<?php echo $_SESSION["userid"]; ?>">My account</a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
    </nav>
    <div id="content-outer">
      <div class="container">
        <div id="content-inner">
          <div class="padding">
            <?php errorMessage("An unknown error ocurred.", "failure"); ?>
            <div class="add-header" id="top">
              <ul>
                <li><h1>My studies</h1></li>
                <li><?php printNewStudyButton(); ?></li>
              </ul>
            </div>
            <div class="clearfix"></div>
            <?php successMessage("The new study was successfully created.", "successfulAddStudy"); ?>
            <?php successMessage("The study was successfully updated.", "successfulEditStudy"); ?>
            <div class="info-box">
				      <ul>
					      <?php
						      $canViewStudies = getStudies();
						      for($count = 0; $count < count($canViewStudies); $count++){
						        showStudy($canViewStudies[$count]);
						      }
					      ?>
              </ul>
              <div class="clearfix"></div>
            </div>
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

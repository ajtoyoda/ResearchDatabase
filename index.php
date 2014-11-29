<?php
  require_once("/php/user-permissions.php");
  require_once("/php/login-functions.php");
  verifyLoggedIn();
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Home :: Medical Research Database</title>
    
    <link rel="stylesheet" href="/css/layout.css" />
    <link rel="stylesheet" href="/css/nav.css" />
    <link rel="stylesheet" href="/css/info-box.css" />
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
          <?php printManageUsers(false); ?>
          <li><a href="/account.php">My account</a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
    </nav>
    <div id="content-outer">
      <div class="container">
        <div id="content-inner">
          <div class="padding">
            <h1>My studies</h1>
            <p>You are not currently participating in any studies.</p>
            <div class="info-box">
              <ul>
                <li class="first">
                  <div class="view-edit">
                    <p><a href="/study/view-study.php" class="view">View</a>
                    <a href="/study/edit-study.php" class="edit">Edit</a></p>
                  </div>
                  <div class="padding">
                    <h1>Respiratory Volumes</h1>
                    <p>Some information</p>
                    <p>Some more information</p>
                  </div>
                </li>
                <li>
                  <div class="view-edit">
                    <p><a href="/study/view-study.php" class="view">View</a>
                    <a href="/study/edit-study.php" class="edit">Edit</a></p>
                  </div>
                  <div class="padding">
                    <h1>Respiratory Volumes</h1>
                    <p>Some information</p>
                    <p>Some more information</p>
                  </div>
                </li>
                <li class="first">
                  <div class="view-edit">
                    <p><a href="/study/view-study.php" class="view">View</a>
                    <a href="/study/edit-study.php" class="edit">Edit</a></p>
                  </div>
                  <div class="padding">
                    <h1>Respiratory Volumes</h1>
                    <p>Some information</p>
                    <p>Some more information</p>
                  </div>
                </li>
                <li>
                  <div class="view-edit">
                    <p><a href="/study/view-study.php" class="view">View</a>
                    <a href="/study/edit-study.php" class="edit">Edit</a></p>
                  </div>
                  <div class="padding">
                    <h1>Respiratory Volumes</h1>
                    <p>Some information</p>
                    <p>Some more information</p>
                  </div>
                </li>
                <li class="first">
                  <div class="view-edit">
                    <p><a href="/study/edit-study.php" class="view">View</a>
                    <a href="blahblah.htm" class="edit">Edit</a></p>
                  </div>
                  <div class="padding">
                    <h1>Respiratory Volumes</h1>
                    <p>Some information</p>
                    <p>Some more information</p>
                  </div>
                </li>
              </ul>
              <div class="clearfix" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div class="container">
        <div class="padding">
          <p><a href="/">My studies</a> | <a href="/patients.php">Patients</a> | <?php printManageUsers(true); ?> <a href="/account.php">My account</a></p>
          <p>Copyright &copy; 2014. Use of this website is permitted for authorized personnel only.</p>
        </div>
      </div>
    </footer>
  </body>
</html>

<?php
  require_once("../php/user-permissions.php");
  require_once("../php/login-functions.php");
  verifyLoggedIn();
  if(!isAdministrator())
	header('Location: /');
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Delete USERNAME :: Medical Research Database</title>
    
    <link rel="stylesheet" href="/css/layout.css" />
    <link rel="stylesheet" href="/css/nav.css" />
  </head>
  <body onload="document.getElementById('supervisor').focus();">
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
          <li><a href="/patients.php">Patients</a></li>
          <?php printManageUsers(false, true); ?>
          <li><a href="/account.php">My account</a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
    </nav>
    <div id="content-outer">
      <div class="container">
        <div id="content-inner">
          <div class="padding">
            <h1>Delete USERNAME</h1>
            <p><a href="/users.php">&lt; Manage users</a></p>
            <p>Before this user can be deleted, the studies they supervise must be reassigned to a different MD.</p>
            <!--
                  Jamie: Change action to the name of the page containing your code.
                  we probably want to redirect to /users.php once the user is added.
            -->
            <form action="delete-md.php?deleteMD" method="post">
              <div class="form-container">
                <ul class="wide-select">
                  <li><p>New supervisor:</p></li>
                  <li>
                    <select name="supervisor">
                      <option name="supervisor1">Jaimie: Autopopulate this</option>
                    </select>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="form-buttons">
                <input type="submit" name="submit" value="Delete" />
                <input type="button" name="cancel" value="Cancel" onclick="window.location = '/users.php';" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div class="container">
        <div class="padding">
          <p><a href="/">My studies</a> | <a href="/patients.php">Patients</a> | <?php printManageUsers(true, true); ?> <a href="/account.php">My account</a></p>
          <p>Copyright &copy; 2014. Use of this website is permitted for authorized personnel only.</p>
        </div>
      </div>
    </footer>
  </body>
</html>

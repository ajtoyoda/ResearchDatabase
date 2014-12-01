<?php
  require_once("php/user-permissions.php");
  require_once("php/login-functions.php");
  require_once("php/view-study-functions.php");
  require_once("php/user-functions.php");
  require_once("php/success-failure-functions.php");
  verifyLoggedIn();
  if(!isAdministrator()){
	header("Location: /");
  }
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Manage Users :: Medical Research Database</title>
    
    <link rel="stylesheet" href="/css/layout.css" />
    <link rel="stylesheet" href="/css/nav.css" />
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
          <li><a href="/">My studies</a></li>
          <li><a href="/patients.php">Patients</a></li>
          <?php printManageUsers(false, true);?>
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
                <li><h1>Manage users</h1></li>
                <li><input type="button" name="addUser" value="New" onclick="window.location = '/user/add-user.php';" /></li>
              </ul>
            </div>
            <div class="clearfix"></div>
            <?php successMessage("The user was successfully deleted.", "successfulDeleteUser"); ?>
            <?php successMessage("The user was successfully added.", "successfulAddUser"); ?>
            <?php successMessage("The user was successfully updated.", "successfulEditUser"); ?>
            <table>
              <tr id="header">
                <th><p>User</p></th>
                <th><p>ID</p></th>
                <th><p>Type</p></th>
                <th></th>
              </tr>
              <?php
				$userID = getUsers();
				for($count = 0; $count < count($userID); $count++){
					showAllUserInfo($userID[$count]);
				}
			  ?>
            </table>
			<!-- ============================== Table 2 =================================================== -->
            <h1>User permissions</h1>
            <?php successMessage("Successfully modified the users' permissions.", "successfulEditPermissions"); ?>
            <table class="edit-only">
              <tr id="header">
                <th><p>Study</p></th>
				<th><p>User</p></th>
                <th><p>Can read</p></th>
                <th><p>Can write</p></th>
                <th></th>
              </tr>
				<?php
                $studyNames = getAllStudies();
				for($count = 0; $count < count($studyNames); $count++){
					showView_EditInfo($studyNames[$count]);
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
          <p><a href="/">My studies</a> | <a href="/patients.php">Patients</a> | <?php printManageUsers(true,true); ?> <a href="/account.php">My account</a></p>
          <p>Copyright &copy; 2014. Use of this website is permitted for authorized personnel only.</p>
        </div>
      </div>
    </footer>
  </body>
</html>
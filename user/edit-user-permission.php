<?php
  require_once("../php/user-permissions.php");
  require_once("../php/login-functions.php");
  require_once("../php/view-study-functions.php");
  require_once("../php/user-functions.php");
  require_once("../php/edit-user-permission-function.php");
  verifyLoggedIn();
  if(!isAdministrator()){
	header("Location: /");
  }
  editUserPermissions();
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Edit Permissions :: Medical Research Database</title>
    
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
          <li><a href="/patients.php">Patients</a></li>
          <?php printManageUsers(false, true);?>
          <li><a href="/account.php?userID=<?php echo $_SESSION["userid"]; ?>">My account</a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
    </nav>
    <div id="content-outer">
      <div class="container">
        <div id="content-inner">
          <div class="padding">
		  <?php
            $studyName = $_GET['studyName'];
			echo "<h1>Edit ".$studyName." permissions</h1>";
          ?>
			<p><a href="/users.php">&lt; Manage users</a></p>
			<?php
				$studyName = $_GET['studyName'];
				echo "<form action=\"/user/edit-user-permission.php?attemptEditUserPermissions&amp;studyName=".$studyName."\" method=\"post\">";
			?>
			<table class="no-modify">
                <tr id="header">
                  <th><p>User</p></th>
                  <th><p>Can read</p></th>
                  <th><p>Can write</p></th>
                </tr>
                <?php
					$viewEdit = getViewEdit($_GET['studyName']);
					for($count = 0; $count <count($viewEdit); $count++){
						echo "<tr>
							<td><p>".$viewEdit[$count]['name']."</p></td>";
						if($viewEdit[$count]['canRead'] == 1){
							echo "<td><input type=\"checkbox\" name=\"canRead".$count."\" value=\"1\" checked=\"checked\"/></td>";
						}else{
							echo "<td><input type=\"checkbox\" name=\"canRead".$count."\" value=\"1\"/></td>";
						}
						if($viewEdit[$count]['canWrite'] == 1){
							echo "<td><input type=\"checkbox\" name=\"canWrite".$count."\" value=\"1\" checked=\"checked\"/></td>";
						}else{
							echo "<td><input type=\"checkbox\" name=\"canWrite".$count."\" value=\"1\" /></td>";
						}
						echo "</tr>";
					}
				?>
              </table>
              <div class="form-buttons">
                <input type="submit" name="submit" value="Update" />
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
          <p><a href="/">My studies</a> | <a href="/patients.php">Patients</a> | <?php printManageUsers(true,true); ?> <a href="/account.php?userID=<?php echo $_SESSION["userid"]; ?>">My account</a></p>
          <p>Copyright &copy; 2014. Use of this website is permitted for authorized personnel only.</p>
        </div>
      </div>
    </footer>
  </body>
</html>
<?php
  require_once("../php/user-permissions.php");
  require_once("../php/login-functions.php");
  require_once("../php/edit-user-functions.php");
  verifyLoggedIn();
  if(!isAdministrator())
	header('Location: /');
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Edit <?php getPerson($_GET["userID"])["name"]; ?> :: Medical Research Database</title>
    
    <link rel="stylesheet" href="/css/layout.css" />
    <link rel="stylesheet" href="/css/nav.css" />
  </head>
  <body onload="document.getElementById('supervisor').focus();">
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
          <?php printManageUsers(false, true); ?>
          <li><a href="/account.php?userID=<?php echo $_SESSION["userid"]; ?>">My account</a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
    </nav>
    <div id="content-outer">
      <div class="container">
        <div id="content-inner">
          <div class="padding">
		  <h1>Edit <?php echo getPerson($_GET["userID"])["name"]; ?></h1>
            <p><a href="/users.php">&lt; Manage users</a></p>
            <p>This MD is currently supervising projects. Before their user type can be modified, the projects they are supervising must be assigned to a new MD.</p>
			<?php echo "<form action=\"edit-md.php?editMD&amp;userID=".$_GET['userID']."\" method=\"post\">";?>
              <div class="form-container">
                <ul class="wide-select">
                  <li><p>New supervisor:</p></li>
                  <li>
				  <select name="supervisor">
					<?php 
					$mysqli= new mysqli("localhost", "root", "", "researchdatabase");
					if(!$mysqli->query("USE researchdatabase")){
						die("Failed to use database");
					}
					$query = "SELECT p.name AS name, p.id AS id FROM user AS u INNER JOIN person AS p
							ON u.id = p.id WHERE u.type_flag='M' AND u.id != ".$_GET['userID'];
                    $result = $mysqli->query($query);
					if(!$result){
						die("Invalid query");
					}
					if($result->num_rows ==0){
						header('Location: /user/edit_user.php?userID=' . $_GET("userID") . '&failureCannotEditOnlyMD');
					}
					for($count =0; $count < $result->num_rows; $count++){
						$data = $result->fetch_assoc();
						echo "<option value=\"".$data['id']."\">".$data['name']."</option>";
					}
					?>
					</select>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="form-buttons">
                <input type="submit" name="submit" value="Update" />
                <input type="button" name="cancel" value="Cancel" onclick="window.location = '/user/edit-user.php?userID=<?php echo $_GET["userID"]; ?>';" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div class="container">
        <div class="padding">
          <p><a href="/">My studies</a> | <a href="/patients.php">Patients</a> | <?php printManageUsers(true, true); ?> <a href="/account.php?userID=<?php echo $_SESSION["userid"]; ?>">My account</a></p>
          <p>Copyright &copy; 2014. Use of this website is permitted for authorized personnel only.</p>
        </div>
      </div>
    </footer>
  </body>
</html>

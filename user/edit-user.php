<?php
  require_once("../php/user-permissions.php");
  require_once("../php/login-functions.php");
  require_once("../php/index-functions.php");	
  require_once("../php/edit-user-functions.php");
  verifyLoggedIn();
  if (!isAdministrator())
	header("Location: /");
  editUser();
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Edit $user :: Medical Research Database</title>
    
    <link rel="stylesheet" href="/css/layout.css" />
    <link rel="stylesheet" href="/css/nav.css" />
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
			<?php
				$userID = $_GET['userID'];
				$user = getUser($userID);
				echo"<h1>Edit ".$user['username']."</h1>";
			?>
            <p><a href="/users.php">&lt; Manage users</a></p>
			<?php
				$userID = $_GET['userID'];
				echo "<form action=\"edit-user.php?editAttempt&userID=".$userID."\" method=\"post\">";
			?>
			<h2>Personal information</h2>
              <div class="form-container">
                <ul>
                  <li><p>Name:</p></li>
				  <?php
					$person = getPerson($_GET['userID']);
					echo "<li><input type=\"text\" name=\"name\" value=\"".$person['name']."\" /></li>";
				  ?>
                  
                </ul>
                <ul class="birthday">
                  <li><p>Birthday:</p></li>
                  <li>
                    <p>Day:
                      <select name="birthday">
						<?php
							$person = getPerson($_GET['userID']);
							$birthday = (int)substr($person['birthday'], 8,2);
							outputOptionNumbers(1,$birthday-1);
							echo "<option value=\"".$birthday."\" selected =\"selected\">".$birthday."</option>";
							outputOptionNumbers($birthday+1, 31);
						?>
                      </select>
                    </p>
                    <p>Month:
                      <select name="birthmonth">
						<?php
							$person = getPerson($_GET['userID']);
							$birthmonth = (int)substr($person['birthday'], 5,2);
							outputOptionMonths($birthmonth);
						?>
                      </select>
                    </p>
                    <p>Year:
					<?php
						$userID = $_GET['userID'];
						$person = getPerson($userID);
						$birthyear = (int)substr($person['birthday'], 0,4);
						echo "<input type=\"text\" name=\"birthyear\" value=\"".$birthyear."\" />";
					?>
                    </p>
                  </li> 
                </ul>
                <ul class="gender">
                  <li><p>Gender:</p></li>
                  <li>
					<?php
						$userID = $_GET['userID'];
						$person = getPerson($userID);
						if($person['gender'] == 'M'){
						echo "<p><input type=\"radio\" name=\"gender\" value=\"male\" checked=\"checked\"/> Male</p>
							<p><input type=\"radio\" name=\"gender\" value=\"female\" /> Female</p>";
						}else{
							echo "<p><input type=\"radio\" name=\"gender\" value=\"male\" /> Male</p>
							<p><input type=\"radio\" name=\"gender\" value=\"female\" checked=\"checked\"/> Female</p>";
						}
						
					?>
                  </li>
                </ul>
                <!-- 
                     Jamie: just concatenate all the address stuff.  The separate fields
                     are to make this look more "official."
                -->
                <?php
					$userID = $_GET['userID'];
					$person = getPerson($userID);
					$substrings = explode('|', $person['address'], 4);
					if(count($substrings != 4)){
					echo "<ul>
						<li><p>Address line 1:</p></li>
						<li><input type=\"text\" name=\"addressLine1\" value=\"".$substrings[0]."\" /></li>
					</ul>
					<ul>
						<li><p>Address line 2:</p></li>
						<li><input type=\"text\" name=\"addressLine2\" value=\"\" /></li>
					</ul>
					<ul>
						<li><p>City:</p></li>
						<li><input type=\"text\" name=\"city\" value=\"\" /></li>
					</ul>
					<ul>
						<li><p>Country:</p></li>
						<li><input type=\"text\" name=\"country\" value=\"\" /></li>
					</ul>";
					}else{
					echo "<ul>
						<li><p>Address line 1:</p></li>
						<li><input type=\"text\" name=\"addressLine1\" value=\"".$substrings[0]."\" /></li>
					</ul>
					<ul>
						<li><p>Address line 2:</p></li>
						<li><input type=\"text\" name=\"addressLine2\" value=\"".$substrings[1]."\" /></li>
					</ul>
					<ul>
						<li><p>City:</p></li>
						<li><input type=\"text\" name=\"city\" value=\"".$substrings[2]."\" /></li>
					</ul>
					<ul>
						<li><p>Country:</p></li>
						<li><input type=\"text\" name=\"country\" value=\"".$substrings[3]."\" /></li>
					</ul>";
					}
				?>
                <ul>
                  <li><p>Phone number:</p></li>
                  <?php
				  	$userID = $_GET['userID'];
					$person = getPerson($userID);
					echo"<li><input type=\"text\" name=\"phone\" value=\"".$person['phone']."\" /></li>";
				  ?>
                </ul>
                <ul>
                  <li><p>Email:</p></li>
				  <?php
				  	$userID = $_GET['userID'];
					$person = getPerson($userID);
					echo"<li><input type=\"text\" name=\"email\" value=\"".$person['email']."\" /></li>";
				  ?>
                </ul>
                <div class="clearfix"></div>
              </div>
              <h2>User information</h2>
              <div class="form-container">
                <ul>
                  <li><p>Username:</p></li>
				  <?php 
					$userID = $_GET['userID'];
					$user = getUser($userID);
					echo"<li><input type=\"text\" name=\"username\" value=\"".$user['username']."\" /></li>";
				  ?>
                </ul>
                <ul>
                  <li><p>Password:</p></li>
				  <?php 
					$userID = $_GET['userID'];
					$user = getUser($userID);
					echo"<li><input type=\"password\" name=\"password\" /></li>";
				  ?>
                </ul>
                <ul>
                  <li><p>Confirm password</p></li>
                  <?php 
					$userID = $_GET['userID'];
					$user = getUser($userID);
					echo"<li><input type=\"password\" name=\"confirm\" /></li>";
				  ?>
                </ul>
                <ul class="type">
                  <li><p>User type:</p></li>
                  <li>
                  <?php 
					$userID = $_GET['userID'];
					$user = getUser($userID);
					if($user['type'] == 'A'){
					echo "<p><input type=\"radio\" name=\"type\" value=\"R\" /> Research assistant</p>
                    <p><input type=\"radio\" name=\"type\" value=\"M\" /> MD</p>
                    <p><input type=\"radio\" name=\"type\" value=\"A\" checked=\"checked\"/> Administrator</p>";
					}elseif($user['type'] =='M'){
					echo "<p><input type=\"radio\" name=\"type\" value=\"R\" /> Research assistant</p>
                    <p><input type=\"radio\" name=\"type\" value=\"M\" checked=\"checked\"/> MD</p>
                    <p><input type=\"radio\" name=\"type\" value=\"A\" /> Administrator</p>";					
					}else{
					echo "<p><input type=\"radio\" name=\"type\" value=\"R\" checked=\"checked\"/> Research assistant</p>
                    <p><input type=\"radio\" name=\"type\" value=\"M\" /> MD</p>
                    <p><input type=\"radio\" name=\"type\" value=\"A\" /> Administrator</p>";					
					}
				  ?>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
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
          <p><a href="/">My studies</a> | <a href="/patients.php">Patients</a> | <?php printManageUsers(true, true); ?> <a href="/account.php">My account</a></p>
          <p>Copyright &copy; 2014. Use of this website is permitted for authorized personnel only.</p>
        </div>
      </div>
    </footer>
  </body>
</html>

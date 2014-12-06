<?php
  require_once("../php/user-permissions.php");
  require_once("../php/login-functions.php");
  require_once("../php/index-functions.php");	
  require_once("../php/edit-user-functions.php");
  require_once("../php/success-failure-functions.php");
  verifyLoggedIn();
  
  // Check URL arguments.
  if (!isset($_GET["userID"]))
      header("Location: /");
  
  // No, you can't edit your friend's account.
  if ($_GET["userID"] != $_SESSION["userid"])
      header("Location: /");
  
  editUser('self');
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Edit account :: Medical Research Database</title>
    
    <link rel="stylesheet" href="/css/layout.css" />
    <link rel="stylesheet" href="/css/nav.css" />
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
          <?php printManageUsers(false, false); ?>
          <li id="current"><a href="/account.php?userID=<?php echo $_SESSION["userid"]; ?>">My account</a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
    </nav>
    <div id="content-outer">
      <div class="container">
        <div id="content-inner">
          <div class="padding">
			      <h1>Edit account</h1>
            <p><a href="/account.php?userID=<?php echo $_GET["userID"]; ?>">&lt; My account</a></p>
            <?php errorMessage("Your account could not be updated", "failure");
			errorMessage("Your account could not be updated because the passwords do not match.", "failureInvalidPassword");
      errorMessage("Your account could not be updated because they are the only MD. Add a new MD before changing this user's type.", "failureCannotEditOnlyMD");
			?>
			<?php
				$userID = $_GET['userID'];
				if(isset($_GET['emergencyContact'])){
					echo "<form action=\"/account/edit-account.php?emergencyContact&amp;editAttempt&amp;userID=".$userID."\" method=\"post\">";
				}else{
					echo "<form action=\"/account/edit-account.php?editAttempt&amp;userID=".$userID."\" method=\"post\">";
				}
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
					if(count($substrings) <4){
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
              <?php
			  if(!isset($_GET['emergencyContact'])){
			    echo "<div class=\"form-buttons\">
                <input type=\"submit\" name=\"submit\" value=\"Update\" />
                <input type=\"button\" name=\"cancel\" value=\"Cancel\" onclick=\"window.location = '/account.php?userID=" . $_GET["userID"] . "';\" />
				<input type=\"button\" style=\"width: 250px\" name=\"addEmergC\" value=\"Add Emergency Contact\" onclick=\"window.location = '/user/edit-user.php?userID=".$_GET['userID']."&amp;emergencyContact';\"/>";
					}else{
					echo    
              "<h2>Emergency contact information</h2>
              <div class=\"form-container\">
                <ul>
                  <li><p>Name:</p></li>
                  <li><input type=\"text\" name=\"emergname\" id=\"name\" /></li>
                </ul>
                <ul class=\"birthday\">
                  <li><p>Birthday:</p></li>
                  <li>
                    <p>Day:
                      <select name=\"emergbirthday\">
                        <!-- Jamie: set the selected option by adding selected=\"selected\" to the
                             proper option. -->
                        <option value=\"1\">1</option>
                        <option value=\"2\">2</option>
                        <option value=\"3\">3</option>
                        <option value=\"4\">4</option>
                        <option value=\"5\">5</option>
                        <option value=\"6\">6</option>
                        <option value=\"7\">7</option>
                        <option value=\"8\">8</option>
                        <option value=\"9\">9</option>
                        <option value=\"10\">10</option>
                        <option value=\"11\">11</option>
                        <option value=\"12\">12</option>
                        <option value=\"13\">13</option>
                        <option value=\"14\">14</option>
                        <option value=\"15\">15</option>
                        <option value=\"16\">16</option>
                        <option value=\"17\">17</option>
                        <option value=\"18\">18</option>
                        <option value=\"19\">19</option>
                        <option value=\"20\">20</option>
                        <option value=\"21\">21</option>
                        <option value=\"22\">22</option>
                        <option value=\"23\">23</option>
                        <option value=\"24\">24</option>
                        <option value=\"25\">25</option>
                        <option value=\"26\">26</option>
                        <option value=\"27\">27</option>
                        <option value=\"28\">28</option>
                        <option value=\"29\">29</option>
                        <option value=\"30\">30</option>
                        <option value=\"31\">31</option>
                      </select>
                    </p>
                    <p>Month:
                      <select name=\"emergbirthmonth\">
                        <!-- Jamie: set the selected option by adding selected=\"selected\" to the
                             proper option. -->
                        <option value=\"january\">January</option>
                        <option value=\"february\">February</option>
                        <option value=\"march\">March</option>
                        <option value=\"april\">April</option>
                        <option value=\"may\">May</option>
                        <option value=\"june\">June</option>
                        <option value=\"july\">July</option>
                        <option value=\"august\">August</option>
                        <option value=\"september\">September</option>
                        <option value=\"october\">October</option>
                        <option value=\"november\">November</option>
                        <option value=\"december\">December</option>
                      </select>
                    </p>
                    <p>Year:
                      <input type=\"text\" name=\"emergbirthyear\"/>
                    </p>
                  </li> 
                </ul>
                <ul class=\"gender\">
                  <li><p>Gender:</p></li>
                  <li>
                    <p><input type=\"radio\" name=\"emerggender\" value=\"M\" /> Male</p>
                    <p><input type=\"radio\" name=\"emerggender\" value=\"F\" /> Female</p>
                  </li>
                </ul>
                <!-- 
                     Jamie: just concatenate all the address stuff.  The separate fields
                     are to make this look more \"official.\"
                -->
                <ul>
                  <li><p>Address line 1:</p></li>
                  <li><input type=\"text\" name=\"emergaddressLine1\" /></li>
                </ul>
                <ul>
                  <li><p>Address line 2:</p></li>
                  <li><input type=\"text\" name=\"emergaddressLine2\" /></li>
                </ul>
                <ul>
                  <li><p>City:</p></li>
                  <li><input type=\"text\" name=\"emergcity\" /></li>
                </ul>
                <ul>
                  <li><p>Country:</p></li>
                  <li><input type=\"text\" name=\"emergcountry\" /></li>
                </ul>
                <ul>
                  <li><p>Phone number:</p></li>
                  <li><input type=\"text\" name=\"emergphone\" /></li>
                </ul>
                <ul>
                  <li><p>Email:</p></li>
                  <li><input type=\"text\" name=\"emergemail\" /></li>
                </ul>
                <div class=\"clearfix\"></div>
              </div>
              <div class=\"form-buttons\">
                <input type=\"submit\" name=\"submit\" value=\"Create\" />
                <input type=\"button\" name=\"cancel\" value=\"Cancel\" onclick=\"window.location = '/account.php?userID=" . $_GET["userID"] . "';\" />";}
				
				?>
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
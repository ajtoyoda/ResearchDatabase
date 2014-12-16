<?php
  require_once("../php/user-permissions.php");
  require_once("../php/login-functions.php");
  require_once("../php/edit-user-functions.php");
  require_once("../php/gf.php");
  require_once("../php/add-patient-functions.php");
 
  verifyLoggedIn();
  addPatient();
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Add a patient :: Medical Research Database</title>
    
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
          <li id="current"><a href="/patients.php">Patients</a></li>
          <?php printManageUsers(false, false);?>
          <li><a href="/account.php?userID=<?php echo $_SESSION["userid"]; ?>">My account</a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
    </nav>
    <div id="content-outer">
      <div class="container">
        <div id="content-inner">
          <div class="padding">
            <h1>Add a patient</h1>
            <a href="/patients.php">&lt; Patients</a>
			<?php	
				if(!isset($_GET['emergencyContact'])){
					echo "<form action=\"/patient/add-patient.php?createAttempt\" method=\"post\">";
				}
				else{
					echo "<form action=\"/patient/add-patient.php?createAttempt&emergencyContact\" method=\"post\">";
				}
			?>
              <h2>Personal information</h2>
              <div class="form-container">
                <ul>
                  <li><p>Name:</p></li>
                  <li><input type="text" name="name" /></li>
                </ul>
                <ul class="birthday">
                  <li><p>Birthday:</p></li>
                  <li>
                    <p>Day: 
                      <select name="birthday">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                      </select>
                    </p>
                    <p>Month:
                      <select name="birthmonth">
                        <option value="january">January</option>
                        <option value="february">February</option>
                        <option value="march">March</option>
                        <option value="april">April</option>
                        <option value="may">May</option>
                        <option value="june">June</option>
                        <option value="july">July</option>
                        <option value="august">August</option>
                        <option value="september">September</option>
                        <option value="october">October</option>
                        <option value="november">November</option>
                        <option value="december">December</option>
                      </select>
                    </p>
                    <p>Year: <input type="text" name="year" /></p>
                  </li>
                </ul>
                <ul class="gender">
                  <li><p>Gender:</p></li>
                  <li>
                    <p><input type="radio" name="gender" value="M" checked="checked" /> Male</p>
                    <p><input type="radio" name="gender" value="F" /> Female</p>
                  </li>
                </ul>
                <ul>
						      <li><p>Address line 1:</p></li>
						      <li><input type="text" name="addressLine1" /></li>
					      </ul>
					      <ul>
						      <li><p>Address line 2:</p></li>
						      <li><input type="text" name="addressLine2" /></li>
					      </ul>
					      <ul>
						      <li><p>City:</p></li>
						      <li><input type="text" name="city" /></li>
					      </ul>
					      <ul>
						      <li><p>Country:</p></li>
						      <li><input type="text" name="country" /></li>
					      </ul>
                <ul>
                  <li><p>Phone number:</p></li>
                  <li><input type="text" name="phone" /></li>
                </ul>
                <ul>
                  <li><p>Email:</p></li>
                  <li><input type="text" name="email" /></li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <h2>Patient information</h2>
              <div class="form-container">
                <ul>
                  <li><p>Healthcare no.:</p></li>
                  <li><input type="text" name="healthcareNumber" /></li>
                </ul>
                <ul>
                  <li><p>Height:</p></li>
                  <li><input type="text" name="height" /></li>
                </ul>
                <ul>
                  <li><p>Weight:</p></li>
                  <li><input type="text" name="weight" /></li>
                </ul>
                <div class="clearfix"></div>
              </div>
             
              
              <?php
                // Emergency contact.
                if (isset($_GET["emergencyContact"]))
                {
                    echo "<h2>Emergency contact information</h2>
                       <div class=\"form-container\">
                        <ul>
                          <li><p>Name:</p></li>
                          <li><input type=\"text\" name=\"emergname\" /></li>
                        </ul>
                        <ul class=\"birthday\">
                          <li><p>Birthday:</p></li>
                          <li>
                            <p>Day:
                              <select name=\"emergbirthday\">
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
                              <input type=\"text\" name=\"emergbirthyear\" />
                            </p>
                          </li> 
                        </ul>
                        
                        <ul class=\"gender\">
                          <li><p>Gender:</p></li>
                          <li>
                            <p><input type=\"radio\" name=\"emerggender\" value=\"M\" checked=\"checked\" /> Male</p>
                            <p><input type=\"radio\" name=\"emerggender\" value=\"F\" /> Female</p>
                          </li>
                        </ul>
					              <ul>
						              <li><p>Address line 1:</p></li>
						              <li><input type=\"text\" name=\"emergaddressLine1\" /></li>
					              </ul>
					              <ul>
						              <li><p>Address line 2:</p></li>
						              <li><input type=\"text\" name=\"emermgaddressLine2\" /></li>
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
                        <input type=\"button\" name=\"cancel\" value=\"Cancel\" onclick=\"window.location ='/patients.php';\" />
                      </div>";
                      }
                      else
                      {
                          echo "<div class=\"form-buttons\">
                                  <input type=\"submit\" name=\"submit\" value=\"Create\" />
                                  <input type=\"button\" name=\"cancel\" value=\"Cancel\" onclick=\"window.location ='/patients.php';\" />
                                  <input type=\"button\" name=\"addEmerg\" value=\"Add emergency contact\" style=\"width: 200px;\" onclick=\"window.location='/patient/add-patient.php?emergencyContact';\" />
                                </div>";
                      }
                    ?>
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
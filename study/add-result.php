<?php
  require_once("../php/user-permissions.php");
  require_once("../php/login-functions.php");
  require_once("../php/view-study-functions.php");
  require_once("../php/index-functions.php");
  require_once("../php/add-results-functions.php");
  verifyLoggedIn();
  addResult();
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Create a Result :: Medical Research Database</title>
    
    <link rel="stylesheet" href="/css/layout.css" />
    <link rel="stylesheet" href="/css/nav.css" />
  </head>
  <body onload="document.getElementById('patient').focus();">
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
          <li id="current"><a href="/">My studies</a></li>
          <li><a href="/patients.php">Patients</a></li>
          <?php printManageUsers(false, false); ?>
          <li><a href="/account.php?userID=<?php echo $_SESSION["userid"]; ?>">My account</a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
    </nav>
    <div id="content-outer">
      <div class="container">
        <div id="content-inner">
          <div class="padding">
            <h1>Create a result</h1>
            <!-- Jamie: This link should go back to the study, so it needs the same url args as this page. -->
            <!--        Replace $whatever-s with actual data. -->
			<?php
				echo "<p><a href=\"/study/view-study.php?studyname=".$_GET['studyname']."\">&lt; ".$_GET['studyname']."</a></p>";
				echo "<form action=\"/study/add-result.php?studyname=".$_GET['studyname']."&numTypes=".$_GET['numTypes']."&addResultAttempt\" method=\"post\">";
			?>
              <div class="form-container">
                <ul>
                  <li><p>Patient name:</p></li>
                  <!-- TODO: should this be a dropdown? -->
                  <li><input type="text" name="patient" id="patient" /></li>
                </ul>
                <ul class="birthday">
                  <li><p>Result date:</p></li>
                  <li>
                    <!-- TODO: If we want to be really fancy later we can set this to the current date. -->
                    <p>Day:
                      <select name="dateDay">
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
                      <select name="dateMonth">
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
                    <p>Year:
                      <input type="text" name="dateYear" />
                    </p>
                  </li> 
                </ul>
                <ul>
                  <li><p>Description:</p></li>
                  <li><input type="text" name="description" /></li>
                </ul>
                <!-- Jamie: This ul block is what you need to duplicate for each type. -->
				<?php
				$numTypes = $_GET['numTypes'];
				if(!$numTypes){
					echo " <ul class=\"result-type\"><li><p>Type:</p></li><li><input type=\"button\" name=\"addType\" style=\"width: 100px; margin-left: 0px;\" value=\"Add\" onclick=\"window.location='/study/add-result.php?numTypes=1&amp;studyname=".$_GET['studyname']."';\" /></li></ul>";
				}
				else{
					if($numTypes == 1){
					echo "<ul class=\"result-type\"><li><p>Type:</p></li><li>
                    <input type=\"text\" name=\"type0\" />
                    <input type=\"button\" name=\"addType\" value=\"Remove\" onclick=\"window.location='/study/add-result.php?numTypes=".($numTypes-1)."&studyname=".$_GET['studyname']."';\" />
					<input type=\"button\" name=\"addType\" value=\"Add\" onclick=\"window.location='/study/add-result.php?&numTypes=".++$numTypes."&studyname=".$_GET['studyname']."';\" />
					</li>
					</ul>";
					}else{
					echo "<ul class=\"result-type\"><li><p>Type:</p></li>
							<li>
							<input type=\"text\" name=\"type0\" />
							<input type=\"button\" name=\"addType\" value=\"Remove\" onclick=\"window.location='/study/add-result.php?numTypes=".($numTypes-1)."&amp;studyname=".$_GET['studyname']."';\" />
							</li>
						</ul>";
					for($count = 2; $count < $numTypes; $count++){
						echo "<ul class=\"result-type\">
								<li><p></p></li>
								<li>
								<input type=\"text\" name=\"type".($count-1)."\" />
								<input type=\"button\" name=\"addType\" value=\"Remove\" onclick=\"window.location='/study/add-result.php?numTypes=".($numTypes-1)."&studyname=".$_GET['studyname']."';\" />
								</li>
							</ul>";
					}
					echo"<ul class=\"result-type\">
					<li><p></p></li>
					<li>
                    <input type=\"text\" name=\"type".($numTypes-1)."\" />
                    <input type=\"button\" name=\"addType\" value=\"Add\" onclick=\"window.location='/study/add-result.php?numTypes=".++$numTypes."&amp;studyname=".$_GET['studyname']."';\" />
					</li>
					</ul>";
				}
				}
				?>
              </div>
              <div class="clearfix"></div>
              <div class="form-buttons">
                <input type="submit" name="submit" value="Create" />
                <!-- Jamie: This javascript needs to be updated properly. -->
                <input type="button" name="cancel" value="Cancel" onclick="window.location='/study/view-study.php?studyname=<?php echo $_GET["studyname"]; ?>';" />
              </div>
            </form>
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

<?php
  require_once("../php/user-permissions.php");
  require_once("../php/login-functions.php");
  require_once("../php/view-study-functions.php");
  require_once("../php/index-functions.php");
  verifyLoggedIn();
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Edit a Result :: Medical Research Database</title>
    
    <link rel="stylesheet" href="/css/layout.css" />
    <link rel="stylesheet" href="/css/nav.css" />
  </head>
  <body onload="document.getElementById('patient').focus();">
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
          <li><a href="/account.php">My account</a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
    </nav>
    <div id="content-outer">
      <div class="container">
        <div id="content-inner">
          <div class="padding">
            <h1>Edit a result</h1>
            <!-- Jamie: This link should go back to the study, so it needs the same url args as this page. -->
            <!--        Replace $whatever-s with actual data. -->
            <p><a href="/study/view-study?studyname=JAMIE_PUT_SOMETHING_HERE">&lt; $studyname</a></p>
            <!-- Jamie: As usual, change the action to fit what you need to do. -->
            <form action="/study/view-study?studyname=blahblahblah" method="post">
              <div class="form-container">
                <ul>
                  <li><p>Patient name:</p></li>
                  <!-- TODO: should this be a dropdown? -->
                  <li><input type="text" name="patient" id="patient" value="$patientname" /></li>
                </ul>
                <ul class="birthday">
                  <li><p>Result date:</p></li>
                  <li>
                    <!-- Jamie: Values can be selected from dropdowns by adding selected="selected" to an option. -->
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
                        <option name="april">April</option>
                        <option name="may">May</option>
                        <option name="june">June</option>
                        <option name="july">July</option>
                        <option name="august">August</option>
                        <option name="september">September</option>
                        <option name="october">October</option>
                        <option name="november">November</option>
                        <option name="december">December</option>
                      </select>
                    </p>
                    <p>Year:
                      <input type="text" name="year" value="$year" />
                    </p>
                  </li> 
                </ul>
                <ul>
                  <li><p>Description:</p></li>
                  <li><input type="text" name="year" value="$description" /></li>
                </ul>
                <ul>
                  <!-- TODO: Not sure how to deal with result types... -->
                  <li><p>Type:</p></li>
                  <li><input type="text" name="type" value="$type" /></li>
                </ul>
              </div>
              <div class="clearfix"></div>
              <div class="form-buttons">
                <input type="submit" name="submit" value="Update" />
                <!-- Jamie: This javascript needs to be updated properly. -->
                <input type="button" name="cancel" value="Cancel" onclick="window.location='/study/view-study.php?studyname=JAMIE_PUT_SOMETHING_HERE';" />
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

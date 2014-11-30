<?php
  require_once("../php/user-permissions.php");
  require_once("../php/login-functions.php");
  require_once("../php/index-functions.php");	
  require_once("../php/add-user-functions.php");
  verifyLoggedIn();
  add_user();
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
            <h1>Edit $user</h1>
            <p><a href="/users.php">&lt; Manage users</a></p>
            <!--
                  Jamie: Change action to the name of the page containing your code.
                  we probably want to redirect to /users.php once the user is added.
            -->
            <form action="add-user.php" method="post">
              <h2>Personal information</h2>
              <div class="form-container">
                <ul>
                  <li><p>Name:</p></li>
                  <li><input type="text" name="name" value="$name" /></li>
                </ul>
                <ul class="birthday">
                  <li><p>Birthday:</p></li>
                  <li>
                    <p>Day:
                      <select>
                        <!-- Jamie: set the selected option by adding selected="selected" to the
                             proper option. -->
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
                      <select>
                        <!-- Jamie: set the selected option by adding selected="selected" to the
                             proper option. -->
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
                <ul class="gender">
                  <li><p>Gender:</p></li>
                  <li>
                    <!-- Jamie: set the selected option by adding checked="checked" to the proper
                         option. -->
                    <p><input type="radio" name="gender" value="male" /> Male</p>
                    <p><input type="radio" name="gender" value="female" /> Female</p>
                  </li>
                </ul>
                <!-- 
                     Jamie: just concatenate all the address stuff.  The separate fields
                     are to make this look more "official."
                -->
                <ul>
                  <li><p>Address line 1:</p></li>
                  <li><input type="text" name="addressLine1" value="$addrpart1" /></li>
                </ul>
                <ul>
                  <li><p>Address line 2:</p></li>
                  <li><input type="text" name="addressLine2" value="$addrpart2" /></li>
                </ul>
                <ul>
                  <li><p>City:</p></li>
                  <li><input type="text" name="city" value="$city" /></li>
                </ul>
                <ul>
                  <li><p>Country:</p></li>
                  <li><input type="text" name="country" value="$country" /></li>
                </ul>
                <ul>
                  <li><p>Postal code:</p></li>
                  <li><input type="text" name="postalCode" value="$postal" /></li>
                </ul>
                <ul>
                  <li><p>Phone number:</p></li>
                  <li><input type="text" name="phone" value="$phone" /></li>
                </ul>
                <ul>
                  <li><p>Email:</p></li>
                  <li><input type="text" name="email" value="$email" /></li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <h2>User information</h2>
              <div class="form-container">
                <ul>
                  <li><p>Username:</p></li>
                  <li><input type="text" name="username" value="should we keep the password boxes?" /></li>
                </ul>
                <ul>
                  <li><p>Password:</p></li>
                  <li><input type="password" name="password" value="" /></li>
                </ul>
                <ul>
                  <li><p>Confirm password</p></li>
                  <li><input type="password" name="confirm" value="" /></li>
                </ul>
                <ul class="type">
                  <li><p>User type:</p></li>
                  <li>
                    <!-- Jamie: set the selected option by adding checked="checked" to the correct option -->
                    <p><input type="radio" name="type" value="ra" /> Research assistant</p>
                    <p><input type="radio" name="type" value="md" /> MD</p>
                    <p><input type="radio" name="type" value="admin" /> Administrator</p>
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

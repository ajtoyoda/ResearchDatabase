<?php
  require_once("php/user-permissions.php");
  require_once("php/login-functions.php");
  require_once("php/edit-user-functions.php");
  require_once("php/success-failure-functions.php");
  require_once("php/gf.php");
  verifyLoggedIn();
  
  // Verify URL arguments.
  if (!isset($_GET["userID"]) || !isset($_SESSION["userid"]))
      header("Location: /");
  
  // Don't let users view other users' information.
  if ($_GET["userID"] != $_SESSION["userid"])
      header("Location: /");
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>My account :: Medical Research Database</title>
    
    <link rel="stylesheet" href="/css/layout.css" />
    <link rel="stylesheet" href="/css/nav.css" />
    <link rel="stylesheet" href="/css/study.css" />
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
          <li id="current"><a href="/account.php">My account</a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
    </nav>
    <div id="content-outer">
      <div class="container">
        <div id="content-inner">
          <div class="padding">
            <div class="clearfix"></div>
            <div class="add-header" id="top">
              <ul>
                <li><h1>My account</h1></li>
                <?php
                  $mysqli = mysqliInit();
                  $emerg = queryAssoc($mysqli, "SELECT p.emergency_id FROM person AS p WHERE p.id = " . $_GET["userID"])["emergency_id"];
                  
                  if ($emerg != Null)
                      echo "<li><input type=\"button\" name=\"edit\" value=\"Edit\" onclick=\"window.location='/account/edit-account.php?userID=" . $_GET["userID"] . "&emergencyContact';\" /></li>";
                  else
                      echo "<li><input type=\"button\" name=\"edit\" value=\"Edit\" onclick=\"window.location='/account/edit-account.php?userID=" . $_GET["userID"] . "';\" /></li>";
                ?>
              </ul>
            </div>
            <div class="clearfix"></div>
            <?php successMessage("Your account was updated successfully.", "success"); ?>
            <h2>Personal information</h2>
            <div class="study-info-wide">
              <ul>
                <li><p>Name:</p></li>
                <li><p><?php echo getPerson($_GET["userID"])["name"]; ?></p></li>
              </ul>
              <ul>
                <li><p>Birthday:</p></li>
                <li><p><?php echo getPerson($_GET["userID"])["birthday"]; ?></p></li>
              </ul>
              <ul>
                <li><p>Gender:</p></li>
                <li><p>
                  <?php
                    $gender = getPerson($_GET["userID"])["gender"]; 

                    if ($gender == 'M' || $gender == 'm')
                        echo "Male";
                    else
                        echo "Female";
                  ?></p></li>
              </ul>
              <?php
                $address = getPerson($_GET["userID"])["address"];
                $current = strtok($address, "|");
                $count   = 1;
                
                while ($current != false)
                {
                    echo "<ul>\n";
                    echo "  <li><p>";
                    
                    if ($count == 1)
                        echo "Address line 1:";
                    else if ($count == 2)
                        echo "Address line 2:";
                    else if ($count == 3)
                        echo "City:";
                    else
                        echo "Country:";
                        
                    echo "</p></li>\n";
                    echo "  <li><p>" . $current . "</p></li>\n";
                    echo "</ul>\n";
                    
                    ++$count;
                    $current = strtok("|");
                }
              ?>
              <ul>
                <li><p>Phone number:</p></li>
                <li><p><?php echo getPerson($_GET["userID"])["phone"]; ?></p></li>
              </ul>
              <ul>
                <li><p>Email:</p></li>
                <li><p><?php echo getPerson($_GET["userID"])["email"]; ?></p></li>
              </ul>
            </div>
            <div class="clearfix"></div>
            <h2>User information</h2>
            <div class="study-info-wide">
              <ul>
                <li><p>Username:</p></li>
                <li>
                  <p>
                    <?php
                      $mysqli = mysqliInit();
                      echo queryAssoc($mysqli, "SELECT u.username FROM user AS u WHERE u.id = '" . $_GET["userID"] . "'")["username"];
                    ?>
                  </p>
                </li>
              </ul>
              <ul>
                <li><p>Type:</p></li>
                <li>
                  <p>
                    <?php
                      $mysqli = mysqliInit();
                      $type   = queryAssoc($mysqli, "SELECT u.type_flag FROM user AS u WHERE u.id = '" . $_GET["userID"] . "'")["type_flag"];
                      
                      if ($type == 'A' || $type == 'a')
                          echo "Administrator";
                      else if ($type == 'M' || $type == 'm')
                          echo "MD";
                      else
                          echo "Research assistant";
                    ?>
                  </p>
                </li>
              </ul>
            </div>
            <div class="clearfix"></div>
            <h2>Emergency contact</h2>
            <?php
              // Emergency contacts - making life more complicated than it needs to be.
              $mysqli = mysqliInit();
              $emergencyID = queryAssoc($mysqli, "SELECT p.emergency_id FROM person AS p WHERE p.id = '" . $_GET["userID"] . "'")["emergency_id"];
              
              if ($emergencyID != Null)
              {
                  // Such fun!
                  $emerg = getPerson($emergencyID);
                  echo "<div class=\"study-info-wide\">\n";
                  
                  // Name.
                  echo "  <ul>\n";
                  echo "    <li><p>Name:</p></li>\n";
                  echo "    <li><p>" . $emerg["name"] . "</p></li>\n";
                  echo "  </ul>\n";
                  
                  // Birthday.
                  echo "  <ul>\n";
                  echo "    <li><p>Birthday:</p></li>\n";
                  echo "    <li><p>" . $emerg["birthday"] . "</p></li>\n";
                  echo "  </ul>\n";
                  
                  // Gender.
                  echo "  <ul>\n";
                  echo "    <li><p>Gender:</p></li>\n";
                  echo "    <li><p>";
                  
                  if ($emerg["gender"] == 'M' || $emerg["gender"] == 'm')
                      echo "Male";
                  else
                      echo "Female";
                  
                  echo "</p></li>\n";
                  echo "  </ul>\n";
                  
                  // Address.
                  $current = strtok($emerg["address"], "|");
                  $count   = 1;
                
                  while ($current != false)
                  {
                      echo "  <ul>\n";
                      echo "    <li><p>";
                    
                      if ($count == 1)
                          echo "Address line 1:";
                      else if ($count == 2)
                          echo "Address line 2:";
                      else if ($count == 3)
                          echo "City:";
                      else
                          echo "Country:";
                        
                      echo "</p></li>\n";
                      echo "    <li><p>" . $current . "</p></li>\n";
                      echo "  </ul>\n";
                    
                      ++$count;
                      $current = strtok("|");
                  }
                  
                  // Phone number.
                  echo "  <ul>\n";
                  echo "    <li><p>Phone number:</p></li>\n";
                  echo "    <li><p>" . $emerg["phone"] . "</p></li>\n";
                  echo "  </ul>\n";
                  
                  // Email.
                  echo "  <ul>\n";
                  echo "    <li><p>Email:</p></li>\n";
                  echo "    <li><p>" . $emerg["email"] . "</p></li>\n";
                  echo "  </ul>\n";
              }
              else
              {
                  echo "<p>You do not have an emergency contact.</p>\n";
              }
            ?>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <footer>
      <div class="container">
        <div class="padding">
          <p><a href="/">My studies</a> | <a href="/patients.php">Patients</a> | <?php printManageUsers(true, false); ?> <a href="/account.php?userID=<?php echo $_SESSION["userid"]; ?>">My account</a></p>
          <p>Copyright &copy; 2014. Use of this website is permitted for authorized personnel only.</p>
        </div>
      </div>
    </footer>
  </body>
</html>

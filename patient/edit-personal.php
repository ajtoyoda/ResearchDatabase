<?php
  require_once("../php/user-permissions.php");
  require_once("../php/login-functions.php");
  require_once("../php/edit-user-functions.php");
  require_once("../php/gf.php");

  // Check URL arguments.
  if (!isset($_GET["ID"]))
      header("Location: /patients.php");

  verifyLoggedIn();
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Edit <?php echo getPerson($_GET["ID"])["name"]; ?> :: Medical Research Database</title>
    
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
            <div class="add-header" id="top">
              <ul>
                <li style="width: 440px;"><h1>Edit <?php echo getPerson($_GET["ID"])["name"]; ?></h1></li>
                <li style="text-align: right;"><h2 style="width: 320px;">Personal Information</h2></li>
				      </ul>
            </div>
            <div class="clearfix"></div>
			      <a href="/patient/view-personal.php?ID=<?php echo $_GET["ID"]; ?>">&lt; Personal information</a>
            <form action="/patient/edit-personal.php?ID=<?php echo $_GET["ID"]; ?>&amp;editAttempt" method="post">
              <div class="form-container">
                <ul>
                  <li><p>Name:</p></li>
                  <li><input type="text" name="name" value="<?php echo getPerson($_GET["ID"])["name"]; ?>" /></li>
                </ul>
                <ul class="gender">
                  <li><p>Gender:</p></li>
                  <li>
                    <?php
                      $gender = getPerson($_GET["ID"])["gender"];
                      
                      if ($gender == 'M' || $gender == 'm')
                      {
                          echo "<p><input type=\"radio\" name=\"gender\" value=\"M\" checked=\"checked\" /> Male</p>\n";
                          echo "<p><input type=\"radio\" name=\"gender\" value=\"F\" /> Female</p>\n";
                      }
                      else
                      {
                          echo "<p><input type=\"radio\" name=\"gender\" value=\"M\" /> Male</p>\n";
                          echo "<p><input type=\"radio\" name=\"gender\" value=\"F\" checked=\"checked\" /> Female</p>\n";
                      }
                    ?>
                  </li>
                </ul>
                <ul class="birthday">
                  <li><p>Birthday:</p></li>
                  <li>
                    <p>Day: 
                      <select name="birthday">
                        <?php
							            $birthday = (int)substr(getPerson($_GET["ID"])['birthday'], 8,2);
							            outputOptionNumbers(1, $birthday-1);
							            echo "<option value=\"".$birthday."\" selected =\"selected\">".$birthday."</option>";
							            outputOptionNumbers($birthday+1, 31);
						            ?>
                      </select>
                    </p>
                    <p>Month:
                      <select name="birthmonth">
                        <?php
							            $birthmonth = (int)substr(getPerson($_GET["ID"])['birthday'], 5,2);
							            outputOptionMonths($birthmonth);
						            ?>
                      </select>
                    </p>
                    <p>Year: <input type="text" name="year" value="<?php echo substr(getPerson($_GET["ID"])["birthday"], 0, 4); ?>" /></p>
                  </li>
                </ul>
                <ul>
                  <li><p>Phone number:</p></li>
                  <li><input type="text" name="phone" value="<?php echo getPerson($_GET["ID"])["phone"]; ?>" /></li>
                </ul>
                <ul>
                  <li><p>Email:</p></li>
                  <li><input type="text" name="email" value="<?php echo getPerson($_GET["ID"])["email"]; ?>" /></li>
                </ul>
                <?php
                  // Address.
                  $userID = $_GET['ID'];
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
                <div class="clearfix"></div>
              </div>
              <?php
                // Emergency contact.
                $mysqli  = mysqliInit();
                $emergID = queryAssoc($mysqli, "SELECT p.emergency_id FROM person AS p WHERE p.ID = " . $_GET["ID"])["emergency_id"];
                
                if ($emergID != Null)
                {
                    $emerg = getPerson($emergID);
                    echo "<h2>Emergency contact information</h2>
                       <div class=\"form-container\">
                        <ul>
                          <li><p>Name:</p></li>
                          <li><input type=\"text\" name=\"emergname\" id=\"name\" value=\"" . $emerg["name"] . "\" /></li>
                        </ul>
                        <ul class=\"birthday\">
                          <li><p>Birthday:</p></li>
                          <li>
                            <p>Day:
                              <select name=\"emergbirthday\">";
                                $birthday = (int)substr($emerg['birthday'], 8,2);
							                  outputOptionNumbers(1, $birthday-1);
							                  echo "<option value=\"".$birthday."\" selected =\"selected\">".$birthday."</option>";
							                  outputOptionNumbers($birthday+1, 31);
                              echo "</select>
                            </p>
                            <p>Month:
                              <select name=\"emergbirthmonth\">";
                                $birthmonth = (int)substr($emerg['birthday'], 5,2);
							                  outputOptionMonths($birthmonth);
                              echo "</select>
                            </p>
                            <p>Year:
                              <input type=\"text\" name=\"emergbirthyear\" value=\"" . substr($emerg["birthday"], 0, 4) . "\" />
                            </p>
                          </li> 
                        </ul>
                        
                        <ul class=\"gender\">
                          <li><p>Gender:</p></li>
                          <li>";
                          
                          if ($emerg["gender"] == 'M' || $emerg["gender"] == 'm')
                          {
                              echo "<p><input type=\"radio\" name=\"emerggender\" value=\"M\" checked=\"checked\" /> Male</p>
                                    <p><input type=\"radio\" name=\"emerggender\" value=\"F\" /> Female</p>";
                          }
                          else
                          {
                              echo "<p><input type=\"radio\" name=\"emerggender\" value=\"M\" /> Male</p>
                                    <p><input type=\"radio\" name=\"emerggender\" value=\"F\" checked=\"checked\" /> Female</p>";
                          }
                          
                          echo "</li>
                        </ul>";
                        
                        // Address
					        $substrings = explode('|', $emerg['address'], 4);
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
                        
                        echo "<ul>
                          <li><p>Phone number:</p></li>
                          <li><input type=\"text\" name=\"emergphone\" value=\"" . $emerg["phone"] . "\" /></li>
                        </ul>
                        <ul>
                          <li><p>Email:</p></li>
                          <li><input type=\"text\" name=\"emergemail\" value=\"" . $emerg["email"] . "\" /></li>
                        </ul>
                        <div class=\"clearfix\"></div>
                      </div>";
                      }
                    ?>
              <div class="form-buttons">
                <input type="submit" name="submit" value="Update" />
                <input type="button" name="cancel" value="Cancel" onclick="window.location ='/patient/view-personal.php?ID=<?php echo $_GET["ID"]; ?>'" />
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
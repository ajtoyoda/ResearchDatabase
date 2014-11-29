<?php

// Displays an incorrect password message if the URL bar
// contains bad-password.
//
function ShowPasswordMessage()
{
    if (isset($_GET["bad-password"]))
    {
        echo "<div id=\"bad-password\">\n";
        echo "  <div class=\"padding\">\n";
        echo "    <p>Incorrect user name or password. Please try again.</p>\n";
        echo "  </div>\n";
        echo "</div>\n";
    }
}

// Prints the username specified in the address bar, if one is present.
//
function printUserName()
{
    if (isset($_GET["username"]))
        echo $_GET["username"];
}

//This function takes username and password which have been posted and validates them
function logIn()
{
  // Redirect to index if already logged in.
  if (isLoggedOn())
      header("Location: /");
      
  $mysqli= new mysqli("localhost", "root", "", "researchdatabase");
  if(!(isset($_POST['username'])&&isset($_POST['password'])))
  {
    return;
  }
  $username = $_POST['username'];
  $password = $_POST['password'];
  if(!$mysqli->query("USE researchdatabase")){
    die("failed to use database");
  }
  echo $password;
  $username = $mysqli->real_escape_string($username);
  $query = "SELECT username, password, id, type_flag
            FROM user
            WHERE username = '$username'";
  echo $query;
  $result = $mysqli->query($query);
  if(!$result){
    die('Query failed');
  }
  echo $result->num_rows;
  if($result->num_rows <1){
    header('Location: /login.php?bad-password&username=' . $username);
  }
  $userdata = $result->fetch_assoc();
  if(!password_verify($password, $userdata['password'])){
    header('Location: /login.php?bad-password&username=' . $username);
  }
  else{
    validateUser($userdata['id'], $userdata['type_flag']);
    echo "successful login";
    header('Location: /');
    exit;
  }  
}

// Redirects the user to the login page if they are not currently logged
// into the website.  This function should be called on every page, before
// any other content is loaded.
function verifyLoggedIn()
{
    if (!isLoggedOn())
        header("Location: /login.php");
}

//This function should be called once a user has successfully logged on
function validateUser($userid, $type)
{
  session_regenerate_id();
  $_SESSION['valid'] = 1;
  $_SESSION['userid'] = $userid;
  $_SESSION['type'] = $type;
  echo 'Validated';
}
//This function returns whether a user is currently logged on
function isLoggedOn()
{
  session_start();
  if(isset($_SESSION['valid']) && $_SESSION['valid'])
    return true;
  return false;
}
//This function logs a user out
function logout()
{
  $_SESSION = array();
  session_destroy();
}

?>

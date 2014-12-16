<?php
  require_once("/php/login-functions.php");
  require_once("/php/success-failure-functions.php");
  logIn();
  $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
  if(!(stripos($ua,'android') !== false)) { // && stripos($ua,'mobile') !== false) {
		header('Location:/login.php');
  }
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />

    <title>Log in</title>

    <link rel="stylesheet" href="/m/css/layout.css" />
    <link rel="stylesheet" href="/m/css/login.css" />
    <script src="/js/login.js" type="text/javascript"></script>
  </head>
  <body onLoad="FocusUserName();">
    <div id="container">
      <header>
        <div class="padding">
          <h1>Log in</h1>
        </div>
      </header>
      <?php errorMessage("Incorrect username or password. Please try again.", "bad-password"); ?>
      <form action="login.php" method="post">
        <ul>
          <li>
            <div class="padding">
              <div class="input-field-container">
                <div class="input-field"><p>Username:</p></div>
                <div class="input-field"><input type="text" name="username" id="txtUser" value="<?php printUserName(); ?>" /></div>
              </div>
            <div class="clearfix"></div>
            </div>
          </li>
          <li>
            <div class="padding">
              <div class="input-field-container">
                <div class="input-field"><p>Password:</p></div>
                <div class="input-field"><input type="password" name="password" /></div>
              </div>
            <div class="clearfix"></div>
            </div>
          </li>
        </ul>
        <div id="submit-button">
          <input type="submit" name="btnSubmit" value="Log in" />
        </div>
      </form>
    </div>
  </body>
</html>

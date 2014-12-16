<?php
  require_once("/php/login-functions.php");
  logIn();
  $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
  if(!(stripos($ua,'android') !== false)) { // && stripos($ua,'mobile') !== false) {
		header('Location:/login.php');
  }
  echo "Mobile";
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />

    <title>Log in :: Medical Research Database</title>

    <link rel="stylesheet" href="/m/css/layout.css" />
    <link rel="stylesheet" href="/m/css/login.css" />
    <script src="/js/login.js" type="text/javascript"></script>
  </head>
  <body onLoad="FocusUserName();">
    <noscript>
      <div id="js-banner">
        <div class="container">
          <div class="padding">
            <p>This website works best with JavaScript enabled.</p>
          </div>
        </div>
      </div>
    </noscript>
    <div class="container">
      <div id="login-container-outer">
        <div id="login-container-inner">
          <header>
            <div class="padding">
              <h1>Log in</h1>
            </div>
          </header>
          <div class="padding">
            <?php ShowPasswordMessage(); ?>
            <form action="login.php" method="post">
              <ul>
                <li><p>Username:</p></li>
                <li><input type="text" name="username" id="txtUser" value="<?php printUserName(); ?>" /></li>
              </ul>
              <ul>
                <li><p>Password:</p></li>
                <li><input type="password" name="password" /></li>
              </ul>
              <div class="clearfix"></div>
              <div id="submit-button">
                <input type="submit" name="btnSubmit" value="Log in" />
              </div>
            </form>
          </div>
        </div>
        <footer>
          <p>Copyright &copy; 2014. Access to this website is provided to authorized users only. To request access, contact your hospital's IT deparment.</p>
        </footer>
      </div>
    </div>
  </body>
</html>

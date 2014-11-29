<?php
	require_once("php/add-userfunctions.php");
	add_user();
?>
<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Home :: Medical Research Database</title>
    
    <link rel="stylesheet" href="/css/layout.css" />
    <link rel="stylesheet" href="/css/nav.css" />
    <link rel="stylesheet" href="/css/info-box.css" />
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
          <li id="current"><a href="/">Home</a></li>
          <li><a href="/patient.php">Patients</a></li>
          <li><a href="/user.php">My account</a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
    </nav>
    <div id="content-outer">
      <div class="container">
        <div id="content-inner">
          <div class="padding">
            <form action="add-user.php" method="post">
              User name: <input type="text" name="username" /><br />
              Password: <input type="password" name="password" /><br />
              Confirm password: <input type="password" name="confirm" /><br />
			  Admin: <input type="radio" name="type" value="A"/>
			  Research Assistant: <input type="radio" name="type" value="R"/>
			  MD: <input type="radio" name="type" value="M"/><br />
              <input type="submit" name="btnSubmit" />
            </form>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div class="container">
        <div class="padding">
          <p>Copyright &copy; 2014. Use of this website is permitted for authorized personnel only.</p>
        </div>
      </div>
    </footer>
  </body>
</html>

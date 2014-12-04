<?php
  require_once("../php/user-permissions.php");
  require_once("../php/login-functions.php");

  verifyLoggedIn();
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Patients :: Medical Research Database</title>
    
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
          <li><a href="/account.php">My account</a></li>
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
                <li style="width: 440px;"><h1>Patient Name</h1></li>
				<li><h2 style="padding-right: 10px;">Medical Information</h2></li>
                <li><input type="button" name="editPersonal" value="Edit" onclick="window.location = '/patient/edit-personal.php';" /></li>
				<!-- How do I make this justify left? And how do i put a < infront of it without it being a tag-->
				<!--<li><a href="/patients.php">&lt; Patients</a></li>-->
              </ul>
            </div>
            <div class="clearfix"></div>
			<a href="/patients.php">&lt; Patients</a>
            <h2>Pre-existing Medical Conditions and Notes</h2>
			 <ul style="padding:15px;">
			   <li><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut iaculis hendrerit mauris. 
			   Sed gravida imperdiet mauris, in hendrerit odio suscipit vel. Quisque tincidunt, metus nec tempus facilisis, 
			   ante purus fermentum risus, quis faucibus tellus dui eu mauris. Mauris posuere purus eget metus convallis fermentum. 
			   </p></li>
			   <li><p>Praesent rhoncus gravida elit at venenatis. Vestibulum consequat iaculis purus ut posuere. Vivamus ac nulla porta, 
			   pharetra quam malesuada, feugiat magna. Duis dignissim id nisl gravida tempor. Pellentesque nec eros justo. 
			   Morbi et arcu a eros dapibus vestibulum. Pellentesque congue sapien quis lacinia tempor.
			   </p></li>
			 </ul>
			<h2>Medications</h2>
			  <ul style="padding:15px;">
			    <li>Medication A</li>  
			    <li>Medication B</li>  
			    <li>Medication C</li>  
			    <li>Medication D</li>  
			    <li>Medication E</li>  
			    <li>Medication F</li>  
			  </ul>
			  
			  
            
           
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div class="container">
        <div class="padding">
          <p><a href="/">My studies</a> | <a href="/patients.php">Patients</a> | <?php printManageUsers(true,true); ?> <a href="/account.php">My account</a></p>
          <p>Copyright &copy; 2014. Use of this website is permitted for authorized personnel only.</p>
        </div>
      </div>
    </footer>
  </body>
</html>
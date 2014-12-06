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
                <li style="width: 455px;"><h1>Patient Name</h1></li>
				<li><h2 style="padding-right: 10px;">Patient Information</h2></li>
                <li><input type="button" name="editPatient" value="Edit" onclick="window.location = '/patient/edit-patient.php';" /></li>
              </ul>
            </div>
            <div class="clearfix"></div>
			<a href="/patients.php">&lt; Patients</a>
             <table class = "std">
              <tr id="header">
				<th></th>
				<th></th>
              </tr>
			  <tr>
			    <td><p>Name</p></td>
			    <?php
					$mysqli = mysqliInit();
					
					$query = "SELECT * FROM patient INNER JOIN person ON patient.id = person.id WHERE patient.id = \"".$_GET['ID']."\"";
					$dataArray = queryAssoc($mysqli, $query);
					
					echo "<td><p>".$dataArray['Name']."</p></td>
					</tr>
					<tr>
					  <td><p>Health Care Number</p></td>
					  <td><p>".$dataArray['Healthcare_No']."</p></td>
					</tr>
					<tr>
					  <td><p>Height</p></td>
					  <td><p>".$dataArray['Height']."</p></td>
					</tr>
					<tr>
					  <td><p>Weight</p></td>			  
					  <td><p>".$dataArray['Weight']."<p></td>
					</tr>";
			  ?>
            </table>
			
			  
			  
			  
            
           
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
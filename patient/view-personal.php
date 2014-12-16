<?php
  require_once("../php/user-permissions.php");
  require_once("../php/login-functions.php");
  require_once("../php/success-failure-functions.php");

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
				<?php
				$mysqli = mysqliInit();
				$query = "SELECT name FROM person WHERE id = ".$_GET['ID'];
				$data = queryAssoc($mysqli, $query);
				$name = $data['name'];
                echo "<li style=\"width: 440px;\"><h1>$name</h1></li>";
				?>
				        <li><h2 style="padding-right: 10px;">Personal Information</h2></li>
                <li><input type="button" name="editPersonal" value="Edit" onclick="window.location = '/patient/edit-personal.php?ID=<?php echo $_GET["ID"]; ?>';" /></li>
				      </ul>
            </div>
            <div class="clearfix"></div>
			<a href="/patients.php">&lt; Patients</a>
             <?php successMessage("The patient's personal information was successfully updated.", "successfulEditPersonal"); ?>
             <table class = "std">
              <tr id="header">
				<th></th>
				<th></th>
              </tr>
			  
			  <?php
				$ID = $_GET['ID'];
				$mysqli = mysqliInit();
				$query = "Select * FROM patient INNER JOIN person ON patient.id = person.id WHERE person.id = \"".$ID."\"";
				$dataArray = queryAssoc($mysqli, $query);
					echo
					  "<tr>
						<td><p>Name</p></td>
						<td><p>".$dataArray['Name']."</p></td>
					  </tr>
					  <tr>
						<td><p>Gender</p></td>
						<td><p>".$dataArray['Gender']."</p></td>
					  </tr>
					  <tr>
						<td><p>Birthday</p></td>
						<td><p>".$dataArray['Birthday']."</p></td>
					  </tr>
					  <tr>
						<td><p>Phone</p></td>
						<td><p>".$dataArray['Phone']."</p></td>
					  </tr>
					  <tr>
						<td><p>Email</p></td>
						<td><p>".$dataArray['Email']."</p></td>
					  </tr>
					  <tr>
						<td><p>Address</p></td>			  
						<td><p>".str_replace('|', ' ', $dataArray['Address'])."</p></td>
					  </tr>
					  </table>";
			//EMERGENCY CONTACT
				if(!empty($dataArray['Emergency_ID'])){
					$query = "Select * FROM person WHERE id = \"".$dataArray['Emergency_ID']."\"";
					$dataArray = queryAssoc($mysqli, $query);
					echo
						"<h2><p>Emergency Contact</p></h2>
						<table class = \"std\">
						  <tr id=\"header\">
							<th></th>
							<th></th>
						  </tr>
						  <tr>
							<td><p>Name</p></td>
							<td><p>".$dataArray['Name']."</p></td>
						  </tr>
						  <tr>
							<td><p>Gender</p></td>
							<td><p>".$dataArray['Gender']."</p></td>
						  </tr>
						  <tr>
							<td><p>Birthday</p></td>
							<td><p>".$dataArray['Birthday']."</p></td>
						  </tr>
						  <tr>
							<td><p>Phone</p></td>
							<td><p>".$dataArray['Phone']."</p></td>
						  </tr>
						  <tr>
							<td><p>Email</p></td>
							<td><p>".$dataArray['Email']."</p></td>
						  </tr>
						  <tr>
							<td><p>Address</p></td>			  
							<td><p>".str_replace('|', ' ', $dataArray['Address'])."</p></td>
						  </tr>
						  </table>";
				}
			  ?>
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
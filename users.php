<?php
  require_once("php/user-permissions.php");
  require_once("php/login-functions.php");
  require_once("php/view-study.php");
  verifyLoggedIn();
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Manage Users :: Medical Research Database</title>
    
    <link rel="stylesheet" href="/css/layout.css" />
    <link rel="stylesheet" href="/css/nav.css" />
    <link rel="stylesheet" href="/css/table.css" />
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
          <?php printManageUsers(false, true);?>
          <li><a href="/account.php">My account</a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
    </nav>
    <div id="content-outer">
      <div class="container">
        <div id="content-inner">
          <div class="padding">
            
            
           
            <div class="add-header">
              <ul>
                <li><h1>Manage Users</h1></li>
                <li><input type="button" name="addUser" value="New" onclick="window.location = '/user/add-user.php';" /></li>
              </ul>
            </div>
            <div class="clearfix"></div>
            <table>
              <tr id="header">
                <th><p>User</p></th>
                <th><p>ID</p></th>
                <th><p>Type</p></th>
                <th></th>
              </tr>
              <tr>
                <td><p>John Doe</p></td>
                <td><p>1</p></td>
                <td><p>Research Assistant</p></td>
                <td><a href="/user/edit-user.php">Edit</a><a href="/user/delete-user.php">Delete</a></p></td>
              </tr>
            </table>
			<!-- ============================== Table 2 =================================================== -->
			<div class="add-header">
              <ul>
                <li><h1>User permissions</h1></li>
                <li><input type="button" name="addPermission" value="New" onclick="window.location = '/user/add-user-permission.php';" /></li>
              </ul>
            </div>
            <div class="clearfix"></div>
            <table class="edit-only">
              <tr id="header">
                <th><p>Study</p></th>
                <th><p>Can Read</p></th>
                <th><p>Can Write</p></th>
                <th></th>
              </tr>
              <tr>
                <td><p>Cardio Img</p></td>
                <td><p></p>1<p>2</p></td>
                <td><p>2</p></td>
                <td><a href="/user/edit-user-permission.php">Edit</a></p></td>
              </tr>
            </table>
		
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
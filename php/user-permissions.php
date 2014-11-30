<?php

// Determines whether the current user is an administrator.
//
// Returns: True if the current user is an administrator or false
//          otherwise.
//
function isAdministrator()
{
    if (isset($_SESSION["type"]) &&
        ($_SESSION["type"] == "a" || $_SESSION["type"] == "A"))
        return true;
    
    return false;
}

// Prints the manage users navigation link if the current user is
// an administrator.
//   footer: True if the link should be printed as a footer link or
//           false if the link should be printed as a main navigation
//           link.
//
function printManageUsers($footer, $isSelected)
{
    if (!isAdministrator())
        return;
	if($isSelected){
		if (!$footer)
			echo "<li id=\"current\"><a href=\"/users.php\">Manage users</a></li>\n";
		else
			echo "<a href=\"/users.php\">Manage users</a> |\n";
		
	}	
	else{
		if (!$footer)
			echo "<li><a href=\"/users.php\">Manage users</a></li>\n";
		else
			echo "<a href=\"/users.php\">Manage users</a> |\n";
			
		}
}

?>

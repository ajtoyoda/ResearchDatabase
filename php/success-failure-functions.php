<?php

// Displays a green box that includes the text specified if the
// url of the webpage contains the specified data.
//   message: The text to display in the green box.
//   url:     The data to look for in the URL.
//
function successMessage($message, $url){
    if (isset($_GET[$url])){
        echo "<div class=\"green-box\">\n";
        echo "  <div class=\"padding\">\n";
        echo "    <p>" . $message . "</p>\n";
        echo "  </div>\n";
        echo "</div>\n";
    }
}

// Displays a red box that includes the text specified if the url
// of the webpage contains the specified data.
//   message: The text to display in the red box.
//   url:     The data to look for in the URL.
//
function errorMessage($message, $url){
	if (isset($_GET[$url])){
        echo "<div class=\"red-box\">\n";
        echo "  <div class=\"padding\">\n";
        echo "    <p>" . $message . "</p>\n";
        echo "  </div>\n";
        echo "</div>\n";
    }
}

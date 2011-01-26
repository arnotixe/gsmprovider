<?php

// Site info
$sitename = "GSM Providers checker";
$host = "arno.homelinux.org";
$dirdir = "gsmprovider";
$countrydata = "Ecuador";
$timezone = "+1:00"; // used in logging. Deviance from UTC.
// to find out, run
// TZ="UTC-1" date

// Database connection settings
require "dbconnectivity.php";

function connect_db() 
{
	global $dbhost;
	global $dbuser;
	global $dbpass;
	global $dbname;

   $errorreport = error_reporting(); 
//   error_reporting(0); 
	$dbres = mysql_connect($dbhost, $dbuser, $dbpass);

   if (!$dbres) {
      die('<b>OOPS!</b> Could not connect to database. Did you <a href="install.php">setup</a> yet? : ' . mysql_error());
   }

	$db_selected = mysql_select_db("$dbname", $dbres);

   if (!$db_selected) {
      die ("<b>OOPS!</b> Could not select database $dbname.  Did you <a href=\"install.php\">setup</a> yet? : " . mysql_error());
   }
   // turn error reporting back on
//   error_reporting($errorreport); 
}




function loggedin(){
//inherit values
global $scodireditpassword;
global $sdlogincookie;

	$loginok=false;
	// could have logged in with cookie
	if ($_COOKIE[$sdlogincookie]==$scodireditpassword) {
		$loginok=true;
	}

	// could have logged in GET, or logged out.
	if ($_GET["scodireditpwd"] == $scodireditpassword) { 
		$loginok=true;
	}

	//could have logged out
	if ($_GET["scodireditpwd"] == "logout") { // check for logout
		setcookie("scodirlogin", "", time()+60*60*8 ,"/", "$host");//expire in 8hrs
		$loginok=false;
	}

	return $loginok;
}


?>

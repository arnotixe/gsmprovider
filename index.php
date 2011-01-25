<?php

   require_once "defs.php";

   // Get data
   connect_db(); // or die, show error message with link to install.php
   $mode = $_GET["m"]; // mode string   (raw,)
   $src  = $_GET["s"]; // search string (phone number)

   $res = mysql_fetch_array(mysql_query("select * from numbers where ix=$src"); //should return only one line

   // Show page


?>

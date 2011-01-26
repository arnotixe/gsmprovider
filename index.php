<?php
   require "defs.php";

   $mode = $_GET["m"]; // mode string   (raw,)
   $src  = $_GET["s"]; // search string (phone number)
   $i18n = $_GET["c"]; // country number (ignored for now)

   // Get data
   connect_db(); // or die, show error message with link to install.php

   $qs = sprintf("select * from numbers,provider where (numbers.provider=provider.ix and numbers.ix=%s)", mysql_real_escape_string($src));
   $qry = mysql_query($qs);
   // could add country clause to the query here

   if ($qry) {
      $res = mysql_fetch_array($qry); // this should not fail if the database exists.

      if (!$res) { // query went bad, empty or something
         $res[1] = -1; // set Provider field to -1, unknown
      } 
   } else {
      $res[1] = -1; // set Provider field to -1, unknown
   }


   // check if provider is unknown (-1); should try to find out here it if possible
   // figure_out_what_provider_is_this_number();

   // If it's been "a long time" since the entry was added to the database, try to refresh the data.
   // if (date > 1 year) {
   //    figure_out_what_provider_is_this_number();
   // }

   // Show page
   switch ( $mode ) {
      case "r":  // raw mode
         print "$res[1]"; // output result in RAW mode: just the provider index
         break;
      default:
         print "<html>
<head>
<title>gsmprovider</title>
<script>
 <!--
  function setFocus() {
   sf.s.focus();
   sf.s.select();
  }
 // -->
</script>
</head>
<body onload=\"setFocus()\">
<h1>gsmprovider</h1>
This page shows you who's providing a specific phone number. 
This server is containing numbers from <b>$countrydata</b><br>
<p>
You asked about the number <b>$src</b>.<br>";
         if ( $res[1] == -1 ) {
            print "Unfortunately it isn't in the database yet. We should have some function to add it...";
         } else {
            print "The provider is: $res[1] (<b>$res[5]</b>)<br>
The entry was last changed: $res[2]";
         }
      print "<form name=\"sf\" action=\"index.php\"
<input name=\"s\">
<input type=\"submit\" value=\"Check\">
</form>
</body>
</html>";
// debugging ;)
//      foreach ($res as $k => $v) { print "$k:$v<br>";}
         
   }
?>

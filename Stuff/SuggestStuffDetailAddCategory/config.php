<?php
$host    = "localhost"; // Host name
$db_name = "testing";		// Database name
$db_user = "root";		// Database user name
$db_pass = "";			// Database Password
$db_table= "tblcountry";		// Table name
$db_column = "name";	// Table column from which suggestions will get shown

 $conn = mysql_connect($host,$db_user,$db_pass)or die(mysql_error());
         mysql_select_db($db_name,$conn)or die(mysql_error());

?>
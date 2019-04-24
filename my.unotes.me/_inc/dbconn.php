<?php
$serverName="localhost";
$dbusername="UNotes";
$dbpassword="UNotes";
mysql_connect($serverName,$dbusername,$dbpassword)/* or die('the website is down for maintainance')*/;
// mysql_select_db($dbname) or die(mysql_error()); not needed since database splitup (UNotesDAT & UNotesMAIN)
?>
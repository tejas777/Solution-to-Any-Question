<?php
	error_reporting(E_ALL ^ E_DEPRECATED);
	$conn = mysql_connect("localhost","root","");
  	$db = "thesolution";
  	mysql_select_db($db);
?>

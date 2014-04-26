<?php
$room=$_POST["room"];
$pwd=$_POST["password"];
$usr=$_POST["user"];

include_once("mysql.php");
include("ping.php");

$result = mysql_query("SELECT * FROM `sessions` WHERE `room` = '$room'");
while($row = mysql_fetch_array($result)){
	die("room;Room already exists.");
}

mysql_query("INSERT INTO `sessions` (`room`,`pwd`,`creator`,`locked`) VALUES ('$room','$pwd','$usr','n')");

iquiz_ping($room,$pwd,$usr,true);
?>

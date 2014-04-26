<?php
$room=$_POST["room"];
$pwd=$_POST["password"];
$usr=$_POST["user"];

include_once("mysql.php");

mysql_query("UPDATE `sessions` SET `locked` = 'y' WHERE `room`='$room' AND `pwd` = '$pwd' AND `creator` = '$usr'");
?>

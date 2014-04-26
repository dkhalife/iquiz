<?php
$room=$_POST["room"];
$pwd=$_POST["password"];
$usr=$_POST["user"];

include_once("mysql.php");
include("ping.php");

$test=false;
$result = mysql_query("SELECT * FROM `sessions` WHERE `room` = '$room'");

while($row = mysql_fetch_array($result)){
	$test=true;
	break;
}

if(!$test){
	die("room;Room does not exist.");
}

if($row["locked"]=="y"){
	die("room;This room is now locked.");
}

if($pwd!=$row["pwd"]){
	die("password;Incorrect password.");
}

$users=$row["guests"];
if($usr==$row["creator"] || preg_match("/".$usr."/",$users)){
	die("user;Please pick a different username.");
}

if($users!=""){
	$users.=";";
}
$users.=$usr;

mysql_query("UPDATE `sessions` SET `guests` = '$users' WHERE `id` = '{$row["id"]}'");

iquiz_ping($room,$pwd,$usr);
?>
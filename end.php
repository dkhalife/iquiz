<?php
$room=$_POST["room"];
$pwd=$_POST["password"];
$usr=$_POST["user"];

include_once("mysql.php");

if(!isset($_GET["mode"])){
	mysql_query("UPDATE `sessions` SET `locked` = 'o' WHERE `room`='$room' AND `pwd` = '$pwd' AND `creator` = '$usr'");
}
else{
	$result = mysql_query("SELECT * FROM `sessions` WHERE `room` = '$room'");
	while($row = mysql_fetch_array($result)){
		$test=true;
		break;
	}

	if(!$test){
		die("room;Room does not exist.");
	}

	if($pwd!=$row["pwd"]){
		die("password;Incorrect password.");
	}

	$users=$row["guests"];
	$users=explode(";",$users);
	array_splice($users, array_search($usr,$users), 1);

	$users=join(";",$users);
	$result = mysql_query("UPDATE `sessions` SET `guests` = '$users' WHERE `room` = '$room'");
}
?>
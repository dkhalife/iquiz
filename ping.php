<?php
function iquiz_ping($room,$pwd,$usr,$admin=false){
	// Validate Login
	$result = mysql_query("SELECT * FROM `sessions` WHERE `room` = '$room'");
	$test=false;
	$test1=$test2=true;
	while($row = mysql_fetch_array($result)){
		$test=true;
		break;
	}

	if($test){
		if($pwd==$row["pwd"]){
			// User Checkup
			$users=$row["guests"];
			if(!preg_match("/".$usr."/",$users)){
				$test1=false;
			}

			// Admin Checkup
			if($usr!=$row["creator"]){
				$test2=false;
			}

			// Final Checkup
			if($test1 || $test2){
				mysql_query("INSERT INTO `ping` (`user`,`admin`) VALUES ('$usr','$admin')");
				// Check once every 5 times
				if(rand(1,5)==5){
					DHD($room,$usr,$admin,$users);
				}
			}

		}
	}
}

function DHD($room,$usr,$admin=false,$users){
	// Remove old pings
	if($admin){
		$q=mysql_query("SELECT COUNT(*)-1 as max FROM `ping` WHERE `user` = '$usr' AND `admin` = '1'");
		$max=0;
		while($row = mysql_fetch_array($q)){
			$max=$row['max'];
			break;
		}
		mysql_query("DELETE FROM `ping` WHERE `user`='$usr' AND `admin` = '1' AND `id`< (SELECT max(`id`) FROM(SELECT id FROM `ping` WHERE `user`='$usr' AND `admin` = '1' ORDER BY `id` DESC LIMIT 10) AS `myselect`);");
	}
	$users=explode(";",$users);
	for($i=0; $i<count($users); $i++){
		mysql_query("DELETE FROM `ping` WHERE `user`='{$users[$i]}' AND `admin` != '1' AND `id`< (SELECT max(`id`) FROM(SELECT id FROM `ping` WHERE `user`='{$users[$i]}' AND `admin` != '1' ORDER BY `id` DESC LIMIT 10) AS `myselect`);");
	}
	// Check if admin died
	$q=mysql_query("SELECT * FROM `ping` WHERE `user` = '$usr' AND `admin` = '1' AND `timestamp` >= NOW() - 60");
	$test=false;
	while($row = mysql_fetch_array($q)){
		$test=true;
		break;
	}
	if(!$test){
		// Disconnect admin
		mysql_query("UPDATE `sessions` WHERE `room` = '$room' SET `creator` = ''");
	}
	// Check if user died
	$tmp=$users;
	for($i=0; $i<count($users); $i++){
		$q=mysql_query("SELECT * FROM `ping` WHERE `user` = '{$users[$i]}' AND `admin` != '1' AND `timestamp` >= NOW() - 60");
		$test=false;
		while($row = mysql_fetch_array($q)){
			$test=true;
			break;
		}
		if(!$test){
			array_splice($tmp, array_search($users[$i],$tmp), 1);
		}
	}
	// Remove all inactive
	echo $users=join(";",$tmp);
	mysql_query("UPDATE `sessions` SET `guests` = '$users' WHERE `room` = '$room'");
}
?>
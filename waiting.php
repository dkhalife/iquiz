<?php

$room=$_POST["room"];
$pwd=$_POST["password"];
$usr=$_POST["user"];
if(isset($_GET["mode"])){
	$mode=$_GET["mode"];
}
else{
	$mode="";
}
include_once("mysql.php");
include_once("ping.php");

switch($mode){
	case "uwait" :
		iquiz_ping($room,$pwd,$usr);
		$result = mysql_query("SELECT * FROM `sessions` WHERE `room` = '$room'");
		$test=false;
		while($row = mysql_fetch_array($result)){
			$test=true;
			break;
		}
		
		if(!$test){
			die("E#0");
		}

		if($pwd!=$row["pwd"]){
			die("E#2");
		}

		$users=$row["guests"];
		if(!preg_match("/".$usr."/",$users)){
			die("E#3");
		}

		if($row["locked"]=="y"){
			echo "true";
		}
		else{
			echo "false";
		}
	break;

	case "qwait" :
		iquiz_ping($room,$pwd,$usr);
		$result = mysql_query("SELECT * FROM `sessions` WHERE `room` = '$room'");
		$test=false;
		while($row = mysql_fetch_array($result)){
			$test=true;
			break;
		}

		if(!$test){
			die("E#0");
		}

		if($pwd!=$row["pwd"]){
			die("E#2");
		}

		$users=$row["guests"];
		if(!preg_match("/".$usr."/",$users)){
			die("E#3");
		}

		if($row["locked"]=="o"){
			echo "exit";
		}
		else{
			$nbr=$_POST["nbr"];
			$result = mysql_query("SELECT * FROM `answers` WHERE `room` = '$room' AND `user` = '$usr' AND `qnbr` = '$nbr'");
			$test=true;
			while($row = mysql_fetch_array($result)){
				$test=false;
				break;
			}
			if($test){
				// User did not answer a question with that nbr for that room
				// Is there a question with that number yet?
				$result = mysql_query("SELECT * FROM `questions` WHERE `room` = '$room' AND `nbr` = '$nbr'");
				$test=false;
				while($row = mysql_fetch_array($result)){
					$test=true;
					break;
				}
				if($test){
					// There is a question
					// Check status of the question first [TODO !]
					$data="nbr='{$row['nbr']}';&question='{$row['question']}';&type='{$row['type']}';&q1='{$row['q1']}';&q2='{$row['q2']}';&q3='{$row['q3']}';&q4='{$row['q4']}';&q5='{$row['q5']}';&time='{$row['time']}';&image='{$row['image']}';&status='{$row['status']}';";
					echo $data;
				}
				else{
					// Keep him waiting
				}
			}
			else{
				// He did answer and is waiting

			}
		}
	break;

	default :
		$result = mysql_query("SELECT * FROM `sessions` WHERE `room` = '$room'");
		$test=false;
		while($row = mysql_fetch_array($result)){
			$test=true;
			break;
		}

		if(!$test){
			die("E#0");
		}

		if($row["locked"]=="y"){
			die("E#1");
		}

		if($pwd!=$row["pwd"]){
			die("E#2");
		}

		if($usr!=$row["creator"]){
			die("E#3");
		}

		echo $row["guests"];
		iquiz_ping($room,$pwd,$usr,true);
	break;
}
?>

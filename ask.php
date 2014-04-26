<?php
$room=$_POST["room"];
$pwd=$_POST["password"];
$usr=$_POST["user"];
$count=0;
include_once("mysql.php");
$q=mysql_query("SELECT * FROM `sessions` WHERE `room`='$room' AND `pwd` = '$pwd' AND `creator` = '$usr'");
while($row = mysql_fetch_array($q)){
	$count++;
}
if($count!=1){
	die("0");
}

/* Logged In */
$type=$_POST["type"];
$question=$_POST["question"];
$nbr=$_POST["nbr"];
$time=$_POST["time"];
$ans=$_POST["ans"];
$add_image=$_POST["add_image"];
$image="";
$uploads_dir = '/uploads';
if($add_image=="true"){
	if (!$_FILES["image"]["error"] > 0){
		$tmp_name = $_FILES["image"]["tmp_name"];
		$name = $_FILES["image"]["name"];
echo "A";
if(!is_writeable("$uploads_dir/$name")){
echo "C";
}
		if(move_uploaded_file($tmp_name, "$uploads_dir/$name")){
echo "A";
			$image=$name;
		}
	}
exit;
}

switch($type){
	case 0:
		/* True or False */
		mysql_query("INSERT INTO `questions` (`room`,`nbr`,`question`,`type`,`ans`,`time`,`image`,`status`) VALUES ('$room','$nbr','$question','$type','$ans','$time','$image','o')");
	break;

	case 1:
		/* Multiple Choice */
		$q1=$_POST["q1"];
		$q2=$_POST["q2"];
		$q3=$_POST["q3"];
		if(isset($_POST["q4"])){ $q4=$_POST["q4"]; } else { $q4=""; }
		if(isset($_POST["q5"])){ $q4=$_POST["q5"]; } else { $q5=""; }
		mysql_query("INSERT INTO `questions` (`room`,`nbr`,`question`,`type`,`q1`,`q2`,`q3`,`q4`,`q5`,`ans`,`time`,`image`,`status`) VALUES ('$room','$nbr','$question','$type','$q1','$q2','$q3','$q4','$q5','$ans','$time','$image','o')");
	break;

	case 2:
		/* Specific Answer */
		mysql_query("INSERT INTO `questions` (`room`,`nbr`,`question`,`type`,`ans`,`time`,`image`,`status`) VALUES ('$room','$nbr','$question','$type','$ans','$time','$image','o')");
	break;
}
echo "success";

iquiz_ping($room,$pwd,$usr,true);
?>
<?php
session_start();
$username="root";
$password="BloVar3Kill";
$database="lrratertest";
$host="localhost";
$con = mysql_connect($host,$username,$password);
mysql_select_db($database, $con) or die( "Unable to select database");

$lrusername=$_POST['lrusername'];
$lrusername = stripslashes($lrusername);
$lrusername = mysql_real_escape_string($lrusername);

$lrpassword=$_POST['lrpassword'];
$lrpassword = stripslashes($lrpassword);
$lrpassword = mysql_real_escape_string($lrpassword);
//hash password for security purposes
$lrpassword=sha1($lrpassword);


$result= mysql_query("SELECT * FROM lrusers WHERE username='$lrusername' AND password='$lrpassword'");
$row = mysql_fetch_array($result);
if($row){
	$_SESSION['userid']=$lrusername;
	}
else{
	mysql_close();
	header('Location: http://localhost/wittventures/litrater.html');
}

mysql_close();
header('Location: http://localhost/wittventures/litrater.php');

?> 
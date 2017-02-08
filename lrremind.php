<?php
$username="root";
$password="BloVar3Kill";
$database="lrratertest";
$host="localhost";
$con = mysql_connect($host,$username,$password);
mysql_select_db($database, $con) or die( "Unable to select database");

require("lrstyles.html");
require("headerclose.html");
require("logonavnouser.html");
require("leftsidebar.html");

$emailadd = $_POST['emailadd'];

if($emailadd){
	$result = mysql_query("SELECT * FROM lrusers WHERE email ='$emailadd'");
	$row = mysql_fetch_array($result);
	if($row[0] && filter_var($row['email'], FILTER_VALIDATE_EMAIL)){
	$to = $emailadd;
	$subject = "Lit Rater Reset";
	$message = "Your user name is " . $row['username'] . ".  Your Password has been reset to: 123456";
	$from = "litraterreset@litrater.com";
	$headers = "From:" . $from;
	mail($to,$subject,$message,$headers);
	echo"
	<div id=\"maincontent\">
	<p>
	<br/>
	<br/>
	<br/>
	<br/>
	</p>
	We have sent an email to your address with your username and a new password<br/>
	Please use that to log in and change your password.
	</div>
	";
	}
	else
	{
	echo"
	<div id=\"maincontent\">
	<p>
	<br/>
	<br/>
	<br/>
	<br/>
	</p>
	<form action=\"lrremind.php\" method=\"post\">
	We do not have that email address as belonging to a user.<br/>
	Please enter the email you used to register to Lit Rater     
	<input type=\"text\" name=\"emailadd\"/>
	<input type=\"submit\" value=\"Submit\"/>
	</form>
	</div>
	";
	}
}
else
require("Lrforgot.html");
mysql_close();
?>
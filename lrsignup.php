<?php
echo "got here";
$username="root";
$password="BloVar3Kill";
$database="lrratertest";
$host="localhost";
$con = mysql_connect($host,$username,$password);
mysql_select_db($database, $con) or die( "Unable to select database");

$lrprefix=$_POST['prefix'];
$lrprefix = stripslashes($lrprefix);
$lrprefix = mysql_real_escape_string($lrprefix);

$lrfirstname=$_POST['firstname'];
$lrfirstname = stripslashes($lrfirstname);
$lrfirstname = mysql_real_escape_string($lrfirstname);

$lrmiddlename=$_POST['middlename'];
$lrmiddlename = stripslashes($lrmiddlename);
$lrmiddlename = mysql_real_escape_string($lrmiddlename);

$lrlastname=$_POST['lastname'];
$lrlastname = stripslashes($lrlastname);
$lrlastname = mysql_real_escape_string($lrlastname);

$lrsuffix=$_POST['suffix'];
$lrsuffix = stripslashes($lrsuffix);
$lrsuffix = mysql_real_escape_string($lrsuffix);

$lremail=$_POST['emailadd'];
$lremail = stripslashes($lremail);
$lremail = mysql_real_escape_string($lremail);

$lrusername=$_POST['lruser'];
$lrusername = stripslashes($lrusername);
$lrusername = mysql_real_escape_string($lrusername);

$lrpassword1=$_POST['lrpassword1'];
$lrpassword1 = stripslashes($lrpassword1);
$lrpassword1 = mysql_real_escape_string($lrpassword1);

$lrpassword2=$_POST['lrpassword2'];
$lrpassword2 = stripslashes($lrpassword2);
$lrpassword2 = mysql_real_escape_string($lrpassword2);


/* Check to see if required fields were filled in */
if(!($lrfirstname && $lrlastname && $lremail && $lrusername && $lrpassword1 && $lrpassword2)){
	echo "there is a required field missing, repost page by passing to a php the missing fields";
}

/*check to see if password was typed in twice */
if($lrpassword1!=$lrpassword2){
	echo "the passwords don't match, repost page";
	//die();
	}

/* If all things were filled in, check to see if the username already exists */
$result=mysql_query("SELECT * FROM lrusers WHERE username='$lrusername'");	
	$row = mysql_fetch_array($result);
	if($row){
		echo "Need redirect to page where it tells them that the username is already in the database <br/>";
		}
	else{ //add in all information to the database
		//hash the password
		$lrpassword1 = sha1($lrpassword1);
		mysql_query("INSERT INTO lrusers(prefix, firstname, middlename, lastname, suffix, email, username, password) VALUES ('$lrprefix', '$lrfirstname', '$lrmiddlename', '$lrlastname', '$lrsuffix', '$lremail', '$lrusername', '$lrpassword1')");
		echo "information submitted, new user " . $lrusername . " " . $lrpassword1 . " created <br/>";
	}


mysql_close();
?> 
<?php
session_start();
echo "NOTHING";
if(isset($_SESSION['userid']))
	echo "userid = ". $_SESSION['userid']; 
else
 	echo "NO USER ID";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>LitRater: An archive of short stories for e-devices</title>

<link type="text/css" rel="stylesheet" href="LitRater.css"/>

<style type="text/css">

p
{
line-height:0;
}

#maincontent
{
text-indent:50px;
text-align:left;
}

</style>


</head>

<body>

<div id="logo">

<img STYLE="position:absolute; LEFT:15%;" src="logo1.png" alt="LitRater: An archive of short stories for e-devices"/>

</div>
<p>
</p>
<div id="leftsidebar">
<form action="lrsignup.php" method="post">
<p id="past">Search by Author
</p>
<p><input type="text" name="author"/>
</p>
<br/>
<p>Search by Title
</p>
<p><input type="text" name="title"/>
</p>
<br/>
<p>Search by Genre
</p>
<p><select name="genre" id="genre">
	<option>Science Fiction</option>
	<option>Fantasy</option>
</select>
</p>
<p>
<input type="submit" value="Submit"/>
</p>
</form>
</div>


<div id="maincontent">
<p>Enter the following information:
</p>
<form action="lrsignin.php" method="post">
<p>
Username: <input type="text" name="username" id="username"/> <br/>
Password: <input type="password" name="password" id="password"/><br/>
<input type="submit" value="Submit"/>
</form>
</div>

</body>
</html>
<?php
session_start();
$subject=$_POST['subject'];
$message=$_POST['message'];
if(isset($_SESSION['userid'])){
    $id = $_SESSION['userid'];
}
else{
    $id = $_POST['email'];
}

//mail("litrater@gmail.com",$subject,$message);

if(!isset($_SESSION['userid'])){
require("lrstyles.html");
require("headerclose.html");
require("logonavnouser.html");
require("leftsidebar.html");
echo "
<div id=\"maincontent\">
<br/>
<br/>
Message Sent
<br/>
</div>
";
require("rightsidebar.html");
}//SWITCH FOR USERID existing
else{
require("lrstyles.html");
require("headerclose.html");
echo "
<div id=\"logo\">
<img class=\"logoimg\" src=\"logo5.png\"  alt=\"LitRater: An archive of short stories for e-devices\"/>
<img src=\"LogoWords1.png\" />

<div id=\"welcome2\"> Welcome " . $_SESSION['userid'] . " <br/>
<a class=\"logout\" href=\"lrlogout.php\">[Log out]</a></div>
</div>

<div id=\"navigationbar\">
<ul>
<li><a class=\"menu\" href=\"news.asp\">News</a></li>
<li><a class=\"menu\" href=\"contact.asp\">Contact</a></li>
<li><a class=\"menu\" href=\"lrupload.php\">Upload a Story</a></li>
</ul>
<br/>
</div>
";
require("leftsidebar.html");
echo "
<div id=\"maincontent\">
<br/>
<br/>
Message Sent
<br/>
</div>
";
require("rightsidebar.html");
}

?>
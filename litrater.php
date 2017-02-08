<?php
session_start();
if(!isset($_SESSION['userid'])){
header( 'Location: http://www.litrater.com/index.html' ) ;
}
if(!isset($_SESSION['userid'])){
require("lrstyles.html");
require("headerclose.html");
require("logonavnouser.html");
require("leftsidebar.html");
require("maincontent.html");
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
require("maincontent.html");
require("rightsidebar.html");
}
?>

</body>
</html>
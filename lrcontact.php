<?php
session_start();
if(!isset($_SESSION['userid'])){
require("lrstyles.html");
require("headerclose.html");
require("logonavnouser.html");
require("leftsidebar.html");
echo "
<div id=\"maincontent\">
<br/>
<br/>
<br/>
<form action=\"lrcontacter.php\" method=\"post\">
<table cellpadding=\"10\">
<tr>
<td>
Subject: 
</td>
<td><input type=\"text\" size=\"39\" name=\"subject\" id=\"subject\"/>
</td>
</tr>
<tr>
<td>
Return Email Address
</td>
<td>
<input type=\"text\" size=\"39\" name=\"email\" id=\"email\"/>
</td>
</tr>
<tr>
<td>
Message: 
</td>
<td>
<textarea name=\"message\" rows=\"10\" cols=\"30\"></textarea> 
</td>
</tr>
<tr>
<td>
</td>
<td>
<BUTTON TYPE=SUBMIT>Submit</button>
</td>
</tr>
</table>
</form>
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
<br/>
<form action=\"lrcontacter.php\" method=\"post\">
<table cellpadding=\"10\">
<tr>
<td>
Subject: 
</td>
<td><input type=\"text\" size=\"39\" name=\"subject\" id=\"subject\"/>
</td>
</tr>
<tr>
<td>
</td>
</tr>
<tr>
<td>
Message: 
</td>
<td>
<textarea name=\"message\" rows=\"10\" cols=\"30\"></textarea> 
</td>
</tr>
<tr>
<td>
</td>
<td>
<BUTTON TYPE=SUBMIT>Submit</button>
</td>
</tr>
</table>
</form>
</div>
";
require("rightsidebar.html");
}
?>

</body>
</html>
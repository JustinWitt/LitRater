<?php
session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>LitRater: An archive of short stories for e-devices</title>

<style type="text/css">

#logo
{
width:100%;
height:75px;
background-color:#A7C9AE;
}

#navigationbar{
background-color:#dddddd;
height:20px;
}

ul{
list-style-type:none;
margin:0;
padding:0;
}

li{
margin:0;
padding:0;
float:right;
display:inline-block;
width:12%;
font-weight:bold;
}

a.menu{
color:#000000;
text-decoration: none;
}

img.logoimg{
float:left;
}

#leftsidebar{
top:100px;
margin-left:20px;
padding:0;
postion: absolute;
width: 175px;
height: 400px;
border-right:1px solid black;
}

#maincontent{
position: absolute;
width: 400px;
top: 100px;
margin-left:210px;
}


#rightsidebar{
top: 119px;
position: absolute;
padding-left:1em;
width:150px;
left: 77%;
height: 400px;
border-left:1px solid black;
}

#welcome1{
padding-top:50px;
padding-right:10px;
float:right;
font-size:10px;
}

#welcome2{
padding-top:50px;
padding-right:10px;
float:right;
font-size:10px;
}


.loginarea{
padding-top:3em;
padding-right:2em;
float:right;
}

.smallertext{
font-size:10px;
width:5em;
}

</style>
</head>
<body>

<?php
if(!isset($_SESSION['userid'])){
echo"
<div id=\"logo\">
<img class=\"logoimg\" src=\"logo5.png\"  alt=\"LitRater: An archive of short stories for e-devices\"/>
<img src=\"LogoWords1.png\" />
<div id=\"welcome1\"> 
<form action=\"lrsignin.php\" method=\"post\" >
User Name <input type=\"text\" name=\"lrusername\" class=\"smallertext\"/>
Password <input type=\"password\" name=\"lrpassword\" cols=\"10\"class=\"smallertext\"/>
<input type=\"submit\" value=\"Login\" class=\"smallertext\"/>
</form>
</div>
</div>


<div id=\"navigationbar\">
<ul>
<li><a class=\"menu\" href=\"default.asp\">Register</a></li>
<li><a class=\"menu\" href=\"news.asp\">News</a></li>
<li><a class=\"menu\" href=\"contact.asp\">Contact</a></li>
<li><a class=\"menu\" href=\"about.asp\">About</a></li>
</ul>
<br/>
</div>

<p>
</p>
<div id=\"leftsidebar\">
<form action=\"lrsearch.php\" method=\"GET\">
<p>Search by Author
</p>
<p><input type=\"text\" name=\"authorsearch\" id=\"authorsearch\"/>
</p>
<p>Search by Title
</p>
<p><input type=\"text\" name=\"titlesearch\" id=\"titlesearch\"/>
</p>
<p>Search by Keyword
</p>
<p>
<input type=\"text\" name=\"keywordsearch\" id=\"keywordsearch\"/>
</p>
<p>
<input type=\"submit\" value=\"Submit\"/>
</p>
</form>
</div>


<div id=\"maincontent\">
Top Ten Short Stories (By Rating)
</div>

<div id=\"rightsidebar\">
<p> What is LitRater?  
LitRater is a blah blah blah
copy goes here.
</p>
</div>

</body>
</html>
";
}//SWITCH FOR USERID existing
else{
echo "
<div id=\"logo\">
<img class=\"logoimg\" src=\"logo5.png\"  alt=\"LitRater: An archive of short stories for e-devices\"/>
<img src=\"LogoWords1.png\" />
<div id=\"welcome2\"> Welcome " . $_SESSION['userid'] . " </div>
</div>


<div id=\"navigationbar\">
<ul>
<li><a class=\"menu\" href=\"news.asp\">News</a></li>
<li><a class=\"menu\" href=\"contact.asp\">Contact</a></li>
<li><a class=\"menu\" href=\"about.asp\">About</a></li>
</ul>
<br/>
</div>

<p>
</p>
<div id=\"leftsidebar\">
<form action=\"lrsearch.php\" method=\"GET\">
<p>Search by Author
</p>
<p><input type=\"text\" name=\"authorsearch\" id=\"authorsearch\"/>
</p>
<p>Search by Title
</p>
<p><input type=\"text\" name=\"titlesearch\" id=\"titlesearch\"/>
</p>
<p>Search by Keyword
</p>
<p>
<input type=\"text\" name=\"keywordsearch\" id=\"keywordsearch\"/>
</p>
<p>
<input type=\"submit\" value=\"Submit\"/>
</p>
</form>
</div>


<div id=\"maincontent\">
Top Ten Short Stories (By Rating)
</div>


</body>
</html>
";
}
?>
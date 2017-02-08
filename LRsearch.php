<?php
session_start();


function array_concate($array1,$array2){
$array3 = $array1;
foreach($array2 as $element){
	array_push($array3,$element);
}
return $array3;
}

$username="root";
$password="BloVar3Kill";
$database="lrratertest";
$host="localhost";
$con = mysql_connect($host,$username,$password);
mysql_select_db($database, $con) or die( "Unable to select database");


/* Drop boxes for suffixes and prefixes?
Add strlen() checks to keep from too much for DB?
Figure out error handling and redirecting?
Combine tables lrsubject and lrsubjectid by just having like the series table?
*/



$titlesearch=$_GET['titlesearch'];
$titlesearch = stripslashes($titlesearch);
$titlesearch = mysql_real_escape_string($titlesearch);

$authorsearch=$_GET['authorsearch'];
$authorsearch = stripslashes($authorsearch);
$authorsearch = mysql_real_escape_string($authorsearch);

$keywordsearch=$_GET['keywordsearch'];
$keywordsearch = stripslashes($keywordsearch);
$keywordsearch = mysql_real_escape_string($keywordsearch);



if($titlesearch){
	$titleidarray=array("0");//an array of the lrids that match the title
	array_pop($titleidarray);
	$titlematch = array("0");
	array_pop($titlematch);
	$result=mysql_query("SELECT idnum FROM lrid WHERE title like '%$titlesearch%'");
	if($result){
		while($row=mysql_fetch_array($result)){
			array_push($titlematch,$row[0]);
		}
	}
	$innertitle=explode(" ",$titlesearch);
	foreach($innertitle as $titlebit){
		$result=mysql_query("SELECT idnum FROM lrid WHERE title like '%$titlebit%'"); 
		if($result){
			while($row = mysql_fetch_array($result)){
				array_push($titleidarray,$row[0]);
			}
		}
	}
	//now to create an array where the authorids are the keys and the number of occurrences of each are the values of the array
	$titlecount=array_count_values($titleidarray);
	//now to sort that array by values so that the authorid with the highest number of hits in the above search is in position 1
	arsort($titlecount);
	$titlecountids=array_keys($titlecount);		
}
/*
if($titlesearch){
foreach($titlematch as $lrid)
	echo "Title match lrid is " . $lrid . "<br/>";
foreach($titlecountids as $lrid2)
	echo "Title lrid is " . $lrid2 . "<br/>";
}
*/
if($authorsearch){
	$authoridarray=array("0");//an array of the IDs for the authors of the piece
	array_pop($authoridarray);
	$innerauthor=explode(" ",$authorsearch);//innerauthor now contains the bits of the author's name
	foreach($innerauthor as $authorbit){
		//get all matches where the bits are to be found in any of the fields in the table
		$result=mysql_query("SELECT authorid FROM lrauthorid WHERE firstname like '%$authorbit%' OR (middlename like '%$authorbit%' OR lastname like '%$authorbit%')");
		if($result){
			while($row = mysql_fetch_array($result))
	  			{//want to create an array of all the lrauthorids
			  	array_push($authoridarray,$row[0]);
				}
			}
		}
	//now to create an array where the authorids are the keys and the number of occurrences of each are the values of the array
	$authorcount=array_count_values($authoridarray);
	//now to sort that array by values so that the authorid with the highest number of hits in the above search is in position 1
	arsort($authorcount);
	$authorids = array_keys($authorcount);
	$authorlridarray=array("0");//an array of the IDs for the authors of the piece
	array_pop($authorlridarray);
	foreach($authorids as $authorbit){
		$result=mysql_query("SELECT idnum FROM lrauthor WHERE authorid='$authorbit'");
		if($result){
			while($row = mysql_fetch_array($result)){
				array_push($authorlridarray,$row[0]);
			}
		}
	}
}
/*
if($authorsearch){
foreach($authorlridarray as $lrid3)
	echo "the author lrid is " . $lrid3 . "<br/>";
}
*/
if($keywordsearch){
	$keywordidarray=array("0");//an array of the IDs for the authors of the piece
	array_pop($keywordidarray);
	$innerkeyword=explode(" ",$keywordsearch);//innerauthor now contains the bits of the author's name
	foreach($innerkeyword as $keywordbit){
		//get all matches where the bits are to be found in any of the fields in the table
		$result=mysql_query("SELECT idnum FROM lrkeyword WHERE keyword like '%$keywordbit%'");
		if($result){
			while($row = mysql_fetch_array($result))
	  			{//want to create an array of all the lrauthorids
			  	array_push($keywordidarray,$row[0]);
				}
			}
		}
	//now to create an array where the authorids are the keys and the number of occurrences of each are the values of the array
	$keywordcount=array_count_values($keywordidarray);
	//now to sort that array by values so that the authorid with the highest number of hits in the above search is in position 1
	arsort($keywordcount);
	$keywordids = array_keys($keywordcount);
}
/*
if($keywordsearch){
foreach($keywordids as $lrid4)
	echo "keyword match lrid is " . $lrid4 . "<br/>";
}
*/
//now for cutting down the search results...
if($authorsearch){
	$finalidarray = $authorlridarray;
}
elseif($titlesearch){
	if($titlematch)
		$finalidarray = $titlematch;
	else
		$finalidarray = $titlecountids;
}
elseif($keywordsearch){
	$finalidarray = $keywordids;
}
else{
	echo "ERROR please enter in search criteria";
	die();
	$finalidarray = 0;
}


if($titlesearch){
	if($titlematch)
		$finalidarray = array_intersect($finalidarray,$titlematch);
	else
		$finalidarray = array_intersect($finalidarray,$titlecountids);
}
if($keywordsearch){
	$finalidarray = array_intersect($finalidarray,$keywordids);
}
//here the finalidarray consists of all the direct matches at the top of the array
//so why not add all three other ones starting with title and author right after it
//so that we get all the matches with best at the top?  Which is what I'm going to do

if($titlesearch){
	if($titlematch)
		$finalidarray = array_concate($finalidarray,$titlematch);
	else
		$finalidarray = array_concate($finalidarray,$titlecountids);
}
if($authorsearch){
	$finalidarray = array_concate($finalidarray,$authorlridarray);
}
if($keywordsearch){
	$finalidarray = array_concate($finalidarray,$keywordids);
}





//now to strip the array of repeats before printing
$finalidarray = array_unique($finalidarray);

//now to trim the results to the top 100 hits
$finalidarray = array_slice($finalidarray,0,99);

//now to print the page with the matches in the main content area
$_SESSION['top100'] = $finalidarray;
$_SESSION['searchsize'] = sizeof($finalidarray);
$_SESSION['currentspot'] = 0;

$average100=array();
//add a bit here where it gives the average rating (for right now, add personalization much later)
foreach($finalidarray as $finalidvalue){
	$result = mysql_query("SELECT dailyrating FROM lrdailyratings WHERE idnum='$finalidvalue'");
	while($row = mysql_fetch_array($result))
		{$average100[$finalidvalue]= $row['dailyrating'];}
}

$_SESSION['average100'] = $average100;


if(!isset($_SESSION['userid'])){
require("lrstyles.html");
require("headerclose.html");
require("logonavnouser.html");
require("leftsidebar.html");
require("lrsearchfirst.php");
require("rightsidebar.html");
}//SWITCH FOR USERID existing

else{
require("lrstyles.html");
require("jsforrating.html");
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
require("lrsearchfirst.php");
require("rightsidebar.html");
}



mysql_close();
?>

</body>
</html>
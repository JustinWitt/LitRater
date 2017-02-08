<?php
session_start();
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

function customError($errormsg){
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
	echo "<div id=\"uploadsuccess\">";
	echo "<br/><br/>";
	echo $errormsg;
	echo "</div>";
	die();
}

//BEGIN TITLE BIT

/*Put all tests at top to prevent putting half-baked crap in database */

$title=$_POST['title'];
$title = stripslashes($title);
$title = mysql_real_escape_string($title);
if(strlen($title)>300)
	{
	customError("Your title is too long, please try to repost with a shorter title <br/>");
	}
else
	{

//END TITLE BIT

/*Begin AUTHOR BIT*/
$authornum = 0;
$keepgoing = 1;
while($keepgoing)
{
	$authornum++;
	$authorinc = "lastname" . $authornum;
	if(!isset($_POST[$authorinc]))
		$keepgoing = 0;

}
$authornum--;
//authornum now has the number of authors submitted

$authorstring = "";
while($authornum > 0){
	$authorbit = "prefix" . $authornum;
	$authorstring = $authorstring . $_POST[$authorbit] . ";";
	$authorbit = "firstname" . $authornum;
	$authorstring = $authorstring . $_POST[$authorbit] . ";";
	$authorbit = "middlename" . $authornum;
	$authorstring = $authorstring . $_POST[$authorbit] . ";";
	$authorbit = "lastname" . $authornum;
	$authorstring = $authorstring . $_POST[$authorbit] . ";";
	$authorbit = "suffix" . $authornum;
	$authorstring = $authorstring . $_POST[$authorbit];
	$authorstring = $authorstring . "|";
	$authornum--;	
}
//authorstring now has the author string with prefix etc separated by ; and full names separated by |

$authorstring = stripslashes($authorstring);
$authorstring = mysql_real_escape_string($authorstring);
$authorarray=explode("|",$authorstring);
//$authorarray now has each authors name as a string in that array

$numofauthors=count($authorarray);
$numofauthors--; //because each authorstring ends with a | we need to decrease it by one
if($numofauthors>100)
	{customError("You have tried to add too many authors, please only add the necessary authors <br/>");
	}
else
{

$suffix=0;
$i=0;
$authoridarray=array();//an array of the IDs for the authors of the piece
while($i<$numofauthors)
	{
	//initializes all fields for authorid table inputs
	$prefix = "";
	$firstname="";
	$middlename="";
	$middlename2="";
	$middlename3="";
	$lastname="";
	$suffix="";
	$innerauthor=explode(";",$authorarray[$i]);
//innerauthor now has in index 0 = prefix, 1=firstname, 2=middlename, 3=lastname, 4=suffix
//goes through each name and associates it with the correct field for up to 6 fields

//checks to see if only one name has been entered, if so, it puts it in the last name placeholder
$numberofnames=0;
if($innerauthor[1])
	$numberofnames++;
if($innerauthor[2])
	$numberofnames++;
if($innerauthor[3])
	$numberofnames++;
if($numberofnames==1){
	$lastname = $lastname . $innerauthor[1];
	$lastname = $lastname . $innerauthor[2];
	$lastname = $lastname . $innerauthor[3];
}
else
{
$prefix = $innerauthor[0];
$firstname = $innerauthor[1];
$middlename = $innerauthor[2];
$lastname = $innerauthor[3];
$suffix = $innerauthor[4];
}


/*  Scaffolding for author name parts 
	echo "Author " . $i . "'s prefix is " . $prefix . "<br/>";
	echo "Author " . $i . "'s firstname is " . $firstname . "<br/>";
	echo "Author " . $i . "'s middle name is " . $middlename . "<br/>";
	echo "Author " . $i . "'s lastname is " . $lastname . "<br/>";
	echo "Author " . $i . "'s suffix is " . $suffix . "<br/>"; 
*/
	//do check to see if author already exists
	$result=mysql_query("SELECT authorid FROM lrauthorid WHERE firstname='$firstname' AND lastname='$lastname' AND suffix='$suffix'");
	$row = mysql_fetch_array($result);
	//$authorid = $row[0];
	if($row){
		//echo "Author id already exists is " . $authorid . " <br/>";
		array_push($authoridarray,$row[0]);
		}
	else{
		$sql="INSERT INTO lrauthorid (firstname, middlename, middlename2, middlename3, lastname, suffix) VALUES ('$firstname','$middlename','$middlename2','$middlename3','$lastname','$suffix')";
		if (!mysql_query($sql,$con))
		  {
		  customError("The file failed to upload into the database, please contact the administrator and reference error code 251");
		  }
//		echo "1 record added";
		$result=mysql_query("SELECT authorid FROM lrauthorid WHERE firstname='$firstname' AND lastname='$lastname' AND suffix='$suffix'");
		$row = mysql_fetch_array($result);
		$authorid = $row[0];
		echo "the authorid is " . $authorid . "<br/>";
		array_push($authoridarray,$authorid);
	     }//end of authorid test
	$i++;
	}

}
//END separation of authors and creation of ids which are fine to keep, authorid can have more than lrid
//however, we now want to check to see if the authors have written anything with the same title
//if they have, we have to stop the whole process right here...

$descr= $_POST['descr'];
$descr = stripslashes($descr);
$descr = mysql_real_escape_string($descr);

$possiblelrid = array();
$result=mysql_query("SELECT * FROM lrid WHERE title='$title'");
while($row=mysql_fetch_array($result)){
	array_push($possiblelrid,$row[0]);
}


//first check to see if author and title already exist
foreach($authoridarray as $arrayitem){
	foreach($possiblelrid as $lrid){
		$result=mysql_query("SELECT * FROM lrauthor WHERE authorid='$arrayitem' AND idnum='$lrid'");	
		$row = mysql_fetch_array($result);
		if($row){
			customError("That title and author is already in the database, please upload another work.  If you feel this message is in error please contact the administrator with code 151.");
			$nofornow=1;
		}
	}
}	


foreach($authoridarray as $arrayitem){
	$todaysdate=date("dmY");
	$sql="INSERT INTO lrid(title, dateuploaded, userid, description) VALUES ('$title','$todaysdate','1','$descr')";
	//insert into LRID table
	mysql_query($sql);
	$lrid=mysql_insert_id($con);//id needs to be the last lrid submitted by this script
	//now to associate the authorid with the lrid (idnum) in the table
	mysql_query("INSERT INTO lrauthor(authorid,idnum) VALUES ('$arrayitem','$lrid')");
}// end of foreach
	


//BEGIN GENRE BIT
$genreone=$_POST['genreone'];
if($genreone){ 
	mysql_query("INSERT INTO lrgenres (idnum, genre) VALUES ('$lrid','$genreone')");
	}
$genretwo=$_POST['genretwo'];
if($genretwo){
	mysql_query("INSERT INTO lrgenres (idnum, genre)VALUES ('$lrid','$genretwo')");
	}
//END Genre Bit


//split keywords into separate words
//check each word in the keyword index
//if new, put into keyword index
//put indexes of keywords into table associating them with LRID
$keywords=$_POST['keywords'];
$keywords = stripslashes($keywords);
$keywords = mysql_real_escape_string($keywords);
$keywordsarray=explode(";",$keywords);
$numofkeywords=count($keywordsarray);
if($numofkeywords>10)
	{echo "there are too many keywords";
	}
else
{
//gets rid of null keyword if string ended in a ; originally
if($keywordsarray[$numofkeywords-1]=="")
	$numofkeywords--;
//gets rid of empty characters on left and right of keywords names
for($i=0;$i<$numofkeywords; $i++){
	$keywordsarray[$i] = trim($keywordsarray[$i]);
	}

$i=0;
while($i<$numofkeywords)
	{
	mysql_query("INSERT INTO lrkeyword (keyword,idnum) VALUES ('$keywordsarray[$i]','$lrid')");
	$i++;
	}//end of while loop for going through the keywords

}


$series=$_POST['series'];
$series = stripslashes($series);
$series = mysql_real_escape_string($series);
if($series){
mysql_query("INSERT INTO lrseries (series,idnum) VALUES ('$series','$lrid')");
	}
}//end of title length test


if ($_FILES['ufile']['size'] < 999999)
  {
	$filenamer = $_FILES['ufile']['name'];
	$fileext = pathinfo($filenamer,PATHINFO_EXTENSION);
	if($fileext == "pdf" || $fileext == "txt" || $fileext == "docx" || $fileext == "epub" || $fileext == "mobi" || $fileext == "azw" || $fileext == "opf" || $fileext == "tr2" || $fileext == "tr3" || $fileext == "htm" || $fileext == "html" || $fileext == "fb2" || $fileext == "pdb" || $fileext == "prc"){
		copy($_FILES["ufile"]["tmp_name"],"lruploads/" . $lrid . "." . $fileext);
		$everythingisgood=1;
    		}
	else
	  customError("You attempted to upload a type of file LitRater does not accept.  Please try uploading a file that is in a standard e-reader format such as mobipocket or epub.");

  }
else
  {
	  customError("You attempted to upload a file that was too large for LitRater, please upload a shorter work.");
  }

if($everythingisgood){
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
	echo "<div id=\"uploadsuccess\">";
	echo "You have successfully uploaded:<br/>";
	echo $title . "<br/>";
	echo "by <br/>";
	//get authornames from database
	$result=mysql_query("SELECT authorid FROM lrauthor WHERE idnum='$lrid'");
	while($row=mysql_fetch_array($result)){
		$result2=mysql_query("SELECT * FROM lrauthorid WHERE authorid='$row[0]'");
		while($row2=mysql_fetch_array($result2)){
			echo $row2[1] . " " . $row2[2] . " " . $row2[3] . " " . $row2[6] . " " . $row2[7] . "<br/>";
			}
		}		
	echo "</div>";

}

/*
if ($_FILES['ufile']['size'] < 999999 && $_FILES['ufile']['type']=="text/plain")
  {
  if ($_FILES["ufile"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["ufile"]["error"] . "<br />";
    }
   else{
    copy($_FILES["ufile"]["tmp_name"],
      "lruploads/" . $lrid . ".txt");
      }
  }
else
  {
  echo "Invalid file";
  }
*/
//end file size and type if


mysql_close();
?>
</body>
</html>
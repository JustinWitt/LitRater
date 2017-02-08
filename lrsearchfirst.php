<?php
$finalidarray = $_SESSION['top100'];
//searchsize is the length of the returned search result array (assuming less than 100)
$searchsize = $_SESSION['searchsize'];
if(isset($_SESSION['userid']))
	$username = $_SESSION['userid'];
//currentspot is where it currently is in the search result array
$currentspot = 0;
$currentspot10 = $currentspot + 9;


/*************************put matches of search here***************/
echo "<div id=\"maincontent\">";
echo "<br/><br/>";
//check to see if the damn thing even exists
if($finalidarray){
echo "There are " . $searchsize . " results for your search<br/><br/>";

echo "<table>";

/********formats and prints out the results ************/
while($currentspot <= $currentspot10 && $currentspot < $searchsize){

echo "<tr>";
echo "<td class=\"searchnum\">";
	echo $currentspot+1 . ". ";
echo "</td>";
	if($finalidarray[$currentspot]){
		$lrid = $finalidarray[$currentspot];
//start of where we want to cut for other searches
		$result=mysql_query("SELECT title, description FROM lrid WHERE idnum='$lrid'");
	if($result){
		$row = mysql_fetch_array($result);
		$title = $row[0];
		$description = $row[1];
		}
echo "<td class=\"searchtitle\">";
	echo $title . "<br/>";
	echo "by ";
	$cycle = 0;
	$result=mysql_query("SELECT authorid FROM lrauthor WHERE idnum='$lrid'");
		if($result){
		while($row = mysql_fetch_array($result)){
			if($cycle)
				echo ", ";
			$result2=mysql_query("SELECT firstname, middlename, middlename2, middlename3, lastname, suffix FROM lrauthorid WHERE authorid='$row[0]'");
			$row2 = mysql_fetch_array($result2);
			if($row2['firstname'])
				echo $row2['firstname'] . " ";
			if($row2['middlename'])
				echo $row2['middlename'] . " ";
			if($row2['middlename2'])
				echo $row2['middlename2'] . " ";
			if($row2['middlename3'])
				echo $row2['middlename3'] . " ";
			if($row2['lastname'])
				echo $row2['lastname'];
			if($row2['suffix'])
				echo " " . $row2['suffix'];
			$cycle = 1;
			}
		}
	echo "<br/>";
	if($description){
		echo $description. "<br/>";
		}
			}
		$currentspot++;	
//addin all the rating crap
if(isset($_SESSION['userid'])){
	//check to see if the user has already rated the title
	$userratingresult = mysql_query("SELECT rating FROM lrratings WHERE idnum='$lrid' AND username='$username'");
	$ratingresult = mysql_fetch_array($userratingresult);
	if($ratingresult){
		$userrating=$ratingresult[0];
		}
	elseif(array_key_exists($lrid,$average100)){
		$orangeint = floor($average100[$lrid]);
		$orangedeci = $average100[$lrid]-$orangeint;
		}
	else{
		$orangeint = 0;
		$orangedeci = 0;
		$userrating = 0;}
	if($userrating >= 1){
	echo"
	<img src=\"filledstar.png\" id=\"star1" . $lrid . "\" name=\"star1\"
	onmouseover= \"fillStars('s1'," . $lrid . ",'s" . $userrating . "');\"
	onmouseout = \"clearStars('s1'," . $lrid . ");\"
	onclick = \"starClick('s1'," . $lrid . ",'" . $username . "');\" 
	>";
	}
	else{
	echo"
	<img src=\"blankstar.png\" id=\"star1" . $lrid . "\" name=\"star1\"
	onmouseover= \"fillStars('s1'," . $lrid . ",'s" . $userrating . "');\"
	onmouseout = \"clearStars('s1'," . $lrid . ");\"
	onclick = \"starClick('s1'," . $lrid . ",'" . $username . "');\" 
	>";
	}
	if($userrating >=2){
	echo"
	<img src=\"filledstar.png\" id=\"star2" . $lrid . "\" name=\"star2\"
	onmouseover= \"fillStars('s2'," . $lrid . ",'s" . $userrating . "');\"
	onmouseout = \"clearStars('s2'," . $lrid . ");\"
	onclick = \"starClick('s2'," . $lrid . ",'" . $username . "');\"
	>";
	}
	else{
	echo"
	<img src=\"blankstar.png\" id=\"star2" . $lrid . "\" name=\"star2\"
	onmouseover= \"fillStars('s2'," . $lrid . ",'s" . $userrating . "');\"
	onmouseout = \"clearStars('s2'," . $lrid . ");\"
	onclick = \"starClick('s2'," . $lrid . ",'" . $username . "');\"
	>";
	}
	if($userrating >=3){
	echo"
	<img src=\"filledstar.png\" id=\"star3" . $lrid . "\" name=\"star3\" 
	onmouseover= \"fillStars('s3'," . $lrid . ",'s" . $userrating . "');\"
	onmouseout = \"clearStars('s3'," . $lrid . ");\"
	onclick = \"starClick('s3'," . $lrid . ",'" . $username . "');\"
	>";
	}
	else{
	echo"
	<img src=\"blankstar.png\" id=\"star3" . $lrid . "\" name=\"star3\" 
	onmouseover= \"fillStars('s3'," . $lrid . ",'s" . $userrating . "');\"
	onmouseout = \"clearStars('s3'," . $lrid . ");\"
	onclick = \"starClick('s3'," . $lrid . ",'" . $username . "');\"
	>";
	}
	if($userrating >=4){
	echo"
	<img src=\"filledstar.png\" id=\"star4" . $lrid . "\" name=\"star4\" 
	onmouseover= \"fillStars('s4'," . $lrid . ",'s" . $userrating . "');\"
	onmouseout = \"clearStars('s4'," . $lrid . ");\"
	onclick = \"starClick('s4'," . $lrid . ",'" . $username . "');\"
	>";
	}
	else{
	echo"
	<img src=\"blankstar.png\" id=\"star4" . $lrid . "\" name=\"star4\" 
	onmouseover= \"fillStars('s4'," . $lrid . ",'s" . $userrating . "');\"
	onmouseout = \"clearStars('s4'," . $lrid . ");\"
	onclick = \"starClick('s4'," . $lrid . ",'" . $username . "');\"
	>";
	}
	if($userrating ==5){
	echo"
	<img src=\"filledstar.png\" id=\"star5" . $lrid . "\" name=\"star5\" 
	onmouseover= \"fillStars('s5'," . $lrid . ",'s" . $userrating . "');\"
	onmouseout = \"clearStars('s5'," . $lrid . ");\"
	onclick = \"starClick('s5'," . $lrid . ",'" . $username . "');\"
	>";
	}
	else{
	echo"
	<img src=\"blankstar.png\" id=\"star5" . $lrid . "\" name=\"star5\" 
	onmouseover= \"fillStars('s5'," . $lrid . ",'s" . $userrating . "');\"
	onmouseout = \"clearStars('s5'," . $lrid . ");\"
	onclick = \"starClick('s5'," . $lrid . ",'" . $username . "');\"
	>";
	}
}
else{
if(array_key_exists($lrid,$average100)){
//for those who aren't signed in, it will display the average rating currently
if($average100[$lrid]<.33)
	echo"<img src=\"starimages/thirdfilled.png\"/>";
if($average100[$lrid]>=.33 && $average100[$lrid] < .50)
	echo"<img src=\"starimages/halffilled.png\"/>";
if($average100[$lrid]>=.50 && $average100[$lrid] < .66)
	echo"<img src=\"starimages/twothirdfilled.png\"/>";
if($average100[$lrid]>=.66 && $average100[$lrid] < 1)
	echo"<img src=\"starimages/onefilled.png\"/>";
if($average100[$lrid]>=1 && $average100[$lrid] < 1.33)
	echo"<img src=\"starimages/oneandthird.png\"/>";
if($average100[$lrid]>=1.33 && $average100[$lrid] < 1.50)
	echo"<img src=\"starimages/oneandhalf.png\"/>";
if($average100[$lrid]>=1.50 && $average100[$lrid] < 1.66)
	echo"<img src=\"starimages/oneandtwothird.png\"/>";
if($average100[$lrid]>=1.66 && $average100[$lrid] < 2)
	echo"<img src=\"starimages/twofilled.png\"/>";
if($average100[$lrid]>=2 && $average100[$lrid] < 2.33)
	echo"<img src=\"starimages/twoandthird.png\"/>";
if($average100[$lrid]>=2.33 && $average100[$lrid] < 2.50)
	echo"<img src=\"starimages/twoandhalf.png\"/>";
if($average100[$lrid]>=2.50 && $average100[$lrid] < 2.66)
	echo"<img src=\"starimages/twoandtwothird.png\"/>";
if($average100[$lrid]>=2.66 && $average100[$lrid] < 3)
	echo"<img src=\"starimages/threefilled.png\"/>";
if($average100[$lrid]>=3 && $average100[$lrid] < 3.33)
	echo"<img src=\"starimages/threeandthird.png\"/>";
if($average100[$lrid]>=3.33 && $average100[$lrid] < 3.50)
	echo"<img src=\"starimages/threeandhalf.png\"/>";
if($average100[$lrid]>=3.50 && $average100[$lrid] < 3.66)
	echo"<img src=\"starimages/threeandtwothird.png\"/>";
if($average100[$lrid]>=3.66 && $average100[$lrid] < 4)
	echo"<img src=\"starimages/fourfilled.png\"/>";
if($average100[$lrid]>=4 && $average100[$lrid] < 4.33)
	echo"<img src=\"starimages/fourandthird.png\"/>";
if($average100[$lrid]>=4.33 && $average100[$lrid] < 4.50)
	echo"<img src=\"starimages/fourandhalf.png\"/>";
if($average100[$lrid]>=4.50 && $average100[$lrid] < 4.66)
	echo"<img src=\"starimages/fourandtwothird.png\"/>";
if($average100[$lrid]>=4.66 && $average100[$lrid] <=5)
	echo"<img src=\"starimages/fivefilled.png\"/>";
}//end of checking if key exists meaning that there is a rating for the title
}

//end of all the rating crap
		echo "<br/>";
		echo "<a href=\"lrworks/pdf-test.pdf\">PDF Version</a>";
		echo "</td></tr><tr><td><br/></td></tr>";
	}
echo "</table>";

/********end of printout **************/

echo "<br/><br/>";
$_SESSION['currentspot']=$currentspot;
if($currentspot == 10 && $searchsize > 10){
	echo "<a class=\"first\" href=\"lrsearchnext.php\">Results 11-20</a>";
	}

}//end of check to see if there are any results at all

if(!$finalidarray){//if there are no results at all
	echo "There are no matches, please try your search again with different criteria<br/>";
	}
echo "</div>";
/************************end of printing search matches*************/


?>
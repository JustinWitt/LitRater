<?php
require("connectvar.php");
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)OR DIE('Unable to connect to database! Please try again.');

$usernum = $_GET["usernum"];//gets the user id number
$lrid = $_GET["lrid"];
$rating = $_GET["rating"];

$alreadythere = mysqli_query($con,"SELECT * FROM lrratings WHERE username = '$usernum' AND idnum = '$lrid'");
if($alreadythere){
	$row=mysqli_fetch_array($alreadythere);
}
else{
	$row = NULL;
}
if($row){
	mysqli_query($con,"UPDATE lrratings SET rating='$rating' WHERE username = '$usernum' AND idnum = '$lrid'");
}
else{
	mysqli_query($con,"INSERT INTO lrratings(username, idnum, rating) VALUES ('$usernum','$lrid','$rating')");
}
mysqli_close($con);
?>
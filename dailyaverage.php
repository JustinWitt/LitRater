<?php
require("connectvar.php");
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)OR DIE('Unable to connect to database! Please try again.');

//this should fill the daily average table, do once a day...

$lrids = array();
$totalarray = array();
$numberofratings = array();
$ratingsaverage = array();


$allratings=mysqli_query($con,"SELECT * FROM lrratings");
while($lridsrows=mysqli_fetch_array($allratings)){
	$lrid = $lridsrows['lrid'];
	$lridrating = $lridsrows['rating'];
	if(array_key_exists($lrid,$totalarray))
		$totalarray[$lrid]=$totalarray[$lrid]+$lridrating;
	else
	 	$totalarray[$lrid] = $lridrating;
	if(array_key_exists($lrid,$numberofratings))
		$numberofratings[$lrid] = $numberofratings[$lrid]+1;
	else
		$numberofratings[$lrid] = 1;
}


$lrids = array_keys($numberofratings);

foreach($lrids as $lrid){
	$numrates = $numberofratings[$lrid];
	$averaged=round($totalarray[$lrid]/$numrates,3);
	$alreadythere = mysql_query("SELECT * FROM lrdailyratings WHERE lrid = '$lrid'");
	$row=mysql_fetch_array($alreadythere);
	if($row){
		echo"gothere";
		mysql_query("UPDATE lrdailyratings SET averating='$averaged', numrates='$numrates' WHERE lrid = '$lrid'");}
	else{
		echo"gothere2";
		mysql_query("INSERT INTO lrdailyratings(lrid, averating, numrates) VALUES ('$lrid','$averaged','$numrates')");
	    }

}


mysql_close();
?>
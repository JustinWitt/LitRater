<?php
$con = mysql_connect("localhost","root","BloVar3Kill");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("lrratertest", $con);

$result = mysql_query("SELECT * FROM lrauthorid");

while($row = mysql_fetch_array($result))
  {
  echo $row['authorid'] . " " . $row['firstname'] . " " . $row['middlename'] . " " . $row['middlename2'] . " " . $row['middlename3'] . " " . $row['lastname'] . " " . $row['suffix'];
  echo "<br />";
  }

mysql_close($con);
?> 
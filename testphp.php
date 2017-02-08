<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http=equiv="Content-Type" content="text/html; charset=utf-8"/>
<title> Simple PHP</title>
</head>
<body>
<?php
echo "test1";
echo "<br/>";
echo $_POST['author'];
echo "<br/>";
echo $_POST['title'];
echo "<br/>";
echo $_POST['genre'];
echo "<br/>";
echo $_POST['username'];
echo "<br/>";
echo $_POST['password'];
echo "<br/>";
echo "done test1";
echo "<br/>";
?>
</body>
</html>
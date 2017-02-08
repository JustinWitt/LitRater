<?php
header("Content-Type:application/octet-stream");
header("Content-Disposition:attachment;");
$fName = basename($_GET['file']);
fpassthru($fName);
?>

<?php
//uploadphp
//now to handle the uploaded file, oh boy
//limit file types to pdf, txt, doc, docx, epub, mobi, azw, opf, tr2, tr3, html, epub, fb2, pdb, prc, 

$title=$_POST['title'];
$title= strip_tags($title);
$title=addslashes($title);



$authornum = 0;
$keepgoing = 1;
while($keepgoing)
{
	$authornum++;
	$authorinc = "lastname" . $authornum;
	echo $authorinc;
	if(!isset($_POST[$authorinc]))
		$keepgoing = 0;

}
$authornum--;



echo $title . "<br/>";
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

echo $authorstring . "<br/>";

if ($_FILES['ufile']['size'] < 999999)
  {
	$filenamer = $_FILES['ufile']['name'];
	$fileext = pathinfo($filenamer,PATHINFO_EXTENSION);
	echo $fileext;
	if($fileext == "pdf" || $fileext == "txt" || $fileext == "docx" || $fileext == "epub" || $fileext == "mobi" || $fileext == "azw" || $fileext == "opf" || $fileext == "tr2" || $fileext == "tr3" || $fileext == "htm" || $fileext == "html" || $fileext == "fb2" || $fileext == "pdb" || $fileext == "prc"){
		echo "this is a type we like";
		}
	else
	echo "Not a type we like";

  }
else
  {
  echo "Invalid file";
  }

//end file size and type if
?>
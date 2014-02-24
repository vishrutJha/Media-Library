<?php
//upload.php
$type = $_REQUEST["type"];

$output_dir = "/use/share/nginx/www/misc";

if($type=="poster"){
	$output_dir = "/usr/share/nginx/www/media/posters/";
}else{
	$output_dir = "/usr/share/nginx/www/media/audio/";
}
 
if(isset($_FILES["file"]))
{

    include_once("aud_indexer.php");
    //Filter the file types , if you want.
    if ($_FILES["file"]["error"] > 0)
    {
      echo "Error: " . $_FILES["file"]["error"] . "<br>";
    }
    else
    {
        //move the uploaded file to uploads folder;
        move_uploaded_file($_FILES["file"]["tmp_name"],$output_dir. $_FILES["file"]["name"]);
 
     echo "Uploaded File :".$_FILES["file"]["name"];
     
     if($type!="poster"){
	indexFiles();
     }else{
	$path = "/media/posters/".$_FILES["file"]["name"];
	$title = $_FILES["file"]["name"];
	$type = $_REQUEST["poster_type"];
	indexPoster($title, $path, $type, NULL);
     }
    }
 
}
?>

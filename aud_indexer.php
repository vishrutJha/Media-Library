<?php

function indexFiles(){
$dir = "/usr/share/nginx/www/media/audio";
$serverLink = "media/audio";
$files = scandir($dir);

require_once ("libs/AdminUser.php");
require_once ("libs/audInfo.php");
require_once ("libs/mp3info.php");
$media = new Media();
$info = new AudInfo();

$result = $media->getAllAudio();
//var_dump($result);
	
foreach($files as $link) {
	if(strpos($link, "mp3")){ 
	  $fileLink = "$serverLink/$link";
	  $m = new mp3file($fileLink); 
	  $stuff = $m->get_metadata();

	  $info->getinfo($fileLink);
	  $time = "00:".$stuff["Length mm:ss"];
	  $querty = $media->addAudio($link, $fileLink, $info->artist, $info->album, NULL, NULL, $time);
	  if(!$querty){
//	  	echo $link;
	  }
		
	} 
} 

}


function indexPoster($title, $path, $type, $info){

require_once ("libs/AdminUser.php");
$media = new Media();

$result = $media->addPoster($title, $path, $type, $info);
var_dump($result);

}
?>

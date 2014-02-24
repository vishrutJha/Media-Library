<?php
$dir = "/usr/share/nginx/www/media/video";
$serverLink = "media/video";
$files = scandir($dir);

require_once ("libs/AdminUser.php");
require_once ("libs/flvinfo.php");

$media = new Media();

//$result = $media->getAllAudio();
//var_dump($result);
?>
<html>
<title>Media Library</title>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
</head>
<body class="mt">
<center><h3>This is how mucha video i give</h3>
<div class="container">
<table class="table table-striped table-bordered table-hover">
    <thead>
	<th>Title</th>
	<th>Director</th>
	<th>Type</th>
	<th>Release Date</th>
	<th>Path</th>
    </thead>
    <tbody>
	<?php foreach($files as $link) {
	if(strpos($link, "flv")){ 
	$fileLink = "$serverLink/$link";
//      $flvinfo = new FLVInfo();
//      $info = $flvinfo->getInfo($fileLink,true);

//	$m = new mp3file($fileLink); 
//	$stuff = $m->get_metadata();
//	$stuff = $vidfo->getMeta($fileLink);

//	$info->getinfo($fileLink); ?>
	<tr>
	    <td><?php $title = explode(".",$link); $title = $title[0]; echo $title; ?></td>
	    <td><?php $direct = explode(" ",$link); $direct = count($direct>7)?$direct[0]." ".$direct[1]." ".$direct[2]:$direct[0]; echo $direct;?></td>
	    <td><?php $type= "video"; echo $type; ?></td>
	    <td><?php $mod_date=date("Y-m-d", filemtime($fileLink)); echo $mod_date; ?></td>
	    <td><?php echo $fileLink; ?></td>
	</tr>
	<?php// var_dump($info->duration); ?>
	<?php
//	$time = "00:".$stuff["Length mm:ss"];
	$query = $media->addVideo($title, $fileLink, $type, "English", $direct, $mod_date, NULL, NULL, NULL);
//	$querty = $media->addAudio($link, $fileLink, $info->artist, $info->album, NULL, NULL, $time);
//	if(!$querty){
//		echo $link;
//	}
		
	 } } ?>
    </tbody>
</table>
</div>
</center>
</html>

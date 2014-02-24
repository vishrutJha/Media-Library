<?php

require_once ("libs/AdminUser.php");
require_once ("libs/audInfo.php");
require_once ("libs/mp3info.php");

$type = $_REQUEST["type"];
$id = $_REQUEST["id"];

if($type == "" || $id == ""){
	echo "error! invalid params";
	return;
}

$media = new Media();

if($type == "video"){
	$data = $media->getVideoById($id);
	$response->video = $data[0];
	$response->related = $media->getRelatedVideo($data[0]["director"], $data[0]["title"]);
	$response->audio = $media->getRelatedAudio($data[0]["director"], $data[0]["title"]);

	echo json_encode($response);
	return;
}

if($type == "poster"){

	$data = $media->getPosterById($id);
	$response->poster = $data[0];
	$response->video = $media->getRelatedVideo($data[0]["title"],$data[0]["title"]);
	$response->audio = $media->getRelatedAudio($data[0]["title"], $data[0]["title"]);
	$response->related = $media->getRelatedPosters($data[0]["title"], $data[0]["title"]);

	echo json_encode($response);
	return;

}

$data = $media->getAudioById($id);
$data = $data[0];

$response->track = $data;

$artistData = $media->getAudioByArtist($data["artist"]);
$albumData = $media->getAudioByAlbum($data["album"]);
$relatedVid = $media->getRelatedVideo($data["artist"],$data["album"]);
$relatedPost = $media->getRelatedPosters($data["artist"],$data["album"]);
error_log(json_encode($relatedPost));

$response->artist = $artistData;
$response->album = $albumData;
$response->videos = $relatedVid;
$response->gallery = $relatedPost;

//$relatedAudio = $media->getRelatedVideo($data["title"], $data["artist"]);
$data["artist"] = rtrim($data["artist"]);
$artSearch = urlencode($data["artist"]);

$pathinit = "/media/posters/$artSearch.jpg";
$poster = $pathinit;

if(!file_get_contents("/usr/share/nginx/www$poster")){
	$art = file_get_contents("https://itunes.apple.com/search?term=$artSearch&limit=3");
	$results = json_decode($art);
	$results = $results->results;
	
	$poster = $results[0]->artworkUrl100;
	$poster = str_replace("100x100","600x600",$poster);
	
	$saveImage = file_get_contents($poster);
	$fileout = "/usr/share/nginx/www/media/posters/".htmlentities($artSearch).".jpg";
	$stat = file_put_contents($fileout, $saveImage);
}

if(!$data["album_art"]){
	$media->addPosterToAudio($data["title"],$id,$pathinit);
}

$response->poster = $poster;
 //Debug area
/*echo "<pre>";
var_dump($data);
echo "<br>";
var_dump($results);
/*var_dump($relData);
echo "<br>";
var_dump($albumData); */
//echo "</pre>"; 
//$data = json_encode($data);
header('Content-Type: application/json');
print json_encode($response);
?>

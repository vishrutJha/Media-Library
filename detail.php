<html>
<head>
<title>Gallery</title>
<link rel="icon" href="static/icons/9-av-play-over-video.png" type="image/png" />
</head>
<?php
include "header.php";

$type = $_REQUEST["type"];
$id = $_REQUEST["id"];

if($type == "video"){
	header("location: video_detail.php?id=$id");
}

$media = new Media();
$data = $media->getAudioById($id);
$data = $data[0];

$relData = $media->getAudioByArtist($data["artist"]);
$albumData = $media->getAudioByAlbum($data["album"]);
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
 //Debug area
/*echo "<pre>";
var_dump($data);
echo "<br>";
var_dump($results);
/*var_dump($relData);
echo "<br>";
var_dump($albumData); */
echo "</pre>"; 
?>

<body style="margin-top:120px">

<input type="hidden" id="elementCount" value="<?php echo count($relData);?>" >

<div class="jumbotron">
<center>
  <h1>Audio Gallery</h1>
  <p id="nowplaying"> Now Playing.. <?php echo $data["title"]; ?></p>
  <video controls autoplay poster="<?php echo htmlentities($poster);?>" height="300px" id="gallery-player">
	<source src="<?php echo $data["path"]; ?>" type="audio/mpeg" \>
  </video>
  <div class="span1"><button onclick="playnext()">Next</button></div>
</center>
</div>


<div class="show-grid">
  <div class="col-md-8">
    <div class="panel panel-primary">
	<div class="panel-heading"><h4>From this Artist</h4></div>
	<div class="panel-body">
		<div class="list-group">
		    <?php $i=0;	
		    foreach($relData as $item){ ?>
			<div onclick="changeContent('<?php echo $item["path"]; ?>');" class="list-group-item"><?php echo $item["title"]; ?></div>
			<input id="artlist<?php echo $i++;?>" type="hidden" value="<?php echo $item["path"]; ?>">
		    <?php } ?>
		</div>
	</div>
    </div>

    <div class="panel panel-success">
	<div class="panel-heading"><h4>From this Album</h4></div>
	<div class="panel-body">
		<div class="list-group">
		    <?php $i=0;
		    foreach($albumData as $item){ ?>
			<div onclick="changeContent('<?php echo $item["path"]; ?>');" class="list-group-item"><?php echo $item["title"]; ?></div>
			<input id="albumlist<?php echo $i++;?>" type="hidden" value="<?php echo $item["path"]; ?>">
		    <?php } ?>
		</div>
	</div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="panel panel-danger">
	<div class="panel-heading"><h4>Related Media</h4></div>
	<div class="panel-body">
		<div class="list-group">
		    <?php for($related=0; $related<10;$related++) { ?>
			<a onclick='launchDetails("<?php echo $related; ?>")' class="list-group-item"><?php echo $related; ?></a>
		    <?php } ?>
		</div>
	</div>
    </div>
  </div>	
</div>
</body>
<script>
$(document).ready(function() {
	setElementCount('audio');
	player = document.getElementById('gallery-player');
	player.addEventListener('ended', playnext, true);
});
</script>

</html>

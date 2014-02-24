<html>
<head>
<title>Gallery</title>
<link rel="icon" href="static/icons/9-av-play-over-video.png" type="image/png" />
<link href="http://vjs.zencdn.net/4.0/video-js.css" rel="stylesheet">
<script src="http://vjs.zencdn.net/4.0/video.js"></script>
</head>
<?php
include "header.php";

$type = $_REQUEST["type"];
$id = $_REQUEST["id"];


$media = new Media();
$data = $media->getVideoById($id);
$data = $data[0];

//Debug area
echo "<pre>";
var_dump($data);
echo "<br>";
echo "</pre>";
?>

<body style="margin-top:120px">

<input type="hidden" id="elementCount" value="<?php echo count($relData);?>" >

<div class="jumbotron">
<center>
  <h1>Video Gallery</h1>
  <p id="nowplaying"> Now Playing.. <?php echo $data["title"]; ?></p>
  <video controls autoplay height="400px" width="800px"  id="gallery-player">
	<source src="palyfile.mp4" type="video/mp4" \>
  </video>
  <div class="span1"><button onclick="playnext()">Next</button></div>
</center>
</div>


<div class="show-grid">
  <div class="col-md-8">
    <div class="panel panel-primary">
	<div class="panel-heading"><h4>From this Artist</h4></div>
	<div class="panel-body">

	</div>
    </div>

    <div class="panel panel-success">
	<div class="panel-heading"><h4>From this Album</h4></div>
	<div class="panel-body">

	</div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="panel panel-danger">
	<div class="panel-heading"><h4>Related Media</h4></div>
	<div class="panel-body">

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

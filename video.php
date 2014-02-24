<html>
<?php

$page = "video";
include "header.php";
$media = new Media();

$result = $media->getAllVideo();
?>
<head>
  <!-- Chang URLs to wherever Video.js files will be hosted -->
  <link href="static/video-js/video-js.css" rel="stylesheet" type="text/css">
  <!-- video.js must be in the <head> for older IEs to work. -->
  <script src="static/video-js/video.js"></script>

  <!-- Unless using the CDN hosted version, update the URL to the Flash SWF -->
  <script>
    videojs.options.flash.swf = "static/video-js/video-js.swf";
  </script>

</head>

<title>Media Library</title>

<body class="mt" style="margin-top:150px">

<div class="tabbable tabs-left">
  <ul class="nav nav-pills" style="background-color:#fff; opacity:0.8">
    <li class="active"><a id="tab_1" href="#tab1" data-toggle="tab">Video Library</a></li>
    <li><a id="tab_2" href="#tab2" data-toggle="tab">Now Showing</a></li>
  </ul>

  <div class="tab-content">
    <div class="tab-pane active" id="tab1">
	<center>
	<div class="container" style="margin:20px; background-color:#fff; opacity:0.9; border-radius:10px;">
	    <h3>This is how mucha video i give</h3>

	    <div class="panel panel-default">
	    <div class="panel-heading"><h4>Videos in Library</h4></div>
	    
	    <div class="panel-body"><p>Select a Video to Launch Gallery or Add to player</p></div>
	    <table class="table table-striped table-bordered table-hover" id="video-table">
	    <thead>
		<th>Video Name</th>
		<th>Artist</th>
		<th>Type</th>
		<th>Language</th>
	    </thead>
	    <tbody>
		<?php foreach($result as $link) { ?>
		<tr onclick="playVideo(<?php echo $link['id'];?>);">
			<td><?php echo $link["title"]; ?></td>
			<td><?php echo $link["director"]; ?></td>
			<td><?php echo $link["type"]; ?></td>
			<td><?php echo $link["language"]; ?></td>
		</tr>
		<?php } ?>
	    </tbody>
	    </table>

	    </div>
	</div>
	</center>
    </div>

    <div class="tab-pane" id="tab2">
	<div class="player">
	<div class="jumbotron" style="opacity:1;background-color:black">
	<center>
	  <h1>Video Gallery</h1>
	  <p id="nowplaying"> Waiting for video selection </p>
	  <video class="video-js vjs-default-skin" controls autoplay poster="" height="600px" width="800px" id="gallery-player" data-setup="{}">
		<source src="" type="video/flv" \>
	  </video>
	  <div class="row-fluid mt">
		  <div class="span1"><button onclick="playnextvideo()">Next</button></div>
	  </div>
	</center>
	</div>


	<div class="show-grid">
	  <div class="col-md-8">
	    <div class="panel panel-primary">
		<div class="panel-heading"><h4>Related Videos</h4></div>
		<div class="panel-body">
			<div class="list-group" id="related-videos">
			
			</div>
		</div>
	    </div>
	  </div>

  	  <div class="col-md-4">
	    <div class="panel panel-danger">
		<div class="panel-heading"><h4>Related Music</h4></div>
		<div class="panel-body">
			<div class="list-group" id="related-audio"> 
				
			</div>
		</div>
	    </div>
	  </div>	
	</div>

	</div>
    </div>
  </div>
</div>


<script>
$(document).ready(function() {

	<?php if(isset($_REQUEST["id"])){ ?>
		playVideo(<?php echo $_REQUEST["id"]; ?>);
	<?php } ?>

	$('#video-table').dataTable({
		"bPaginate":true,
		"bStateSave":true,
		"sPaginationType":"full_numbers",
		"fnStateSave": function (oSettings, oData) {
	              localStorage.setItem( 'DataTables_'+window.location.pathname, JSON.stringify(oData) );
        	},
	        "fnStateLoad": function (oSettings) {
                	return JSON.parse( localStorage.getItem('DataTables_'+window.location.pathname) );
             	}
	});
});
</script>
</body>
</html>

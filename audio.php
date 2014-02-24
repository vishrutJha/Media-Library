<html>
<?php

$page = "audio";
include "header.php";
$media = new Media();
$info = new AudInfo();

$result = $media->getAllAudio();
?>
<head>
<link rel="stylesheet" href="static/css/flexslider.css" type="text/css" media="screen"/>
<style>
form { display: block; margin: 20px auto; background: #eee; border-radius: 10px; padding: 15px }
#progress { position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
#bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
#percent { position:absolute; display:inline-block; top:3px; left:48%; }
</style>
</head>
<title>Media Library</title>

<body class="mt" style="margin-top:150px">

<div class="tabbable tabs-left">
  <ul class="nav nav-pills" style="background-color:#fff; opacity:0.8">
    <li class="active"><a id="tab_1" href="#tab1" data-toggle="tab">Music Library</a></li>
    <li><a id="tab_2" href="#tab2" data-toggle="tab">Now Playing</a></li>
  </ul>

  <div class="tab-content">
    <div class="tab-pane active" id="tab1">
	<center>
	<div class="container" style="margin:20px; background-color:#fff; opacity:0.9; border-radius:10px;">
	    <h3>Select Music to add to playlist</h3>

	    <div class="panel panel-default">
	    <div class="panel-heading"><h4>Songs in Library</h4></div>
	    
	    <div class="panel-body"><p>Select a song to Launch Gallery or Add to player</p></div>
	    <table class="table table-striped table-bordered table-hover" id="audio-table">
	    <thead>
		<th>Song Name</th>
		<th>Artist</th>
		<th>Album</th>
		<th>Duration</th>
	    </thead>
	    <tbody>
		<?php foreach($result as $link) { ?>
		<tr onclick="playSong(<?php echo $link['id'];?>);">
			<td><?php echo $link["title"]; ?></td>
			<td><?php echo $link["artist"]; ?></td>
			<td><?php echo $link["album"]; ?></td>
			<td><?php echo $link["duration"]; ?></td>
		</tr>
		<?php } ?>
	    </tbody>
	    </table>

	    </div>
	</div>

	<div class="panel">
	    <h4>Upload a new file to index to DB here</h4>
	    <form id="myForm" action="upload.php" method="post" enctype="multipart/form-data">
	        <input type="file" size="60" name="file">
	    	<input type="submit" value="Ajax File Upload">
	    </form>	
	 
	    <div id="progress">
	    	<div id="bar"></div>
	        <div id="percent">0%</div >
	    </div>
	    <br/>
	    <div id="message"></div>
	</div>
	</center>
    </div>

    <div class="tab-pane" id="tab2">
	<div class="player">
	<div class="jumbotron" style="opacity:0.8;">
	<center>
	  <h1>Audio Gallery</h1>
	  <p id="nowplaying"> Waiting for song selection </p>
	  <video controls autoplay poster="" height="300px" id="gallery-player">
		<source src="" type="audio/mpeg" \>
	  </video>
	  <div class="row-fluid mt">
		  <div class="span1"><button onclick="playnext()">Next</button></div>
	  </div>
	</center>
	</div>


	<div class="show-grid">
	  <div class="col-md-8">
	    <div class="panel panel-primary">
		<div class="panel-heading"><h4>From this Artist</h4></div>
		<div class="panel-body">
			<div class="list-group" id="artist_songs">
			
			</div>
		</div>
	    </div>

	    <div class="panel panel-success">
		<div class="panel-heading"><h4>From this Album</h4></div>
		<div class="panel-body">
			<div class="list-group" id="album_songs">

			</div>
		</div>
	    </div>
	  </div>

	  <div class="col-md-4">
	    <div class="panel panel-danger">
		<div class="panel-heading"><h4>Related Media</h4></div>
		<div class="panel-body">
			<h4>Videos</h4>
			<div class="list-group" id="related-videos"> 
				
			</div>
		</div>
	    </div>
	  </div>	
	</div>

	
	<div class="col-md-8">
	  <div class="panel panel-info">
	  <div class="panel-heading"><h4>Posters</h4></div>
	  <div class="panel-body">
	    <div class="flexslider">
		<ul class="slides" id="related-posters">
  
  		</ul>
	    </div>
	  </div>
	  </div>
	  </div>
	</div>

	</div>
    </div>
  </div>
</div>
	
<script defer src="static/js/jquery.flexslider.js"></script>
<script src="static/js/jquery.form.js"></script>
<script>
$(document).ready(function() {

	<?php if(isset($_REQUEST["id"])){ ?>
		playSong(<?php echo $_REQUEST["id"]; ?>);
	<?php } ?>

	$('#audio-table').dataTable({
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

    var options = {
    beforeSend: function()
    {
        $("#progress").show();
        //clear everything
        $("#bar").width('0%');
        $("#message").html("");
        $("#percent").html("0%");
    },
    uploadProgress: function(event, position, total, percentComplete)
    {
        $("#bar").width(percentComplete+'%');
        $("#percent").html(percentComplete+'%');
 
    },
    success: function()
    {
        $("#bar").width('100%');
        $("#percent").html('100%');
 
    },
    complete: function(response)
    {
        $("#message").html("<font color='green'>"+response.responseText+"</font>");
    },
    error: function()
    {
        $("#message").html("<font color='red'> ERROR: unable to upload files</font>");
 
    }
 
};
 
     $("#myForm").ajaxForm(options);
 
});

var player = document.getElementById("gallery-player");

player.onended = function(e){
	playnext();		
}

</script>
</body>
</html>

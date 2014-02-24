<html>
<?php

$page = "poster";
include "header.php";
$media = new Media();

$result = $media->getAllPosters();
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
    <li class="active"><a id="tab_1" href="#tab1" data-toggle="tab">Poster Library</a></li>
    <li><a id="tab_2" href="#tab2" data-toggle="tab">Gallery</a></li>
  </ul>

  <div class="tab-content">
    <div class="tab-pane active" id="tab1">
	<center>
	<div class="container" style="margin:20px; background-color:#fff; opacity:0.9; border-radius:10px;">
	    <h3>Select Poster to View in Gallery</h3>

	    <div class="panel panel-default">
	    <div class="panel-heading"><h4>Posters in Library</h4></div>
	    
	    <div class="panel-body"><p>Select a song to Launch Gallery or Add to player</p></div>
	    <table class="table table-striped table-bordered table-hover" id="audio-table">
	    <thead>
		<th>Title</th>
		<th>Type</th>
		<th>Thumbnail</th>
	    </thead>
	    <tbody>
		<?php foreach($result as $link) { ?>
		<tr onclick="launchGallery(<?php echo $link['id'];?>);">
			<td><?php echo $link["title"]; ?></td>
			<td><?php echo $link["type"]; ?></td>
			<td><img src="<?php echo $link["path"]; ?>" height="100px"></img></td>
		</tr>
		<?php } ?>
	    </tbody>
	    </table>

	    </div>
	</div>

	<div class="panel">
	    <h4>Upload a new file to index to DB here</h4>
	    <form id="myForm" action="upload.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="type" value="poster">
		<select name="poster_type">
		  <option value="audio">Audio</option>
		  <option value="movie">Movie</option>
		  <option value="picture">Picture</option>
		  <option value="video">Video</option>
		</select> 
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
	<div class="jumbotron">
	<center>
	  <div id="slider" class="flexslider">
		<ul class="slides" id="poster-thumb">
  
  		</ul>
	  </div>

	  <div id="carousel" class="flexslider">
		<ul class="slides" id="posters">
  
  		</ul>
	  </div>

	</center>
	</div>


	<div class="show-grid">
	  <div class="col-md-8">
	    <div class="panel panel-primary">
		<div class="panel-heading"><h4>Related Music</h4></div>
		<div class="panel-body">
			<div class="list-group" id="related-audio">
			
			</div>
		</div>
	    </div>

	    <div class="panel panel-success">
		<div class="panel-heading"><h4>Related Videos</h4></div>
		<div class="panel-body">
			<div class="list-group" id="related-videos">

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
		showPoster(<?php echo $_REQUEST["id"]; ?>);
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

</script>
</body>
</html>

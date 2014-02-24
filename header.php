<?php 
//Reserved for sessions
require_once ("libs/AdminUser.php");
require_once ("libs/audInfo.php");
require_once ("libs/mp3info.php");
?>
    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Media Library</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li <?php if($page =="audio") { echo 'class="active"';}?>><a href="audio.php">Audio</a></li>
            <li <?php if($page == "video"){ echo 'class="active"';}?>><a href="video.php">Video</a></li>
            <li <?php if($page == "poster"){ echo 'class="active"';}?>><a href="poster.php">Posters</a></li>
<!--	    <li <?php if($page == "lyrics"){ echo 'class="active"';}?>><a href="lyrics.php">Lyrics</a></li> -->
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

<head>
<!-- Action script for the page -->
<script src="static/js/jquery.js"></script>
<script src="static/js/actions.js"></script>
<script src="static/js/jquery.dataTables.js"></script>

<!-- Custom StyleSheets -->
<link rel="stylesheet" href="static/css/jquery.dataTables_themeroller.css">
<link rel="stylesheet" href="static/css/jquery.dataTables.css">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="static/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="static/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="static/js/bootstrap.min.js"></script>
<style>

	body {
		background-image:url('background.jpg');
		background-repeat:no-repeat;
		background-attachment:fixed;
	}

        .table th.centered-cell, .table td.centered-cell {
            text-align: center;
        }

        .dataTables_filter {
            white-space:nowrap;
            position:absolute;
            left:56%;
        }

        .dataTables_filter label, .dataTables_filter input {
            display: inline-block;
        }

</style>

</head>

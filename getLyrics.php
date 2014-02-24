<?php 


$song = urlencode($_REQUEST["song"]);
$artist = urlencode($_REQUEST["artist"]);

$pathInit = "/usr/share/nginx/www/media/text/".htmlentities("$artist $song").".txt";

if(!file_get_contents($pathInit)){

	include_once("libs/AdminUser.php");
	include_once("htmlToText.php");

	$url =  "http://lyrics.wikia.com/api.php?func=getSong&artist=$artist&song=$song&fmt=xml";

	echo "sending request to $url";
	$content = file_get_contents($url);

	$data = new SimpleXMLElement($content);

	$delimiter = "http://www.ringtonematcher.com/co/ringtonematcher/02/noc.asp?";
	$lyrics = file_get_contents($data->url);
	$things = explode($delimiter, $lyrics);
	$delim2 = "Send \"Until The End\" Ringtone to your Cell";
	$things = explode($delim2, $things[1]);
	$text = $things[1];

	$text = convert_html_to_text($text);

	$fileout = $pathInit;
	$stat = file_put_contents($fileout, strval($text));

	/*
	echo "<pre>";
	print_r($text);
	echo "</pre>";*/
} else {

	return $pathInit;
}


?>

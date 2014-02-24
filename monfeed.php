<?php

$m=new MongoClient();
$db=$m->facelogs;
$coll=$db->logs;
$cur=$coll->find();

$counts = 0;

$data = $_REQUEST["data"];

$content = json_decode($data);

$item = $content;
$person = $item[0];
$movies = $item[1];
$music = $item[2];

$senData->person = $person;
$senData->movies = $movies;
$senData->music = $music;
//foreach($person as $item){
//$item->id = $person[0]["id"];
//$item->name = $person[0]["name"];
//$item->movies = $person[1];

echo "<pre>";
var_dump($item);
echo "</pre>";

$result = $coll->find($senData);

foreach($result as $data){
	$counts++;	
}

if($counts>0){
	echo "Data already in db";
} else {
$toPut = $senData;

$res = $coll->insert($toPut);
var_dump( $res);
}

//}
?>

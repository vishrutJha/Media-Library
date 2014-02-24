<!DOCTYPE html>
<html>
<head></head>
<body>
<?php

$m=new MongoClient();
$db=$m->facelogs;
$coll=$db->logs;
$cur=$coll->find();

$counts = 0;

$data = $_REQUEST["data"];

$person = json_decode($data);

$item = $person;
//foreach($person as $item){
//$item->id = $person[0]["id"];
//$item->name = $person[0]["name"];
//$item->movies = $person[1];

echo "<pre>";
var_dump($item);
echo "</pre>";

$result = $coll->find($item);

foreach($result as $data){
	$counts++;	
}

if($counts>0){
	echo "Data already in db";
} else {
$toPut = $item;

$res = $coll->insert($toPut);
var_dump( $res);
}

//}
?>
</body>
</html>

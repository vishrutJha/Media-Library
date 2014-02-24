<?php

/*
*  Use of this api:
*  call the api through ajax with parameter person's ID eg:  monget.php?id=526598250
*	returns the array of people who have similar interests to the requested person
*  LIMIT: the person requested should be in the db:: make a dbfeed with the person before calling this to be sure
*/

session_start();
$user = $_SESSION["cur_user"];

//var_dump($user);

$m=new MongoClient();
$db=$m->facelogs;
$coll=$db->logs;

$cur=$coll->findOne(array("person.id"=>$user->id));


//echo "<pre>";

$movies = $cur["movies"];
$movies = $movies["movies"];
$music = $cur["music"]["music"];

$mov_results = array();

foreach($movies as $intr){
	$stuff = $coll->find(array("movies.movies"=>$intr));
	while($elem = $stuff->getNext()){
		$mov_results[] = $elem;
	}
}

$muz_results = array();

foreach($music as $intr){
	$stuff = $coll->find(array("music.music"=>$intr));
	while($elem = $stuff->getNext()){
		$muz_results[] = $elem;
	}
}

$result = array();
$friends = array();

foreach($mov_results as $person){
	if($friends[$person["person"]["name"]]==NULL){
		$friends[$person["person"]["name"]] = $person;
//		var_dump($person["person"]);
		$result[] = $person;
	}
}


foreach($muz_results as $person){
	if($friends[$person["person"]["name"]]==NULL){
		$friends[$person["person"]["name"]] = $person;
//		var_dump($person["person"]);
		$result[] = $person;
	}
}

//echo "</pre>";

echo json_encode($result);

?>

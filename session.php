<?php

session_start();

//var_dump($_REQUEST);

$data = $_REQUEST["data"];

$data = json_decode($data);

$usr_detail = $data->user;

//var_dump($usr_detail);

if(isset($_SESSION["cur_user"])){
	
	$temp = $_SESSION["cur_user"];

	if(!isset($_REQUEST["data"])){
		echo "current user: $temp->name";
		return;
	}

	if($temp->id == $usr_detail->id){
		echo "current user is:";
	        echo $temp->name;
	}else{

		if(isset($_REQUEST["data"])){
		        $_SESSION["cur_user"] = $usr_detail;
			echo "user set!";
		}else{
			echo "No user provided";
		}
	}
} else {
	if(isset($_REQUEST["data"])){
	        $_SESSION["cur_user"] = $usr_detail;
		echo "user set!";
	}else{
		echo "No user provided";
	}
}

?>


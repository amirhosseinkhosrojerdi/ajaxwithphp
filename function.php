<?php
define('SITE_ROOT', realpath(dirname(__FILE__)));
function upload_image(){
	if(isset($_FILES['userimage'])){
		$extention = explode('.', $_FILES['userimage']['name']);
		$new_name = rand().'.'.$extention[1];
		if(!file_exists('upload')){
			mkdir('upload', 0777, true);
		}
		$destination = '/upload/'.$new_name;
		move_uploaded_file($_FILES['userimage']['tmp_name'], SITE_ROOT.$destination);
		return $new_name;
	}
}

function get_total_all_records(){
	include ('db.php');
	$query = "SELECT * FROM `users`";
	$result = $connection->prepare($query);
	$result->execute();
	$row = $result->fetchAll();
	return $result->rowCount();
}

function get_image_name($user_id){
	include ('db.php');
	$query = "SELECT `image` FROM `users` WHERE id = '$user_id'";
	$result = $connection->prepare($query);
	$result->execute();
	$row = $result->fetchAll();
	foreach ($row as $rows) {
		return $rows["image"];
	}
}
<?php
include ('db.php');
include ('function.php');

if(isset($_POST["user_id"])){
	$image = get_image_name($_POST["user_id"]);
	if($image != ''){
		unlink("upload/".$image);
	}
	$query = "DELETE FROM `users` WHERE id =:id";
	$result = $connection->prepare($query);
	$result->bindParam(':id', $_POST['user_id']);
	$execute = $result->execute();
	if($execute){
       	echo "data success delete.";
    }else{
        echo "data faild delete.";
    }
}
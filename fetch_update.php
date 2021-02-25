<?php
include ('db.php');
include ('function.php');

if(isset($_POST['user_id'])){
	$query = "SELECT * FROM `users` WHERE id = '".$_POST["user_id"]."' LIMIT 1";
	$output = array();
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach ($result as $row) {
		$output["firstname"] = $row["firstname"];
		$output["lastname"] = $row["lastname"];
		$output["email"] = $row["email"];
		$output["age"] = $row["age"];
		if($row["image"]!=''){
		$output['user_image'] = '<img src="upload/'.$row["image"].'" class ="img-thumbnail" width="50" height="35" /><input type="hidden" name="hidden_user_image" value = "'.$row["image"].'" />';
		}
		else{
			$output['user_image'] = '<input type="hidden" name="hidden_user_image" value = "" />';
		}
	}
	echo json_encode($output);
}
<?php
include('db.php');
include('function.php');

if(isset($_POST['operation'])){
	//add user
	if($_POST['operation'] == 'Add'){
		$image = '';
		if($_FILES['userimage']['name'] != ''){
			$image = upload_image();
		}
		$query = "INSERT INTO `users`(`id`, `firstname`, `lastname`, `image`, `email`, `age`) VALUES (NULL, :firstname, :lastname, :image, :email, :age)";
		$result = $connection->prepare($query);
		$result->bindParam(':firstname', $_POST['firstname']);
		$result->bindParam(':lastname', $_POST['lastname']);
		$result->bindParam(':image', $image);
		$result->bindParam(':email', $_POST['email']);
		$result->bindParam(':age', $_POST['age']);
		$execute = $result->execute();
        if($execute){
        	echo "data success inserted.";
        }else{
        	echo "data faild inserted.";
        }
	}

	//edit user
	if($_POST['operation'] == 'Edit'){
		$image = '';
		if($_FILES['userimage']['name'] != ''){
			$image = upload_image();
		}else{
			$image = $_POST["hidden_user_image"];
		}
		$query = "UPDATE `users` SET `firstname`='".$_POST["firstname"]."',`lastname`='".$_POST["lastname"]."',`image`='".$image."',`email`='".$_POST["email"]."',`age`='".$_POST["age"]."' WHERE `id`='".$_POST["user_id"]."'";
		$result = $connection->prepare($query);
		// $result->bindParam(':firstname', $_POST['firstname']);
		// $result->bindParam(':lastname', $_POST['lastname']);
		// $result->bindParam(':image', $image);
		// $result->bindParam(':email', $_POST['email']);
		// $result->bindParam(':age', $_POST['age'], PDO::PARAM_INT);
		// $result->bindParam(':id', $_POST['user_id'], PDO::PARAM_INT);
		$execute = $result->execute();
        if($execute){
        	echo "data success updated.";
        }else{
        	echo "data faild updated.";
        }
	}
}
<?php
include ('db.php');
include ('function.php');

$query = "SELECT * FROM `users`";
$output = array();
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filter_row = $statement->rowCount();
$counter = 1;
foreach ($result as $row) {
	$image = '';
	if($row['image'] != ''){
		$image="<a href='upload/".$row["image"]."' target='_blank'><img src='upload/".$row["image"]."' class='img-thumbnail' width='50px' height='35px' /></a>";
	}else{
		$image = '';
	}
	$sub_array = array();
	$sub_array[] = $counter++;
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["email"];
	$sub_array[] = $row["age"];
	$sub_array[] = $image;
	$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-primary btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Delete</button>';

	$data[] = $sub_array;
}
$output = array(
	"draw" => intval($_POST["draw"]),
	"recordsTotal" => $filter_row,
	"recordsFiltered" => get_total_all_records(),
	"data" => $data
);
echo json_encode($output);
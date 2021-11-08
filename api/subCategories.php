<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include "../config/connection.php";

// $mainCatID = $_GET['ID'];

// $sql = "SELECT * FROM subcategories WHERE CatID='mainCatID' AND  Publish='Yes'";
$sql = "SELECT * FROM subcategories WHERE  Publish='Yes'";

$result = mysqli_query($link, $sql) or die("SQL Query Failed.");

if (mysqli_num_rows($result) > 0) {
	$output = mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo json_encode($output);
} else {
	echo json_encode(array('message' => 'Data Not Found'));
}
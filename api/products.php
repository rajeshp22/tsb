<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include "../config/connection.php";

$sql = "SELECT * FROM product_master WHERE  Publish='Yes'";
$result = mysqli_query($link, $sql) or die("SQL Query Failed.");

if (mysqli_num_rows($result) > 0) {
	$output = mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo json_encode($output);
} else {
	echo json_encode(array('message' => '0'));
}

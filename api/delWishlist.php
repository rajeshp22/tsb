<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"), true);

session_start();
include "../config/connection.php";

$newDelID = $_GET['DID'];
$newUserCode = myDecode($_GET['NID']);

//Find Email ID
$query_1=mysqli_query($link, "SELECT * FROM registrations WHERE ID='$newUserCode'");
$view_1=mysqli_fetch_array($query_1);
$newUserEmail=$view_1['UserEmail'];

$query_2=mysqli_query($link, "DELETE FROM wishlist_products WHERE UserEmail='$newUserEmail' AND ServiceID='$newDelID'");

if($query_2){
    echo json_encode(array('message'=> '1'));
}else{
    echo json_encode(array('message'=> '0'));
}
?>
<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"), true);

session_start();
include "../config/connection.php";

$newUserCode = myDecode($data['txtCID']);
$newSID = $data['txtSID'];
$newDate = $data['txtDate'];
$newTime = $data['txtTime'];

//Find Email ID
$query_1=mysqli_query($link, "SELECT * FROM registrations WHERE ID='$newUserCode'");
$view_1=mysqli_fetch_array($query_1);
$newUserEmail=$view_1['UserEmail'];

//Check Existing Cart ID
$query_cartID=mysqli_query($link, "SELECT * FROM cart_shopping_temp WHERE UserEmail='$newUserEmail'");
$view_cartID=mysqli_num_rows($query_cartID);
if($view_cartID==0)
{
    //Generate Unique Cart ID
    $cartID = generate_uuid();
}
else{
    //Fetch Existing Cart ID
    $query_getCartID=mysqli_query($link, "SELECT * FROM cart_shopping_temp WHERE UserEmail='$newUserEmail'");
    $view_getCartID=mysqli_fetch_array($query_getCartID);
    $cartID = $view_getCartID['CartID'];
}

//Check Duplicate Entry
$query_2=mysqli_query($link, "SELECT * FROM cart_shopping_temp WHERE UserEmail='$newUserEmail' AND ServiceID='$newSID' AND ServiceDate='$newDate' AND ServiceTime='$newTime'");
$chk_rows = mysqli_num_rows($query_2);

if($chk_rows==0){
    $query_3=mysqli_query($link, "INSERT INTO cart_shopping_temp SET UserEmail='$newUserEmail', CartID='$cartID', UserID='$newUserCode', ServiceID='$newSID', CartDate=now(), ServiceDate='$newDate', ServiceTime='$newTime', ServiceStatus='New'");
    if($query_3){
        //Remove from wishlist
        $query_4=mysqli_query($link, "DELETE FROM wishlist_products WHERE UserEmail='$newUserEmail' AND ServiceID='$newSID'");
        echo json_encode(array('message'=> '1'));
    }else{
        echo json_encode(array('message'=> '2'));
    }
}else{
    echo json_encode(array('message'=> '3'));
}

///Function for Unique ID
function generate_uuid() {
    return sprintf( '%04x-%04x-%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0C2f ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0x2Aff ), mt_rand( 0, 0xffD3 ), mt_rand( 0, 0xff4B )
    );
}
?>


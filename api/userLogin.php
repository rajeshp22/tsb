<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"), true);

$newUser = $data['txtUser'];
$newPass = $data['txtPass'];
$checkPass = md5($newPass);

session_start();
include "../config/connection.php";

//Check User's Email
$query_0 = mysqli_query($link, "SELECT * FROM registrations WHERE Email='$newUser'");
$num_rows = mysqli_num_rows($query_0);

if ($num_rows == 0) {
   //Email not found
   echo json_encode(array('message' => '0'));
} else {
   //Check User's Credentials
   $query_1 = mysqli_query($link, "SELECT * FROM registrations WHERE Email='$newUser'");
   $view_1 = mysqli_fetch_array($query_1);
   $newUserPass = $view_1['Password'];
   $numUnique = sprintf("%06d", mt_rand(1, 999999));
   $numEncode = myEncode($numUnique);

   //Check Password
   if ($checkPass != $newUserPass) {
      //Wrong Password
      echo json_encode(array('message' => '1'));
   } else {
      //Start User Session
      //$_SESSION['JCAUser']=$numEncode;
      $query_2 = mysqli_query($link, "UPDATE registrations SET UserToken='$numUnique' WHERE Email='$newUser'");
      echo json_encode(array('message' => '2', 'token' => $numEncode));
   }
}

<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"), true);

$fname = $data['txtNameF'];
$lname = $data['txtNameL'];
$email = $data['txtEmail'];
$mobile = $data['txtMobile'];

include "../config/connection.php";

$sqlEmail = "SELECT * FROM registrations WHERE  Email='$email'";
$resultEmail = mysqli_query($link, $sqlEmail) or die("SQL Query Failed.");

if (mysqli_num_rows($resultEmail) > 0) {
    echo json_encode(array('message' => 'ErrEmail'));
} else {
    $sqlMobile = "SELECT * FROM registrations WHERE  Mobile='$mobile'";
    $resultMobile = mysqli_query($link, $sqlMobile) or die("SQL Query Failed.");
    if (mysqli_num_rows($resultMobile) > 0) {
        echo json_encode(array('message' => 'ErrMobile'));
    } else {
        $sql = "INSERT INTO registrations(FirstName, LastName, Email, Mobile, RegDate, Valid) VALUES ('{$fname}', '{$lname}', '{$email}', '{$mobile}', now(), 'Yes')";
        if (mysqli_query($link, $sql)) {
            echo json_encode(array('message' => '1'));
        }
    }

}

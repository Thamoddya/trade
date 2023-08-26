<?php
session_start();
include_once  '../connection.php';
$response = array();
$verifyCode = $_POST['code'];
$userData = json_decode($_SESSION['userData']);
if ($_POST['Realcode'] == $verifyCode) {
    $getUserData = $pdo->prepare("UPDATE member SET emailVerifyed ='1' WHERE  nic=:nic");
    $getUserData->bindValue(':nic',$userData[0]->nic);
    $getUserData->execute();
    $response['error'] = 'false';
} else {
    $response['error'] = true;
    $response['errorMsg'] = 'Entered Code is invalid';
}

echo json_encode($response);
?>
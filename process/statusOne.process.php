<?php
session_start();
include_once '../connection.php';
$response = array();
$nic = $_POST['nic'];

$getUserData = $pdo->prepare("UPDATE member SET status ='1' WHERE  nic=:nic");
$getUserData->bindValue(':nic', $nic);
$getUserData->execute();
$response['error'] = 'false';

echo json_encode($response);
?>
<?php
include_once "../connection.php";
$response = array();
$nic = $_POST['nic'];
$balance = $_POST['balance'];

if (empty($balance)) {
    $response['error'] = 'true';
    $response['errormsg'] = 'Balance is Invalid';
} else {
    $updateBalance = $pdo->prepare("UPDATE member SET balance = :balance WHERE nic = :nic ");
    $updateBalance->bindValue(':balance', $balance);
    $updateBalance->bindValue(':nic', $nic);
    $updateBalance->execute();
    $response['error']='false';
    $response['msg'] = 'success';
};
echo json_encode($response);
?>
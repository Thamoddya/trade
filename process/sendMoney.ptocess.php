<?php
include_once "../connection.php";
$response = array();
session_start();
$userData = json_decode($_SESSION['userData']);

$walletID = $_POST['walletID'];
$price = $_POST['price'];

if (empty($price) || empty($walletID)) {
    $response['error'] = 'true';
    $response['errormsg'] = 'Balance Or Wallet ID invalid.';
} else {
    $checkIdExist = $pdo->prepare("SELECT * FROM member WHERE walletID=:walletId");
    $checkIdExist->bindValue(':walletId', $walletID);
    $checkIdExist->execute();
    $checkIdExist->fetch(PDO::FETCH_ASSOC);

    if ($checkIdExist->rowCount() == 0) {
        $response['error'] = 'true';
        $response['errormsg'] = 'Invalid Wallet Address.';
    } else {
        $updateBalanceInSender = $pdo->prepare("UPDATE member SET `balance` = `balance` - :balance WHERE nic=:nic ");
        $updateBalanceInSender->bindValue(':balance', $price);
        $updateBalanceInSender->bindValue(':nic', $userData[0]->nic);
        $updateBalanceInSender->execute();

        $updateBalanceInReciver = $pdo->prepare("UPDATE member SET `balance` = `balance` + :balance WHERE walletID=:walletId ");
        $updateBalanceInReciver->bindValue(':balance', $price);
        $updateBalanceInReciver->bindValue(':walletId', $walletID);
        $updateBalanceInReciver->execute();
        $response['error'] = 'false';
        $response['msg'] = 'success';

        // Log the balance change including previous and new balances
        $logQuery = "INSERT INTO balanceLog (nic,previousAmount, newAmount, addedDate) VALUES (:nic, :previousAmount, :newAmount, NOW())";
        $logStmt = $pdo->prepare($logQuery);
        $logStmt->execute([
            'nic' => $userData[0]->nic,
            'previousAmount' => $userData[0]->balance,
            'newAmount' => $userData[0]->balance - $price
        ]);
    };
};
echo json_encode($response);
?>
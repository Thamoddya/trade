<?php
session_start();
include_once '../connection.php';
//$userData = json_decode($_SESSION['userData']);
//$getUserData = $pdo->prepare("SELECT * FROM member WHERE nic=:nic");
//$getUserData->bindValue(':nic', $userData[0]->nic);
//$getUserData->execute();
//$liveUserData = $getUserData->fetch(PDO::FETCH_ASSOC);
//echo $liveUserData['balance'];

$query = "SELECT nic, balance FROM member WHERE last_interest_date < CURDATE()";
$accounts = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

$interestRate = 0.002; // 0.2%
foreach ($accounts as $account) {
    $previousBalance = $account['balance'];

    $interest = $account['balance'] * $interestRate;
    $newBalance = $account['balance'] + $interest;

    // Update the account
    $updateQuery = "UPDATE member SET balance = :balance, last_interest_date = CURDATE() WHERE nic = :nic";
    $stmt = $pdo->prepare($updateQuery);
    $stmt->execute([
        'balance' => $newBalance,
        'nic' => $account['nic']
    ]);
    // Log the balance change including previous and new balances
    $logQuery = "INSERT INTO balanceLog (nic,previousAmount, newAmount, addedDate) VALUES (:nic, :previousAmount, :newAmount, NOW())";
    $logStmt = $pdo->prepare($logQuery);
    $logStmt->execute([
        'nic' => $account['nic'],
        'previousAmount' => $previousBalance,
        'newAmount' => $newBalance
    ]);
};
echo "success";
?>
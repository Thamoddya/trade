<?php
// Include your database connection
include('../connection.php');

// Fetch profit and loss data
$query = "SELECT nic, SUM(newAmount - previousAmount) AS profit_loss FROM balancelog GROUP BY nic";
$result = $pdo->query($query);
$data = $result->fetchAll(PDO::FETCH_ASSOC);

// Return data as JSON
echo json_encode($data);
?>
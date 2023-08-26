<?php

include('../connection.php');

// Fetch profit and loss data by date
$query = "SELECT addedDate, SUM(newAmount - previousAmount) AS profit_loss FROM balancelog GROUP BY addedDate";
$result = $pdo->query($query);
$data = $result->fetchAll(PDO::FETCH_ASSOC);

// Return data as JSON
echo json_encode($data);
?>
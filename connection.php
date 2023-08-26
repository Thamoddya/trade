<?php

$host = "localhost";
$dbName = "tradewave";
$username = "root";
$password = "1234";
//$host = "localhost";
//$dbName = "thamoddya1_sanija";
//$username = "thamoddya1_sanija";
//$password = "q22p17Ixdy";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
];

try {
    $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {

    echo "Connection failed: " . $e->getMessage();
}

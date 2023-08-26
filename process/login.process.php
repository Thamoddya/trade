<?php
session_start();
include_once "../connection.php";

$role = $_POST['role'];
$email = $_POST['email'];
$password = $_POST['password'];

// Perform a search query using PDO
$query = "SELECT * FROM " . $role . " WHERE email = :email AND password = :password";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $password);

try {
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode(['success' => true, 'location' => $role]);
        $_SESSION['userData'] = json_encode($result);
    } else {
        echo json_encode(['success' => false, 'message' => 'No data found']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
};
?>
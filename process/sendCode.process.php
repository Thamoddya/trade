<?php
session_start();
$userData = json_decode($_SESSION['userData']);

include_once "./member.sendmail.php";
$response = array();
require '../include/Exception.php';
require '../include/PHPMailer.php';
require '../include/SMTP.php';
$verifyCode = $_POST['verifyID'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer;
$mail->IsSMTP();
$mail->Host = 'mail.codiffylk.com'; // SMTP server address
$mail->SMTPAuth = true; // Enable SMTP authentication
$mail->Username = 'mail@codiffylk.com'; // SMTP username
$mail->Password = 'aUKZd0t8hb'; // SMTP password
$mail->SMTPSecure = 'tls'; // Encryption (tls or ssl)
$mail->Port = 587; // SMTP port

$mail->setFrom('sanija@tradewave.cloud', 'TRADE WAVE');
sendMail::SendVerificationEmail($userData['0']->name,$userData['0']->email,$verifyCode,$mail);
$response['error'] = 'false';
echo json_encode($response);
?>
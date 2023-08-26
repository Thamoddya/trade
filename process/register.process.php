<?php
include_once '../connection.php';
include_once "../validation.php";

include_once "./member.sendmail.php";
$response = array();
require '../include/Exception.php';
require '../include/PHPMailer.php';
require '../include/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//
$mail = new PHPMailer;
$mail->IsSMTP();
$mail->Host = 'mail.codiffylk.com'; // SMTP server address
$mail->SMTPAuth = true; // Enable SMTP authentication
$mail->Username = 'mail@codiffylk.com'; // SMTP username
$mail->Password = 'aUKZd0t8hb'; // SMTP password
$mail->SMTPSecure = 'tls'; // Encryption (tls or ssl)
$mail->Port = 587; // SMTP port

//$mail = new PHPMailer;
//$mail->IsSMTP();
//$mail->Host = 'smtp.gmail.com';
//$mail->SMTPAuth = true;
//$mail->Username = 'thamoddya.smtp@gmail.com';
//$mail->Password = 'vfpornoftoayuwgf';
//$mail->SMTPSecure = 'ssl';
//$mail->Port = 465;
$mail->setFrom('sanija@tradewave.cloud', 'TRADE WAVE');

function generateVerificationCode($length = 6)
{
    $characters = '0123456789';
    $verificationCode = '';
    for ($i = 0; $i < $length; $i++) {
        $verificationCode .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $verificationCode;
};
function generateWalletID($length = 12)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $walletID = '';

    for ($i = 0; $i < $length; $i++) {
        $walletID .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $walletID;
}

function generateReferralCode($length = 8)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $referralCode = '';
    for ($i = 0; $i < $length; $i++) {
        $referralCode .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $referralCode;
}
$validation = validate($_POST, [
    'name' => 'required',
    'email' => 'required|email|min:2|max:100',
    'nic' => 'required|min:2|max:12',
    'password' => 'required',
]);
if ($validation == null) {
    $checkExist = $pdo->prepare('SELECT * FROM `member` WHERE nic=:nic OR email=:email');
    $checkExist->bindValue(":nic", $_POST['nic']);
    $checkExist->bindValue(":email", $_POST['email']);
    $checkExist->execute();
    if ($checkExist->rowCount() == '1') {
        $response['error'] = 'true';
        $response['errorMsg'] = 'The User Already Exist';
    } else {
        if (isset($_FILES['nicpic']) && !empty($_FILES['nicpic']['name'])) {
            $targetDir = "uploads/";
            $targetPath = $targetDir;

            if (move_uploaded_file($_FILES["nicpic"]["tmp_name"], $targetPath . $_POST['nic'] . ".png")) {

                $verificationCode = generateVerificationCode();
                $walletID = generateWalletID();
                $ownReferralCode = generateReferralCode();
                sendMail::SendEmail($_POST['name'],$_POST['email'],$mail);
                $registerMember = $pdo->prepare('INSERT INTO `member`(`name`, `nic`, `niclink`, `email`, `verification-code`, `referral`, `register-date`, `walletID`, `password`) VALUES(:name,:nic,:niclink,:email,:verification,:referral,NOW(),:walletID,:password)');
                $registerMember->bindValue(":name", $_POST['name']);
                $registerMember->bindValue(":nic", $_POST['nic']);
                $registerMember->bindValue(":niclink", $_POST['nic']);
                $registerMember->bindValue(":email", $_POST['email']);
                $registerMember->bindValue(":verification", $verificationCode);
                $registerMember->bindValue(":referral", $ownReferralCode);
                $registerMember->bindValue(":walletID", $walletID);
                $registerMember->bindValue(":password", $_POST['password']);
                $registerMember->execute();

                $response['error'] = 'false';
            } else {
                $response['error'] = 'true';
                $response['errorMsg'] = 'NIC Upload Failed.';
            };
        } else {
            $response['error'] = 'true';
            $response['errorMsg'] = 'No NIC Image Found';
        };
    };
} else {
    $response['error'] = 'true';
};
echo json_encode($response);
?>
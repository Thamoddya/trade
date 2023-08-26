<?php
class sendMail{
    public static function SendEmail($name, $email, $mail){
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Your Account Successfully Created.';
        $mail->Body = "Hello ".$name." <br> Please Wait We arte review your Account. ";
        $mail->send();
    }
    public static function SendVerificationEmail($name, $email, $verificationCode,$mail){
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Your Account Verification Code.';
        $mail->Body = "Hello ".$name." <br> Your Account Verification Code Is :- ".$verificationCode;
        $mail->send();
    }
};

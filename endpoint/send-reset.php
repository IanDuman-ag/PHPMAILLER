<?php
include('../conn/conn.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['request_reset'])) {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    if ($email === '') {
        echo "<script>alert('Please enter your email.'); window.location.href='http://localhost/Dumanag/forgot-password.php';</script>"; exit;
    }

    // Find user by email
    $stmt = $conn->prepare("SELECT `tbl_user_id`, `email` FROM `tbl_user` WHERE `email` = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "<script>alert('Email not found.'); window.location.href='http://localhost/Dumanag/forgot-password.php';</script>"; exit;
    }

    // Generate verification code and store it (re-using verification_code column)
    $verificationCode = rand(100000, 999999);
    $upd = $conn->prepare("UPDATE `tbl_user` SET `verification_code` = :code WHERE `tbl_user_id` = :id");
    $upd->execute(['code' => $verificationCode, 'id' => $user['tbl_user_id']]);

    // Send email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bakiiph11@gmail.com';
        $mail->Password   = 'cqmr eyoj xjmz yffu';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        $mail->setFrom('bakiiph11@gmail.com', 'Ian Kirby B. Duman-ag');
        $mail->addAddress($email);
        $mail->addReplyTo('bakiiph11@gmail.com', 'Ian Kirby B. Duman-ag');

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Verification Code';
        $mail->Body    = 'Your password reset verification code is: ' . $verificationCode;

        $mail->send();

        session_start();
        $_SESSION['reset_user_id'] = $user['tbl_user_id'];

        echo "<script>alert('Verification code sent to your email.'); window.location.href='http://localhost/Dumanag/reset-password.php';</script>"; exit;
    } catch (Exception $e) {
        echo "<script>alert('Failed to send email.'); window.location.href='http://localhost/Dumanag/forgot-password.php';</script>"; exit;
    }
}
?>

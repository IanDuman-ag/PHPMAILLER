<?php
include('../conn/conn.php');

if (isset($_POST['reset_password'])) {
    session_start();
    $userId = isset($_SESSION['reset_user_id']) ? $_SESSION['reset_user_id'] : null;
    $code = isset($_POST['verification_code']) ? trim($_POST['verification_code']) : '';
    $newPassword = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';

    if (!$userId) {
        echo "<script>alert('Session expired. Please request a new code.'); window.location.href='http://localhost/Dumanag/forgot-password.php';</script>"; exit;
    }

    if ($code === '' || $newPassword === '') {
        echo "<script>alert('Please fill in all fields.'); window.location.href='http://localhost/Dumanag/reset-password.php';</script>"; exit;
    }

    // Verify code
    $stmt = $conn->prepare("SELECT `verification_code` FROM `tbl_user` WHERE `tbl_user_id` = :id");
    $stmt->execute(['id' => $userId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row || (string)$row['verification_code'] !== (string)$code) {
        echo "<script>alert('Invalid verification code.'); window.location.href='http://localhost/Dumanag/reset-password.php';</script>"; exit;
    }

    // Update password
    $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
    $upd = $conn->prepare("UPDATE `tbl_user` SET `password` = :pwd, `verification_code` = NULL WHERE `tbl_user_id` = :id");
    $upd->execute(['pwd' => $hashed, 'id' => $userId]);

    // Clear session
    unset($_SESSION['reset_user_id']);

    echo "<script>alert('Password updated successfully. Please log in.'); window.location.href='http://localhost/Dumanag/index.php';</script>"; exit;
}
?>

<?php
include ('../conn/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT `tbl_user_id`, `password`, `username`, `email`, `verification_code` FROM `tbl_user` WHERE `username` = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $stored_password = $row['password'];
        // Read verification code; if non-empty, user has not completed email verification
        $verification_code = array_key_exists('verification_code', $row) ? $row['verification_code'] : null;

        // We treat a NULL or empty verification_code as VERIFIED. If a code exists, user is NOT verified yet.
        $isVerified = empty($verification_code);

        // Block login if email verification code has not yet been confirmed
        if (!$isVerified) {
            // Block login if email verification code has not yet been confirmed
            error_log("Login blocked - Email not verified for user: $username (verification_code present)");
            echo "
            <script>
                alert('Your email is not verified yet. Please enter the verification code sent to your email.');
                window.location.href = 'http://localhost/dumanag/verification.php';
            </script>
            ";
        } else if (password_verify($password, $stored_password)) {
            // Log successful login
            error_log("Login successful - Verified account for user: $username (User ID: " . $row['tbl_user_id'] . ")");
            
            // Start session for the user
            session_start();
            $_SESSION['user_id'] = $row['tbl_user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['logged_in'] = true;
            
            // Account is activated and password is correct - SUCCESS
            echo "
            <script>
                alert('Login Successfully!');
                window.location.href = 'http://localhost/dumanag/home.php';
            </script>
            "; 
        } else {
            // Account is verified but password is wrong
            error_log("Login failed - Incorrect password for verified user: $username");
            echo "
            <script>
                alert('Login Failed, Incorrect Password!');
                window.location.href = 'http://localhost/dumanag/index.php';
            </script>
            ";
        }
    } else {
        echo "
        <script>
            alert('Login Failed, User Not Found!');
            window.location.href = 'http://localhost/dumanag/index.php';
        </script>
        ";
    }
}
?>
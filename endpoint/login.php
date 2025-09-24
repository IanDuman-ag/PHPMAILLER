<?php
include ('../conn/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Basic validation: ensure required fields are provided
    if ($username === '' || $password === '') {
        echo "
            <script>
                alert('You must input the fields.');
                window.location.href = 'http://localhost/Dumanag/index.php';
            </script>
            ";
        exit;
    }

    $stmt = $conn->prepare("SELECT `password` FROM `tbl_user` WHERE `username` = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $stored_password = $row['password'];

        // Use password_verify to check hashed password
        if (password_verify($password, $stored_password)) {
            echo "
            <script>
                alert('Login Successfully!');
                window.location.href = 'http://localhost/Dumanag/home.php';
            </script>
            "; 
            exit;
        } else {
            echo "
            <script>
                alert('Login Failed, Incorrect Password!');
                window.location.href = 'http://localhost/Dumanag/index.php';
            </script>
            ";
            exit;
        }
    } else {
        echo "
            <script>
                alert('Login Failed, User Not Found!');
                window.location.href = 'http://localhost/Dumanag/index.php';
            </script>
            ";
        exit;
    }
}
?>
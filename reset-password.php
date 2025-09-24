<?php include ('./conn/conn.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url("img/ikcode5.png");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
        }

        .login-form, .registration-form {
            /* Layout + text */
            color: #ffffff;
            padding: 40px;
            width: 500px;
            border-radius: 14px;
            position: relative;
            overflow: hidden;

            /* No solid border; let the gradient be the background */
            border: none;

            /* Soft outer shadow */
            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.35),
                0 0 28px rgba(0, 192, 255, 0.15);
        }

        /* Animated rainbow gradient background */
        .login-form::before, .registration-form::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: linear-gradient(135deg,
                #ff0040,
                #ff7a00,
                #ffee00,
                #00c851,
                #00c0ff,
                #6a00ff,
                #ff00ea
            );
            background-size: 300% 300%;
            animation: gradientShift 12s ease infinite;
            z-index: 0;
        }

        /* Subtle inner glass overlay for readability */
        .login-form::after, .registration-form::after {
            content: "";
            position: absolute;
            inset: 2px;
            border-radius: 12px;
            background: rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 0;
        }

        /* Ensure content sits above overlays */
        .login-form > *, .registration-form > * {
            position: relative;
            z-index: 1;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .switch-form-link {
            text-decoration: underline;
            cursor: pointer;
            color: rgb(100, 100, 200);
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h2 class="text-center">Reset Password</h2>
        <p class="text-center">Enter the verification code sent to your email and set your new password.</p>
        <form action="./endpoint/reset-password.php" method="POST">
            <div class="form-group">
                <label for="verification_code">Verification Code</label>
                <input type="text" class="form-control" id="verification_code" name="verification_code" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <button type="submit" class="btn btn-secondary form-control" name="reset_password">Update Password</button>
            <div class="text-center mt-2">
                <a href="./index.php">Back to Login</a>
            </div>
        </form>
    </div>

    <!-- Bootstrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php include ('./conn/conn.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System with Email Verification</title>

    <!-- Bootstrap CSS -->
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
    
    <div class="main">

        <!-- Login Area -->
        <div class="login-container">

            <div class="login-form" id="loginForm">
                <h2 class="text-center">Welcome Back!</h2>
                <p class="text-center">Fill your login details.</p>
                <form action="./endpoint/login.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <p>No Account? Register <span  class="switch-form-link" onclick="showRegistrationForm()">Here.</span></p>
                    <button type="submit" class="btn btn-secondary login-btn form-control" >Login</button>
                    <div class="text-center mt-2">
                        <a href="./forgot-password.php">Forgot password?</a>
                    </div>
                </form>

            </div>

        </div>
        <!-- Registration Area -->
        <div class="registration-form" id="registrationForm">
            <h2 class="text-center">Registration Form</h2>
            <p class="text-center">Fill in you personal details.</p>
            <form action="./endpoint/add-user.php" method="POST">
                <div class="form-group registration row">
                    <div class="col-6">
                        <label for="firstName">First Name:</label>
                        <input type="text" class="form-control" id="firstName" name="first_name">
                    </div>
                    <div class="col-6">
                        <label for="lastName">Last Name:</label>
                        <input type="text" class="form-control" id="lastName" name="last_name">
                    </div>
                </div>
                <div class="form-group registration row">
                    <div class="col-5">
                        <label for="contactNumber">Contact Number:</label>
                        <input type="number" class="form-control" id="contactNumber" name="contact_number" maxlength="11">
                    </div>
                    <div class="col-7">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                </div>
                <div class="form-group registration">
                    <label for="registerUsername">Username:</label>
                    <input type="text" class="form-control" id="registerUsername" name="username">
                </div>
                <div class="form-group registration">
                    <label for="registerPassword">Password:</label>
                    <input type="password" class="form-control" id="registerPassword" name="password">
                </div>
                <p>Already have an account? Login <span class="switch-form-link" onclick="showLoginForm()">Here.</span></p>
                <button type="submit" class="btn btn-dark login-register form-control" name="register">Register</button>

            </form>

        </div>

    </div>

    <script>
        const loginForm = document.getElementById('loginForm');
        const registrationForm = document.getElementById('registrationForm');

        registrationForm.style.display = "none";


        function showRegistrationForm() {
            registrationForm.style.display = "";
            loginForm.style.display = "none";
        }

        function showLoginForm() {
            registrationForm.style.display = "none";
            loginForm.style.display = "";
        }

        function sendVerificationCode() {
            const registrationElements = document.querySelectorAll('.registration');

            registrationElements.forEach(element => {
                element.style.display = 'none';
            });

            const verification = document.querySelector('.verification');
            if (verification) {
                verification.style.display = 'none';
            }
        }

    </script>

    <!-- Bootstrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

</body>
</html>
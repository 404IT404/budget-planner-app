<?php 
    session_start();
    if(isset($_SESSION['username'])) {
        header('Location: ' . './views/dashboard/dashboard.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Planner</title>
    <link rel="stylesheet" href="main.scss">
    <link rel="stylesheet" href="./views/global/styles/global_styles.scss">
</head>
<body>
    <div class="main-container">
        <div class="">
            <img src="views/assets/main_page_img_1.png" alt="Image" class="main_page_img_1">
        </div>
        <h1>Budget It.</h1>
        <div class="main-btn-wrapper">
            <a href="./views/login/login.php" class="link-1 main-login-btn">Login</a>
            <a href="./views/register/register.php" class="link-1 main-register-btn">Get Started</a>
        </div>
    </div>
</body>
</html>
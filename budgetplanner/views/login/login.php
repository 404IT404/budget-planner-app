<?php 
    session_start();
    include '../../models/database/database_connection.php';

    if(isset($_SESSION['username'])) {
        header('Location: ' . '../dashboard/dashboard.php');
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
        $password = $_POST['password'];

        try {
            $user_login_sql = "SELECT username, password FROM users
                                WHERE username = :username";
            $user_login_query = $conn->prepare($user_login_sql);
            $user_login_query->bindParam(':username', $username, PDO::PARAM_STR);
            $user_login_query->execute();

            $user_credentials = $user_login_query->fetch(PDO::FETCH_ASSOC);

            if($user_credentials && password_verify($password, $user_credentials['password'])) {
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $user_credentials['user_id'];
                
                header('Location:' . '../dashboard/dashboard.php');
                exit();
            } else {
                $invalid_credentials = 'Invalid username and password';
            }

        } catch (PDOException $err) {
            return 'Error' . $err->getMessage();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.scss">
    <link rel="stylesheet" href="../../views/global/styles/global_styles.scss">
</head>
<body>
    <div class="login-main-container">
        <h1>Welcome back!</h1>
        <p>Login your account here.</p>
        <form method="POST">
            <div class="login-input-wrapper">
                <input type="text" name="username" placeholder="Username" 
                class="input-1" />
                <input type="password" name="password" placeholder="Password"
                class="input-1" />
                <p class="to-register-link">Don&#39;t have an account? 
                    <a href="../../views/register/register.php">Signup</a>
                </p>
            </div>
            <p class="errors"><?php 
                if(isset($invalid_credentials)) {
                    echo $invalid_credentials;
                }
            ?></p>
            <button class="button-1 login-btn">Login</button>
        </form>
    </div>
</body>
</html>
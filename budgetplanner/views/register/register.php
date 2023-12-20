<?php 
    session_start();
    include '../../models/database/database_connection.php';

    if(isset($_SESSION['username'])) {
        header('Location: ' . '../dashboard/dashboard.php');
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
        $password = $_POST['password'];

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        
        $user_already_exists_sql = "SELECT username FROM users
                                    WHERE username = :username";
        $user_already_exists_query = $conn->prepare($user_already_exists_sql);
        $user_already_exists_query->bindParam(':username', $username, PDO::PARAM_STR);
        $user_already_exists_query->execute();
        $user_already_exists = $user_already_exists_query->fetch(PDO::FETCH_ASSOC);

        if($user_already_exists) {
            $user_exists = 'Username already exist!';
        } else {
            try {
                $register_sql = "INSERT INTO users(username, password)
                                VALUES (:username, :password)";
                $register_query = $conn->prepare($register_sql);
                $register_query->bindParam(':username', $username, PDO::PARAM_STR);
                $register_query->bindParam(':password', $hashed_password, PDO::PARAM_STR);
                $register_query->execute();
    
                header('Location:' . '../login/login.php');
                exit();
            } catch(PDOException $err) {
                echo 'Error' . $err->getMessage();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.scss">
    <link rel="stylesheet" href="../../views/global/styles/global_styles.scss">
</head>
<body>
    <div class="register-main-container">
        <h1>Create an Account</h1>
        <p>Register an account to use and enjoy our web app.</p>
        <form action="" method="POST">
            <div class="register-input-wrapper">
                <input type="text" name="username"  placeholder="Userame"
                    class="input-1">
                <input type="password" name="password"  placeholder="Password"
                    class="input-1">
                <p class="to-login-link">Already have an account? 
                    <a href="../../views/login/login.php">Login</a>
                </p>
            </div>
            <p class="errors"><?php 
                if(isset($user_already_exists)) {
                    echo $user_exists;
                }
            ?></p>
            <button class="button-1 register-btn">Create Account</button>
        </form>
        <a href="../../main.php" class="button-1">Back to Home</a>
    </div>
</body>
</html>
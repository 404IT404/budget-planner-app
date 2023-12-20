<?php 
    session_start();
    include '../models/database/database_connection.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            
            // Validate and retrieve the balance amount entered by the user
            $user_balance = $_POST['balance_amount'] ?? 0; // Assuming the input field is named 'balance_amount'

            // Perform validation on $user_balance here if needed

            try {
                $add_balance_sql = "INSERT INTO users_balance (user_id, balance) 
                                    VALUES (:user_id, :balance)";
                $add_balance_query = $conn->prepare($add_balance_sql);
                $add_balance_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $add_balance_query->bindParam(':balance', $user_balance, PDO::PARAM_STR);
                $add_balance_query->execute();

                // Redirect after adding balance (optional)
                header('Location:' . './dashboard.php');
                exit();
            } catch(PDOException $err) {
                echo 'Error' . $err->getMessage();
            }
        } else {
            // Handle case where user is not logged in or session doesn't contain user_id
            header('Location: ../login.php'); // Redirect to login page or handle appropriately
            exit();
        }
    }

?>
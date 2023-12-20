<?php
    session_start();
    include '../../models/database/database_connection.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['logout_user'])) {
            session_destroy();
            header('Location: '. '../../main.php');
            exit();
        }
    }

    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        
        try {
            $fetch_user_sql = "SELECT * FROM users WHERE username = :username";
            $fetch_user_query = $conn->prepare($fetch_user_sql);
            $fetch_user_query->bindParam(':username', $username, PDO::PARAM_STR);
            $fetch_user_query->execute();
    
            $user_credential = $fetch_user_query->fetch(PDO::FETCH_ASSOC);
    
        } catch(PDOException $err) {
            echo 'Error' . $err->getMessage();
        }
    } else {
        // Handle case when the user is not logged in
        header('Location: ../../main.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./dashboard.scss">
    <link rel="stylesheet" href="../global/styles/global_styles.scss">
</head>
<body>
    <div class="dashboard-container">
        <?php include '../components/sidebar/side_bar.php' ?>

        <section class="dashboard-content">
            <?php include '../components/navbar/navbar.php'; ?>
            <div class="dashboard-wrapper">
                <h1 class="dashboard-user-name title-1">Welcome back, <span class="dashboard-username"><?php echo $user_credential['username']?></span>!</h1>
                <p class="text-1">Good to see you again, <span class="dashboard-username"><?php echo $user_credential['username']?></span></p>
                <div class="dashboard-activity-container">
                    <h3 class="title-3">Dashboard</h3>
                    <div class="dashboard-activity-wrapper">
                        <div class="activity-card">
                            <div class="activity-money-wrapper">   
                                <div>
                                    <p>Total Money</p>
                                    <h2 class="title-2">$ 123</h2>
                                </div>
                                <img src="" alt="Money Icon">
                            </div>
                        </div>
                        <div class="activity-card">
                            <div class="activity-money-wrapper">   
                                <div>
                                    <p>Total Money</p>
                                    <h2 class="title-2">$ 123</h2>
                                </div>
                                <img src="" alt="Money Icon">
                            </div>
                        </div>
                        <div class="activity-card">
                            <div class="activity-money-wrapper">   
                                <div>
                                    <p>Total Money</p>
                                    <h2 class="title-2">$ 123</h2>
                                </div>
                                <img src="" alt="Money Icon">
                            </div>
                        </div>
                    </div>
                </div>
                <p>Line Break</p>
                <div class="overview-container">
                    <div>
                        <h3 class="title-3">Overview</h3>
                        <div class="overview-activity">
                            <h4>Drinking</h4>
                            <p>Nov 15</p>
                            <p>Cash</p>
                            <h4>$34.9</h4>
                        </div>
                    </div>
                    <div>
                        <h3 class="title-3">Actions</h3>
                        <div class="add-transaction">
                            <h4>Your balance {$121212.12}</h4>
                            <form method="POST">
                                <input type="text" placeholder="Transaction" class="input-1">
                                <div class="">
                                    <input type="radio">Cash</input>
                                    <input type="radio">Card</input>
                                    <input type="radio">E-money</input>
                                    <input type="radio">Other</input>
                                </div>
                                <button class="button-1">Add</button>
                            </form>
                        </div>
                        <div class="add-balance-container">
                            <h4>Add Balance</h4>
                            <form method="POST"> <!-- Specify the action attribute -->
                                <input type="number" placeholder="Add Balance" class="input-1" name="balance_amount"> <!-- Add the name attribute -->
                                <button type="submit" class="button-1">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let logout_btn =document.getElementById('logout_icon');
        logout_btn.addEventListener('click', function() {
            let logout_content =document.getElementById('logout_btn_wrapper');
            logout_content.classList.toggle('show')
        })
    })
</script>
</html>
<?php 
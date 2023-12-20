<?php 
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $db_name = 'budget_planner_db';
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
        // Set PDO to throw exceptions on error
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $err) {
        echo 'Connection failed:' . $err->getMessage();
        exit();
    }
?>
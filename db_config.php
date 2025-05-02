<?php

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "drawing";


$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);


if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}


function setup_database($conn) 
{

    $user_table = "CREATE TABLE IF NOT EXISTS user_accounts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    )";
    
    if (!$conn->query($user_table)) {
        echo "Error creating user_accounts table: " . $conn->error;
    }
    
    // Create drawings table
    $drawings_table = "CREATE TABLE IF NOT EXISTS drawings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        name VARCHAR(100) NOT NULL,
        drawing_data MEDIUMBLOB NOT NULL,
        FOREIGN KEY (user_id) REFERENCES user_accounts(id)
    )";
    
    if (!$conn->query($drawings_table)) {
        echo "Error creating drawings table: " . $conn->error;
    }
}


setup_database($conn);


session_start();


function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function require_login() {
    if (!is_logged_in()) {
        header("Location: login.php");
        exit();
    }
}
?>
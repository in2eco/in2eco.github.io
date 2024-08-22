<?php
// login.php

session_start();
$stored_username = 'your_username';
$stored_password_hash = password_hash('your_password', PASSWORD_DEFAULT);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $stored_username && password_verify($password, $stored_password_hash)) {
        // Login successful, set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        echo 'Invalid username or password';
    }
}
?>

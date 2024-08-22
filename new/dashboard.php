<?php
// dashboard.php

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Display the protected content
echo 'Welcome to your dashboard, ' . htmlspecialchars($_SESSION['username']) . '!';
?>

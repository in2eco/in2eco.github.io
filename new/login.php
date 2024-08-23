<?php
ini_set('session.cookie_lifetime', 0);
session_start();

$stored_username = 'test';
$stored_password_hash = password_hash('test', PASSWORD_DEFAULT);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $stored_username && password_verify($password, $stored_password_hash)) {
        session_regenerate_id(true);
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: dashboard.php?username='.$username);
        exit;
    } else {
        header('Location: index.php');
        exit;
    }
}
else {
  header('Location: index.php');
  exit;
}
?>

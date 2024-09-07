<?php
session_start(); // Start the session

// Database connection parameters
$servername = 'localhost';
$username = 'root';
$password = 'abcd1234';
$dbname = 'in2eco';

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Validate input
    if (empty($inputUsername) || empty($inputPassword)) {
        echo "Username and password are required.";
        exit();
    }

    // Prepare and execute the SQL query
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->execute([':username' => $inputUsername]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists and verify password
    if ($user && password_verify($inputPassword, $user['password'])) {
        // Regenerate session ID to prevent session fixation
        session_regenerate_id(true);

        // Store user information in session
        $_SESSION['username'] = $inputUsername;
        $_SESSION['last_activity'] = time();

        // Redirect to a protected page (e.g., dashboard)
        header("Location: index.php?username=".$_SESSION['username']);
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
?>

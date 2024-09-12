<?php
// Database connection parameters
$servername = 'localhost';
$username = 'anuragg';
$password = 'P@ssw0rd123';
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
    // Retrieve and sanitize user input
    $user = $_POST["username"];
    $pass = $_POST["password"];
    $name = $_POST["name"];
    // Validate input
    if (empty($user) || empty($pass) || empty($name)) {
        echo "Username, Password, Name are required.";
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($pass, PASSWORD_BCRYPT);

    // Prepare and execute the SQL query
    $stmt = $pdo->prepare('INSERT INTO users (username, password, name) value (:username, :password, :name)');
    $stmt->execute([
        ':username' => $user,
        ':password' => $hashedPassword,
        ':name' => $name
    ]);

    echo "Sign up successful!";
}
?>

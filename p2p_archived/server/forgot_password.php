<?php
require 'database.php'; // Adjust based on your database connection setup

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    //
    // // Check if the email exists in the database
    // $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    // $stmt->bind_param("s", $email);
    // $stmt->execute();
    // $result = $stmt->get_result();
    //
    // if ($result->num_rows > 0) {
    //     // User exists, create a reset token
    //     $token = bin2hex(random_bytes(50)); // Generate a unique token
    //     $expiry = date("Y-m-d H:i:s", strtotime('+1 hour')); // Token expiry time

        // Insert the token into the database
        // $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expiry) VALUES (?, ?, ?)");
        // $stmt->bind_param("sss", $email, $token, $expiry);
        // $stmt->execute();

        // Send the reset link to the user's email
        // $resetLink = "http://yourwebsite.com/reset_password.php?token=" . $token; // Adjust to your domain
        $subject = "Password Reset Request";
        $message = "Click the link to reset your password: " . $resetLink;
        $headers = "From: no-reply@in2eco.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "A password reset link has been sent to your email.";
        } else {
            echo "Failed to send the reset link.";
        }
    // } else {
    //     echo "No account found with that email address.";
    // }
}
?>

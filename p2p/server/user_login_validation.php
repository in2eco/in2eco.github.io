<?php
session_start(); // Start the session securely

// Set the session timeout duration (in seconds)
$sessionTimeout = 600;

// Function to handle session timeout
function enforceSessionTimeout()
{
    global $sessionTimeout;

    // Check if the 'last_activity' timestamp is set
    if (isset($_SESSION['last_activity'])) {
        // Calculate the session's age
        $sessionAge = time() - $_SESSION['last_activity'];

        // If the session has exceeded the timeout duration, destroy it
        if ($sessionAge > $sessionTimeout) {
            session_unset();     // Unset session variables
            session_destroy();   // Destroy the session
            header("Location: index.php"); // Redirect to login with a timeout message
            exit();
        }
    }

    // Update the last activity time
    $_SESSION['last_activity'] = time();
}

// Enforce session timeout on each request
enforceSessionTimeout();

// Fetch the username from the URL
$usernameFromUrl = isset($_GET['username']) ? $_GET['username'] : '';

// Check if the user is signed in (assuming signed-in user's name is stored in session)
if (!isset($_SESSION['username']) || $_SESSION['username'] !== $usernameFromUrl) {
    // Redirect to the main page if the user is not signed in or the username does not match
    header("Location: index.php"); // Change to your main page URL
    exit(); // Ensure the script stops executing after the redirect
}
?>

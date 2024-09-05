<?php
// Path to the JSON file
$jsonFilePath = 'files/data/user.json';

// Get the username from the GET request
$username = isset($_GET['username']) ? trim($_GET['username']) : '';

// Check if the username is provided
if (empty($username)) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Username is required.']);
    exit();
}

// Read the JSON file contents
$jsonData = file_get_contents($jsonFilePath);

// Decode the JSON data into an associative array
$userData = json_decode($jsonData, true);

// Check if JSON decoding was successful
if ($userData === null) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Error reading user data.']);
    exit();
}

// Search for the user by username
$userDetails = null;
foreach ($userData as $user) {
    if (isset($user['username']) && $user['username'] === $username) {
        $userDetails = $user;
        break;
    }
}

// Check if user details were found
if ($userDetails) {
    echo json_encode($userDetails); // Return user details as JSON
} else {
    http_response_code(404); // Not Found
    echo json_encode(['error' => 'User not found.']);
}
?>

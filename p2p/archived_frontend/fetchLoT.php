<?php
// Path to your JSON file
$jsonFile = 'files/data/lot.json';

// Get the username from the request (e.g., from a GET request)
$username = isset($_GET['username']) ? $_GET['username'] : '';

if (empty($username)) {
    echo json_encode(['error' => 'Username parameter is required']);
    exit;
}

// Read the JSON file
if (!file_exists($jsonFile)) {
    echo json_encode(['error' => 'Data file not found']);
    exit;
}

$jsonData = file_get_contents($jsonFile);

// Decode JSON data into a PHP array
$dataArray = json_decode($jsonData, true);

if ($dataArray === null) {
    echo json_encode(['error' => 'Failed to decode JSON data']);
    exit;
}

// Search for the user with the given username
$result = array_filter($dataArray, function($user) use ($username) {
    return $user['username'] === $username;
});

// Return results as JSON
echo json_encode(array_values($result));
?>

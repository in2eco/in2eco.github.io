<?php
// Path to the JSON file
$jsonFilePath = 'files/data/user.json';

// Read the incoming JSON data
$input = file_get_contents('php://input');

// Decode the JSON data
$updatedData = json_decode($input, true);

// Check if JSON decoding was successful
if ($updatedData === null) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid JSON data.']);
    exit();
}

// Check if 'username' field is provided
if (!isset($updatedData['username'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Username is required.']);
    exit();
}

// Read the existing data from contact.json
if (!file_exists($jsonFilePath)) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Data file does not exist.']);
    exit();
}

$jsonData = file_get_contents($jsonFilePath);
$contacts = json_decode($jsonData, true);

// Check if JSON decoding was successful
if ($contacts === null) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Error reading contact data.']);
    exit();
}

// Find and update the contact
$username = $updatedData['username'];
$updated = false;

foreach ($contacts as &$contact) {
    if ($contact['username'] === $username) {
        // Update the contact data
        $contact = array_merge($contact, $updatedData);
        $updated = true;
        break;
    }
}

// If the user was not found
if (!$updated) {
    http_response_code(404); // Not Found
    echo json_encode(['error' => 'User not found.']);
    exit();
}

// Save the updated data back to the file
if (file_put_contents($jsonFilePath, json_encode($contacts, JSON_PRETTY_PRINT)) === false) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Error writing contact data.']);
    exit();
}

// Return success message
http_response_code(200); // OK
echo json_encode(['success' => 'Contact updated successfully.']);
?>

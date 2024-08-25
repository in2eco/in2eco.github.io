<?php
header('Content-Type: application/json');

// Retrieve data from POST request
$printerId = $_POST['printerId'];
$pages = $_POST['pages'];

// Handle file upload
if (isset($_FILES['file'])) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $filePath = 'uploads/' . $fileName;

    if (move_uploaded_file($fileTmpPath, $filePath)) {
        // File uploaded successfully
        // Calculate total price (example)
        $totalPrice = 0.15 * $pages; // Adjust according to actual pricing logic
        echo json_encode(['price' => $totalPrice]);
    } else {
        echo json_encode(['error' => 'Failed to upload file.']);
    }
} else {
    echo json_encode(['error' => 'No file uploaded.']);
}
?>

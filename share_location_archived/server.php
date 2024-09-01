<?php
$filename = 'markers.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Save data
    $data = json_decode(file_get_contents('php://input'), true);
    if (file_put_contents($filename, json_encode($data))) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Load data
    if (file_exists($filename)) {
        echo file_get_contents($filename);
    } else {
        echo json_encode([]);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
?>

<?php
session_start();

// Sample user data (in practice, this would come from a database)
$user_data = [
    'name' => 'John Doe',
    'contact' => '123-456-7890',
    'email' => 'john.doe@example.com',
    'address' => '123 Main St, Anytown, USA'
];

// Set the session timeout duration (in seconds)
$timeout_duration = 50;

if (isset($_SESSION['last_activity'])) {
    $elapsed_time = time() - $_SESSION['last_activity'];

    if ($elapsed_time > $timeout_duration) {
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit;
    }
}

$_SESSION['last_activity'] = time();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>User Dashboard</h1>

        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search for a detail...">
            <button onclick="searchDetails()">Search</button>
        </div>

        <div class="user-details">
            <h2>User Details</h2>
            <div class="detail" data-label="Name">Name: John Doe</div>
            <div class="detail" data-label="Contact">Contact: 123-456-7890</div>
            <div class="detail" data-label="Email">Email: john.doe@example.com</div>
            <div class="detail" data-label="Address">Address: 123 Main St, Anytown, USA</div>
        </div>
    </div>

    <script>
    function searchDetails() {
    // Get the search input value
    var input = document.getElementById('searchInput').value.toLowerCase();

    // Get all detail elements
    var details = document.querySelectorAll('.detail');

    // Variable to track if any match is found
    var foundMatch = false;

    // Loop through each detail and check if it matches the search query
    details.forEach(function(detail) {
        var label = detail.getAttribute('data-label').toLowerCase();

        // Show the detail if it matches the search query
        if (label.includes(input)) {
            detail.classList.remove('hidden');
            foundMatch = true;
        } else {
            detail.classList.add('hidden');
        }
    });

    // If no match is found, show all details
    if (!foundMatch) {
        details.forEach(function(detail) {
            detail.classList.remove('hidden');
        });
    }
}
</script>
</body>
</html>

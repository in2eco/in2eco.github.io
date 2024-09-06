<?php
// Database configuration
$host = 'localhost';       // Database host, usually localhost
$db = 'in2eco';     // Name of your database
$user = 'root';   // Database username
$pass = 'abcd1234';   // Database password

try {
    // Create a new PDO instance and set the error mode to exception
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Display error message if connection fails
    die('Connection failed: ' . $e->getMessage());
}

// Read DataTables request parameters
$draw = isset($_GET['draw']) ? intval($_GET['draw']) : 1;
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$length = isset($_GET['length']) ? intval($_GET['length']) : 10;
$searchValue = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

// Prepare the base query
$baseQuery = "SELECT * FROM lot";

// Search filter
$searchQuery = "";
if (!empty($searchValue)) {
    $searchQuery = " WHERE item LIKE :searchValue";
}

// Get the total number of records without filtering
$totalQuery = $pdo->prepare("SELECT COUNT(*) FROM lot");
$totalQuery->execute();
$totalRecords = $totalQuery->fetchColumn();

// Get the total number of records with filtering
$filteredQuery = $pdo->prepare("SELECT COUNT(*) FROM lot $searchQuery");
if (!empty($searchValue)) {
    $filteredQuery->bindValue(':searchValue', '%' . $searchValue . '%', PDO::PARAM_STR);
}
$filteredQuery->execute();
$totalFiltered = $filteredQuery->fetchColumn();

// Fetch the records
$dataQuery = $pdo->prepare("$baseQuery $searchQuery LIMIT :start, :length");
if (!empty($searchValue)) {
    $dataQuery->bindValue(':searchValue', '%' . $searchValue . '%', PDO::PARAM_STR);
}
$dataQuery->bindValue(':start', $start, PDO::PARAM_INT);
$dataQuery->bindValue(':length', $length, PDO::PARAM_INT);
$dataQuery->execute();
$data = $dataQuery->fetchAll(PDO::FETCH_ASSOC);

// Prepare the response
$response = [
    "draw" => $draw,
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalFiltered,
    "data" => $data
];

// Send the response in JSON format
echo json_encode($response);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTables Server-Side Example</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Item</th>
            </tr>
        </thead>
    </table>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "search.php",
                "columns": [
                    { "data": "item" }
                ]
            });
        });
    </script>
</body>
</html>

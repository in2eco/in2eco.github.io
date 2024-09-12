<?php
// Include the database connection
$host = 'localhost';       // Database host, usually localhost
$db = 'in2eco';     // Name of your database
$user = 'anuragg';   // Database username
$pass = 'P@ssw0rd123';   // Database password

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
$orderColumnIndex = isset($_GET['order'][0]['column']) ? intval($_GET['order'][0]['column']) : 0;
$orderDir = isset($_GET['order'][0]['dir']) ? $_GET['order'][0]['dir'] : 'asc';

// Map the column index to the actual column name
$columns = ['item', 'contact']; // Changed to reflect contact column
$orderBy = $columns[$orderColumnIndex] ?? 'item'; // Default to 'item'

$username = $_GET["username"];
// print_r($username);
// Prepare the base query with join
// $baseQuery = "SELECT id, username, item, CONCAT('<button onclick=editData({\"id\"\:',id,',\"username\":\"',username,'\",\"item\":\"',item,'\"})>Edit</button><button onclick=deleteData(',id,')>Delete</button>') as action from lot";
$baseQuery = "SELECT id, username, item, CONCAT('<button onclick=deleteData(',id,')>Delete</button>') as action from lot";

// Search filter
$searchQuery = "where username='".$username."'";
if (!empty($searchValue)) {
    $searchQuery = " WHERE item LIKE :searchValue AND username='".$username."'";
}

// Get the total number of records without filtering
$totalQuery = $pdo->prepare("SELECT COUNT(*) FROM lot where username=:username");
$totalQuery->bindValue(':username', '%' . $username . '%', PDO::PARAM_STR);
$totalQuery->execute();
$totalRecords = $totalQuery->fetchColumn();

// Get the total number of records with filtering
$filteredQuery = $pdo->prepare("SELECT COUNT(*) FROM lot $searchQuery");
if (!empty($searchValue)) {
    $filteredQuery->bindValue(':searchValue', '%' . $searchValue . '%', PDO::PARAM_STR);
}
$filteredQuery->execute();
$totalFiltered = $filteredQuery->fetchColumn();

// Fetch the records with sorting
$dataQuery = $pdo->prepare("$baseQuery $searchQuery order by $orderBy $orderDir LIMIT :start, :length");
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

<?php
// Include the database connection
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
$orderColumnIndex = isset($_GET['order'][0]['column']) ? intval($_GET['order'][0]['column']) : 0;
$orderDir = isset($_GET['order'][0]['dir']) ? $_GET['order'][0]['dir'] : 'asc';

// Map the column index to the actual column name
$columns = ['item', 'contact']; // Changed to reflect contact column
$orderBy = $columns[$orderColumnIndex] ?? 'item'; // Default to 'item'

$current_latitude = $_GET["latitude"];
$current_longitude = $_GET["longitude"];
// Prepare the base query with join
$baseQuery = "
    SELECT lot.item, CONCAT(users.name,'<br><br>',if(users.email is not null and users.email !='',CONCAT('<a href=\"mailto:',users.email,'\"><img class=\"logo\" src=\"files/logo/email.png\"</a>'),''),if(users.telegram is not null and users.telegram !='',CONCAT('<a href=\"https://t.me/',users.telegram,'\"><img class=\"logo\" src=\"files/logo/telegram.png\"</a>'),''),if(users.instagram is not null and users.instagram !='',CONCAT('<a href=\"https://instagram.com/',users.instagram,'\"><img class=\"logo\" src=\"files/logo/instagram.png\"</a>'),''),if(users.whatsapp is not null and users.whatsapp !='',CONCAT('<a href=\"https://wa.me/',users.whatsapp,'\"><img class=\"logo\" src=\"files/logo/whatsapp.png\"</a>'),'')) as contact, (6371 * ACOS(COS(RADIANS($current_latitude))* COS(RADIANS(users.latitude))* COS(RADIANS(users.longitude) - RADIANS($current_longitude))+ SIN(RADIANS($current_latitude))* SIN(RADIANS(users.latitude)))) AS distance FROM lot LEFT JOIN users ON lot.username = users.username";

// Search filter
$searchQuery = "";
if (!empty($searchValue)) {
    $searchQuery = " WHERE lot.item LIKE :searchValue ";
}

// Get the total number of records without filtering
$totalQuery = $pdo->prepare("SELECT COUNT(*) FROM lot LEFT JOIN users ON lot.username = users.username");
$totalQuery->execute();
$totalRecords = $totalQuery->fetchColumn();

// Get the total number of records with filtering
$filteredQuery = $pdo->prepare("SELECT COUNT(*) FROM lot LEFT JOIN users ON lot.username = users.username $searchQuery");
if (!empty($searchValue)) {
    $filteredQuery->bindValue(':searchValue', '%' . $searchValue . '%', PDO::PARAM_STR);
}
$filteredQuery->execute();
$totalFiltered = $filteredQuery->fetchColumn();

// Fetch the records with sorting
$dataQuery = $pdo->prepare("$baseQuery $searchQuery ORDER BY distance asc, $orderBy $orderDir LIMIT :start, :length");
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

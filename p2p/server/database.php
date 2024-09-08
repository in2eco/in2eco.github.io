<?php
// session_start();
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "abcd1234";
$dbname = "in2eco";
// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

try {
    // Create a new PDO instance and set the error mode to exception
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Display error message if connection fails
    die('Connection failed: ' . $e->getMessage());
}
// FIND KEYS OF LOT DATABASE
function findKeysOfLotDatabase()
{
  global $servername,$username,$password,$dbname,$conn;
  $sql = "DESCRIBE lot";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $lotKeys[] = $row['Field'];
      }
  }
  return $lotKeys;
}

// FIND NAME OF A USER FROM USERNAME
function findNameFromUsername($searchUsername) {
  global $servername,$username,$password,$dbname,$conn,$pdo;
  $sql="select name from users where username=:username";
  $query=$pdo->prepare($sql);
  $query->bindParam(':username',$searchUsername,PDO::PARAM_STR);
  $query->execute();
  $result = $query->fetchAll(PDO::FETCH_ASSOC);
  return $result[0]["name"];
}

// FIND CONTACT DETAILS OF A USER FROM USERNAME
function findContactFromUsername($searchUsername) {
  global $servername,$username,$password,$dbname,$conn,$pdo;
  $sql="select instagram, telegram, email, whatsapp from users where username=:username";
  $query=$pdo->prepare($sql);
  $query->bindParam(':username',$searchUsername,PDO::PARAM_STR);
  $query->execute();
  $result = $query->fetchAll(PDO::FETCH_ASSOC);
  return ["instagram" => $result[0]["instagram"], "telegram" => $result[0]["telegram"], "email" => $result[0]["email"], "whatsapp" => $result[0]["whatsapp"]];
}

// FIND LOCATION OF A USER FROM USERNAME
function findLocationFromUsername($searchUsername) {
  global $servername,$username,$password,$dbname,$conn,$pdo;
  $sql="select latitude, longitude from users where username=:username";
  $query=$pdo->prepare($sql);
  $query->bindParam(':username',$searchUsername,PDO::PARAM_STR);
  $query->execute();
  $result = $query->fetchAll(PDO::FETCH_ASSOC);
  return ["latitude"=> $result[0]['latitude'], "longitude" => $result[0]['longitude']] ;
}

// HANDLE ADD, EDIT, DELETE OF LOT ITEM, AND UPDATE LOCATION OF USER
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if($_SESSION["username"]!=$_GET["username"])
    {
      header('Location: index.php');
      exit();
    }
    if(isset($_POST['contact-action'])){
      switch($_POST['contact-action']){
        case 'update':
        global $servername,$username,$password,$dbname,$conn;
        $instagram = $_POST["instagram"];
        $email = $_POST["email"];
        $telegram = $_POST["telegram"];
        $whatsapp = $_POST["whatsapp"];
        $user = $_GET["username"];

        $sql="update users set instagram=:instagram,email=:email,telegram=:telegram, whatsapp=:whatsapp where username=:username";
        $query=$pdo->prepare($sql);
        $query->bindParam(':username',$user,PDO::PARAM_STR);
        $query->bindParam(':instagram',$instagram,PDO::PARAM_STR);
        $query->bindParam(':email',$email,PDO::PARAM_STR);
        $query->bindParam(':whatsapp',$whatsapp,PDO::PARAM_STR);
        $query->bindParam(':telegram',$telegram,PDO::PARAM_STR);
        $query->execute();
        break;
      }
    }
    else if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
              global $servername,$username,$password,$dbname,$conn,$pdo;
              $sql="insert into lot (item, username) values (:item,:username);";
              $query=$pdo->prepare($sql);
              $query->bindParam(':username',$_GET["username"],PDO::PARAM_STR);
              $query->bindParam(':item',$_POST["item"],PDO::PARAM_STR);
              $query->execute();
              break;

            case 'edit':
              global $servername,$username,$password,$dbname,$conn,$pdo;
              $sql="update lot set item=:item where id=:id and username=:username";
              $query=$pdo->prepare($sql);
              $query->bindParam(':username',$_GET["username"],PDO::PARAM_STR);
              $query->bindParam(':item',$_POST["item"],PDO::PARAM_STR);
              $query->bindParam(':id',$_POST["id"],PDO::PARAM_INT);
              $query->execute();
              break;

            case 'delete':
              global $servername,$username,$password,$dbname,$conn,$pdo;
              $sql="delete from lot where id=:id and username=:username";
              $query=$pdo->prepare($sql);
              $query->bindParam(':username',$_GET["username"],PDO::PARAM_STR);
              $query->bindParam(':id',$_POST["id"],PDO::PARAM_INT);
              $query->execute();
              break;

            case 'updateLocation':
              global $servername,$username,$password,$dbname,$conn,$pdo;
              $sql="update users set latitude=:latitude, longitude=:longitude where username=:username";
              $query=$pdo->prepare($sql);
              $query->bindParam(':username',$_GET["username"],PDO::PARAM_STR);
              $query->bindParam(':latitude',$_POST["latitude"],PDO::PARAM_STR);
              $query->bindParam(':longitude',$_POST["longitude"],PDO::PARAM_STR);
              $query->execute();
              break;
        }
    }
    header('Location: index.php?username='.$_GET["username"]);
    exit();
}
?>

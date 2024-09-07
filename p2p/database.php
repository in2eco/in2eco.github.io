<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "abcd1234";
$dbname = "in2eco";
// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

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
  global $servername,$username,$password,$dbname,$conn;
  $sql = "select name from users where username='".$searchUsername."'";
  $result = $conn->query($sql);
  $result = $result->fetch_assoc();
  return $result["name"];
}

// FIND CONTACT DETAILS OF A USER FROM USERNAME
function findContactFromUsername($searchUsername) {
  global $servername,$username,$password,$dbname,$conn;
  $sql = "select instagram, telegram, email, whatsapp from users where username='".$searchUsername."'";
  $result = $conn->query($sql);
  $result = $result->fetch_assoc();
  return ["instagram" => $result["instagram"], "telegram" => $result["telegram"], "email" => $result["email"], "whatsapp" => $result["whatsapp"]];
}

// FIND LOCATION OF A USER FROM USERNAME
function findLocationFromUsername($searchUsername) {
  global $servername,$username,$password,$dbname,$conn;
  $sql = "select latitude, longitude from users where username='".$searchUsername."'";
  $result = $conn->query($sql);
  $result = $result->fetch_assoc();
  return ["latitude"=> $result['latitude'], "longitude" => $result['longitude']] ;
}

// HANDLE ADD, EDIT, DELETE OF LOT ITEM, AND UPDATE LOCATION OF USER
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['contact-action'])){
      switch($_POST['contact-action']){
        case 'update':
        global $servername,$username,$password,$dbname,$conn;
        $instagram = $_POST["instagram"];
        $email = $_POST["email"];
        $telegram = $_POST["telegram"];
        $whatsapp = $_POST["whatsapp"];
        $user = $_GET["username"];
        $sql = 'update users set instagram="'.$instagram.'",email="'.$email.'",telegram="'.$telegram.'", whatsapp="'.$whatsapp.'" where username="'.$user.'"';
        $result = $conn->query($sql);
        break;
      }
    }
    else if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
            global $servername,$username,$password,$dbname,$conn;
            $sql = 'insert into lot (item, username) values ("'.$_POST["item"].'","'.$_GET["username"].'");';
            $result = $conn->query($sql);
            break;

            case 'edit':
              global $servername,$username,$password,$dbname,$conn;
              $sql = 'update lot set item="'.$_POST["item"].'" where id="'.$_POST["id"].'"';
              $result = $conn->query($sql);
              break;

            case 'delete':
              global $servername,$username,$password,$dbname,$conn;
              $sql = 'delete from lot where id="'.$_POST["id"].'"';
              $result = $conn->query($sql);
              break;

            case 'updateLocation':
              global $servername,$username,$password,$dbname,$conn;
              $sql = 'update users set latitude='.$_POST["latitude"].', longitude='.$_POST["longitude"].' where username="'.$_GET["username"].'"';
              $result = $conn->query($sql);
              break;

            case 'updateContact':
              global $servername,$username,$password,$dbname,$conn;
              $sql = 'update users set email="'.$_POST["email"].'", instagram="'.$_POST["instagram"].'", telegram="'.$_POST['telegram'].'", whatsapp="'.$_POST["whatsapp"].'" where username="'.$_GET["username"].'"';
              $result = $conn->query($sql);
              break;
        }
    }
    header('Location: index.php?username='.$_GET["username"]);
    exit();
}
?>

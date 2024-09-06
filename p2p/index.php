<?php
// Database connection parameters
$servername = "localhost";   // MySQL server
$username = "root";          // MySQL username
$password = "abcd1234";              // MySQL password
$dbname = "in2eco";   // Your database name

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

function findLotData()
{
  global $servername,$username,$password,$dbname,$conn;
  $sql = "SELECT * FROM lot";  // Modify with your table and columns
  $result = $conn->query($sql);

  // Check if the query returns any results
  if ($result->num_rows > 0) {
      // Fetch all rows and save them in $userData
      $lotData = $result->fetch_all(MYSQLI_ASSOC);
  } else {
      echo "No data found in the users table.";
  }
  return $lotData;
}

function findLotDataNearMe()
{
  global $servername,$username,$password,$dbname,$conn;
  $latitude=$_GET["latitude"];
  $longitude=$_GET["longitude"];
  $proximity = 100;
  $sql = "SELECT * FROM lot where username in (select username from users where (latitude-{$latitude}<={$proximity} AND latitude-{$latitude}>=-{$proximity}) AND (longitude-{$longitude}>=-{$proximity} AND longitude-{$longitude}<={$proximity}))";  // Modify with your table and columns


  $result = $conn->query($sql);
  // Check if the query returns any results
  if ($result->num_rows > 0) {
      // Fetch all rows and save them in $userData
      $lotData = $result->fetch_all(MYSQLI_ASSOC);
      return $lotData;
  } else {
      echo "No data found in the users table.";
  }
}

function findLotDataWithUsername()
{
  global $servername,$username,$password,$dbname,$conn;
  $sql = "SELECT * FROM lot where username='".$_GET["username"]."'";  // Modify with your table and columns
  $result = $conn->query($sql);

  // Check if the query returns any results
  if ($result->num_rows > 0) {
      // Fetch all rows and save them in $userData
      $lotData = $result->fetch_all(MYSQLI_ASSOC);
  } else {
      echo "No data found in the users table.";
  }
  return $lotData;
}

function findKeysOfLotDatabase()
{
  global $servername,$username,$password,$dbname,$conn;
  $sql = "DESCRIBE lot";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      // Fetch each row and store the column name
      while ($row = $result->fetch_assoc()) {
          $lotKeys[] = $row['Field'];  // 'Field' column contains the name of each column
      }
  }
  return $lotKeys;
}

function findUserIndexByUsername($searchUsername) {
  global $servername,$username,$password,$dbname,$conn;
  $sql = "select id from users where username='".$searchUsername."'";
  $result = $conn->query($sql);
  $result = $result->fetch_assoc();
  return $result["id"];
}

function findNameFromUsername($searchUsername) {
  global $servername,$username,$password,$dbname,$conn;
  $sql = "select name from users where username='".$searchUsername."'";
  $result = $conn->query($sql);
  $result = $result->fetch_assoc();
  return $result["name"];
}

function findContactFromUsername($searchUsername) {
  global $servername,$username,$password,$dbname,$conn;
  $sql = "select instagram, telegram, email, whatsapp from users where username='".$searchUsername."'";
  $result = $conn->query($sql);
  $result = $result->fetch_assoc();
  return ["instagram" => $result["instagram"], "telegram" => $result["telegram"], "email" => $result["email"], "whatsapp" => $result["whatsapp"]];
}

function findLocationFromUsername($searchUsername) {
  global $servername,$username,$password,$dbname,$conn;
  $sql = "select latitude, longitude from users where username='".$searchUsername."'";
  $result = $conn->query($sql);
  $result = $result->fetch_assoc();
  return ["latitude"=> $result['latitude'], "longitude" => $result['longitude']] ;
}

// Handle form submissions for adding, editing, and deleting data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action'])) {
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
        }

        // Save changes back to the JSON file
        // file_put_contents($lotDataFile, json_encode(array_values($lotData), JSON_PRETTY_PRINT));

        // Redirect to avoid form resubmission
        header('Location: index.php?username='.$_GET["username"]);
        exit();
    }
}


// // Print the detected keys for debugging
// echo "<pre>Detected Keys: ";
// print_r($lotKeys);
// echo "</pre>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoT</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="user.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<body>
  <div class="dashboard">
      <?php if(isset($_GET['username'])): ?>
        <h1><?= findNameFromUsername($_GET["username"])?></h1>
        <hr>
        <?php include 'contact.php';?>
        <hr>
        <?php include 'location.php'?>
        <hr>
        <div id="lot-container">
        <h2>Library of Things</h2>
        <table id="lotTable" class="display">
            <thead>
                <tr>
                    <?php
                      $lotKeys = findKeysOfLotDatabase();
                      foreach ($lotKeys as $lotKey): ?>
                      <th class="<?=$lotKey?>" ><?= htmlspecialchars(ucfirst($lotKey)) ?></th>
                    <?php endforeach; ?>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>

        <button onclick="showAddForm()">Add New Item</button>
        </div>

        <!-- Form Modal -->
        <div id="formModal" style="display:none;">
            <form id="dataForm" method="POST">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="action" id="action">
                <?php foreach ($lotKeys as $lotKey): ?>
                    <?php if ($lotKey !== 'id' && $lotKey !== 'username'): ?>
                        <label><?= ucfirst($lotKey) ?>: <input type="text" name="<?= $lotKey ?>" id="<?= $lotKey ?>" required></label>
                    <?php endif; ?>
                    <?php if ($lotKey === 'username'): ?>
                        <input type="hidden" name="<?= $lotKey ?>" id="<?= $lotKey ?>" value="<?= $_GET['username']?>">
                    <?php endif; ?>
                <?php endforeach; ?>
                <button type="submit">Save</button>
                <button type="button" onclick="hideForm()">Cancel</button>
            </form>
        </div>

        <script>
        $(document).ready(function() {
            var url = "fetchUserData.php?username=" + "<?=$_GET['username']?>";
            $('#lotTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                  "url": url
                },
                "createdRow": function(row, data, dataIndex) {
                    $('td', row).eq(0).addClass('id');
                    $('td', row).eq(1).addClass('username');
                    $('td', row).eq(2).addClass('item');
                },
               "lengthMenu": [ 5, 10, 25, 50, 100 ],
               "pageLength": 5,
                "columns": [
                    { "data": "id" },
                    { "data": "username" },
                    { "data": "item"},
                    { "data": "action"}
                ],
                "columnDefs": [
                    {
                        // "targets": [1,2], // Column index for contact
                        // "orderable": false // Optional: Disable sorting for this column if necessary
                    },
                    {
                      "targets": [],
                      "visible": false
                    }
                ]
            });
        });

        // Show the add form
        function showAddForm() {
            $('#action').val('add');
            $('#id').val('');
            <?php foreach ($lotKeys as $lotKey): ?>
                <?php if ($lotKey !== 'id' && $lotKey !== 'username'): ?>
                    $('#<?= $lotKey ?>').val('');
                <?php endif; ?>
            <?php endforeach; ?>
            $('#formModal').show();
        }

        // Show the edit form with pre-filled data
        function editData(row) {
            $('#action').val('edit');
            $('#id').val(row.id);
            <?php foreach ($lotKeys as $lotKey): ?>
                <?php if ($lotKey !== 'id'): ?>
                    $('#<?= $lotKey ?>').val(row['<?= $lotKey ?>']);
                <?php endif; ?>
            <?php endforeach; ?>
            $('#formModal').show();
        }

        // Handle delete action
        function deleteData(id) {
            if (confirm('Are you sure you want to delete this entry?')) {
                $('<form>', {
                    'method': 'POST',
                    'html': '<input type="hidden" name="id" value="' + id + '"><input type="hidden" name="action" value="delete">'
                }).appendTo(document.body).submit();
            }
        }

        // Hide the form
        function hideForm() {
            $('#formModal').hide();
        }
        </script>
        <hr>
      <?php else: ?>
        <h2>Library of Things</h2>
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Contact</th>
                    <th>Distance</th>
                </tr>
            </thead>
        </table>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script>
        getLocationByIP();
        function getLocationByIP() {
            // Fetch location data based on IP address
            fetch('https://ipapi.co/json/')
                .then(response => response.json())
                .then(data => {
                  const latitude = data.latitude;
                  const longitude = data.longitude;
                  console.log(latitude);
                  console.log(longitude);
                  $('#example').DataTable({
                     "processing": true,
                     "serverSide": true,
                     "ajax": {
                       "url":"server_processing.php?latitude="+latitude+"&longitude="+longitude
                    },
                    "lengthMenu": [ 5, 10, 25, 50, 100 ],
                    "pageLength": 5,
                     "columns": [
                         { "data": "item" },
                         { "data": "contact" },
                         { "data": "distance"}
                     ],
                     "columnDefs": [
                         {
                             "targets": [1,2], // Column index for contact
                             "orderable": false // Optional: Disable sorting for this column if necessary
                         },
                            {
                              "targets": [2],
                              "visible": false
                            }
                     ]
                  });
                })
                .catch(error => {
                    console.error('Error fetching IP location:', error);
                    document.getElementById('output').innerText = 'Could not determine location.';
                });
        }

        // getLocation();
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(sendPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }
        function sendPosition(position) {
           // Extract latitude and longitude
           const latitude = position.coords.latitude;
           const longitude = position.coords.longitude;
           $('#example').DataTable({
               "processing": true,
               "serverSide": true,
               "ajax": {
                 "url":"server_processing.php?latitude="+latitude+"&longitude="+longitude
              },
              "lengthMenu": [ 5, 10, 25, 50, 100 ],
              "pageLength": 5,
               "columns": [
                   { "data": "item" },
                   { "data": "contact" },
                   { "data": "distance"}
               ],
               "columnDefs": [
                   {
                       "targets": [1,2], // Column index for contact
                       "orderable": false // Optional: Disable sorting for this column if necessary
                   },
                   {
                     "targets": [2],
                     "visible": false
                   }
               ]
           });
        }
        </script>
      <?php endif; ?>



</body>
</html>

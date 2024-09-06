<?php
// Database connection parameters
$servername = "localhost";   // MySQL server
$username = "root";          // MySQL username
$password = "abcd1234";              // MySQL password
$dbname = "in2eco";   // Your database name

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// SQL query to fetch data from a table
$sql = "SELECT * FROM users";  // Modify with your table and columns
$result = $conn->query($sql);

// Check if the query returns any results
if ($result->num_rows > 0) {
    // Fetch all rows and save them in $userData
    $usersData = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "No data found in the users table.";
}

// SQL query to fetch data from a table
$sql = "SELECT * FROM lot";  // Modify with your table and columns
$result = $conn->query($sql);

// Check if the query returns any results
if ($result->num_rows > 0) {
    // Fetch all rows and save them in $userData
    $lotData = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "No data found in the users table.";
}
// print_r($lotData );

// // Define the path to the JSON file
// $lotDataFile = 'files/data/lot.json';
// $usersDataFile = 'files/data/user.json';

// // Read and decode the JSON data
// $lotData = json_decode(file_get_contents($lotDataFile), true);
// $usersData = json_decode(file_get_contents($usersDataFile), true);

// Print the loaded data for debugging
// echo "<pre>Loaded Data: ";
// print_r($lotData);
// echo "</pre>";

// // Detect keys from the first element of the JSON array
// $lotKeys = !empty($lotData) ? array_keys($lotData[0]) : [];
// $userKeys = !empty($usersData) ? array_keys($usersData[0]) : [];

// Function to find the index of a user by username
function findUserIndexByUsername($usersData, $searchUsername) {
    // Iterate through the array with indexes using foreach
    foreach ($usersData as $index => $user) {
        // Check if the username matches the given username
        if ($user['username'] === $searchUsername) {
            return $index; // Return the index of the matching user
        }
    }
    // Return -1 if no matching username is found
    return -1;
}

function findNameFromUsername($usersData, $searchUsername) {
    foreach ($usersData as $user) {
        // Check if the username matches
        if ($user['username'] === $searchUsername) {
            return $user['name'];
        }
    }
    // Return null if no match is found
    return null;
}

function findLocationFromUsername($usersData, $searchUsername) {
    foreach ($usersData as $user) {
        // Check if the username matches
        if ($user['username'] === $searchUsername) {
            return ["latitude"=> $user['latitude'], "longitude" => $user['longitude']] ;
        }
    }
    // Return null if no match is found
    return null;
}

function findTalk2MeFromUsername($usersData, $searchUsername) {
    foreach ($usersData as $user) {
        // Check if the username matches
        if ($user['username'] === $searchUsername) {
            return $user['talk2me'];
        }
    }
    // Return null if no match is found
    return null;
}

// // Print the detected keys for debugging
// echo "<pre>Detected Keys: ";
// print_r($lotKeys);
// echo "</pre>";

// Handle form submissions for adding, editing, and deleting data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Print the posted data for debugging
    // echo "<pre>POST Data: ";
    // print_r($_POST);
    // echo "</pre>";

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                // Add a new entry with dynamic keys
                $newEntry = ['id' => end($lotData)['id'] + 1];
                foreach ($lotKeys as $lotKey) {
                    if ($lotKey !== 'id') {
                        $newEntry[$lotKey] = $_POST[$lotKey];
                    }
                }

                // Print the new entry for debugging
                echo "<pre>New Entry: ";
                print_r($newEntry);
                echo "</pre>";

                $lotData[] = $newEntry;
                break;

            case 'edit':
                // Edit an existing entry with dynamic keys
                foreach ($lotData as &$entry) {
                    if ($entry['id'] == $_POST['id']) {
                        foreach ($lotKeys as $lotKey) {
                            if ($lotKey !== 'id') {
                                $entry[$lotKey] = $_POST[$lotKey];
                            }
                        }
                    }
                }

                // Print the edited data for debugging
                echo "<pre>Edited Data: ";
                print_r($lotData);
                echo "</pre>";

                break;

            case 'delete':
                // Delete an entry
                $lotData = array_filter($lotData, function ($entry) {
                    return $entry['id'] != $_POST['id'];
                });

                // Print the data after deletion for debugging
                echo "<pre>Data After Deletion: ";
                print_r($lotData);
                echo "</pre>";
                break;
            case 'updateLocation':
                // Update location
                foreach ($usersData as &$entry) {
                    if ($entry['id'] == $_POST['id']) {
                        foreach ($lotKeys as $lotKey) {
                            if ($lotKey !== 'id') {
                                $entry[$lotKey] = $_POST[$lotKey];
                            }
                        }
                    }
                }

                // Print the edited data for debugging
                echo "<pre>Edited Data: ";
                print_r($usersData);
                echo "</pre>";

                break;
        }

        // Save changes back to the JSON file
        file_put_contents($lotDataFile, json_encode(array_values($lotData), JSON_PRETTY_PRINT));

        // Redirect to avoid form resubmission
        header('Location: index.php?username='.$_GET["username"]);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LoT</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="user.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <style>
      .id, .username
      {
        display: none;
      }
      #lot-container
      {
        /* width:50%; */
        margin: auto;
      }
    </style>
</head>
<body>
  <div class="dashboard">
      <?php if(isset($_GET['username'])): ?>
        <div id="profile-container">
          <figure><img id="profile-photo" src="files/profile_photo/<?=  (($_GET["username"]))?>.jpg" alt='profile photo'></img></figure>
          <!-- <hr> -->
          <h1><?= findNameFromUsername($usersData,$_GET["username"])?></h1>
          <p></p>
        </div>
        <hr>
        <h2>Location</h2>
        <div id="map"></div>
        <button onclick="getCurrentLocation()">Set Current Location</button>
        <script>
          // Initialize the map and set its view to the specified latitude and longitude
          <?php $location = findLocationFromUsername($usersData, $_GET["username"])?>
          var map = L.map('map').setView([<?= $location["latitude"]?>,<?= $location["longitude"]?>], 16); // Example coordinates: London

          // Add the OSM tile layer to the map
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
              maxZoom: 19,
              attribution: '© OpenStreetMap contributors'
          }).addTo(map);

          // Latitude and Longitude for the marker
          var latitude = <?= $location["latitude"]?>;  // Example latitude
          var longitude = <?= $location["longitude"]?>;  // Example longitude

          // Create and add the marker to the map
          var marker = L.marker([latitude, longitude]).addTo(map);

          // Optional: Add a popup to the marker
          marker.bindPopup("Leh, Ladakh").openPopup();

          // JavaScript function to get the current location
          function updateUserLocation() {
              // Check if the Geolocation API is available
              if (navigator.geolocation) {
                  // Get the current position of the user
                  navigator.geolocation.getCurrentPosition(
                      // Success callback
                      function(position) {
                          // Extract latitude and longitude
                          var latitude = position.coords.latitude;
                          var longitude = position.coords.longitude;
                          // Send the coordinates to the server using jQuery AJAX
                          $('<form>', {
                              'method': 'POST',
                              'html': '<input type="hidden" name="latitude" value="' + latitude + '"><input type="hidden" name="longitude" value="'+ longitude +'"><input type="hidden" name="action" value="updateLocation">';
                          }).appendTo(document.body).submit();
                      },
                      // Error callback
                      function(error) {
                          console.error("Error getting location: ", error.message);
                      }
                  );
              } else {
                  alert("Geolocation is not supported by this browser.");
              }
          }
        </script>
        <hr>
        <div id="lot-container">
        <h2>Library of Things</h2>
        <table id="dataTable" class="display">
            <thead>
                <tr>
                    <?php foreach ($lotKeys as $lotKey): ?>
                        <th class="<?=$lotKey?>" ><?= htmlspecialchars(ucfirst($lotKey)) ?></th>
                    <?php endforeach; ?>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lotData as $row): if($row["username"]===$_GET["username"]): ?>
                    <tr>
                        <?php foreach ($lotKeys as $lotKey):?>
                            <td class="<?=$lotKey?>" ><?= htmlspecialchars($row[$lotKey]) ?></td>
                        <?php endforeach; ?>
                        <td>
                            <button onclick="editData(<?= htmlspecialchars(json_encode($row)) ?>)">Edit</button>
                            <button onclick="deleteData(<?= $row['id'] ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endif; endforeach; ?>
            </tbody>
        </table>

        <button onclick="showAddForm()">Add New</button>
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
            $('#dataTable').DataTable();
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
        <div id="lot-container">
        <h2>Library of Things</h2>
        <table id="dataTable" class="display">
            <thead>
                <tr>
                    <?php foreach ($lotKeys as $lotKey): if($lotKey === "item"):?>
                        <th><?= htmlspecialchars(ucfirst($lotKey)) ?></th>
                        <th>User</th>
                        <th>Contact</th>
                    <?php endif;endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lotData as $row): ?>
                    <tr>
                        <?php foreach ($lotKeys as $lotKey): if($lotKey === "item"):?>
                            <td class="<?=$lotKey?>" ><?= htmlspecialchars($row[$lotKey]) ?></td>
                            <td><?= htmlspecialchars(findNameFromUsername($usersData,$row["username"])); ?></td>
                            <td>
                              <?php
                                foreach ($userKeys as $userKey):
                                  if(isset($usersData[findUserIndexByUsername($usersData,$row["username"])][$userKey])):
                                    if($userKey=="instagram"):
                                      echo '<a href="https://www.instagram.com/'.$usersData[findUserIndexByUsername($usersData,$row["username"])]["instagram"].'"><img class="logo" src="files/logo/instagram.png"></a>';
                                    elseif($userKey=="telegram"):
                                      echo '<a href="https://t.me/'.$usersData[findUserIndexByUsername($usersData,$row["username"])]["telegram"].'"><img class="logo" src="files/logo/telegram.png"></a>';
                                      elseif($userKey=="email"):
                                        echo '<a href="mailto:'.$usersData[findUserIndexByUsername($usersData,$row["username"])]["email"].'"><img class="logo" src="files/logo/email.png"></a>';
                                    endif;
                                  endif;
                                endforeach;
                              ?>
                            </td>
                        <?php endif; endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
              "columnDefs": [
            { "orderable": false, "targets": 2 }]
            });
        });
        </script>
      <?php endif; ?>



</body>
</html>

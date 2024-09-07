<?php include 'database.php'?>

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
      <?php if(isset($_GET['username'])):
        include 'user_login_validation.php';
        ?>
        <h1><?= findNameFromUsername($_GET["username"])?></h1>
        <?php include 'contact.php';?>
        <button onclick="showContactForm()">Update Contact</button>
        <!-- FORM FOR UPDATING CONTACT -->
        <div id="contact-form-container" style="display:none;">
            <form id="contact-form" method="POST">
                <input type="hidden" name="contact-action" id="contact-action">
                <label>Instagram<input id="form-instagram-contact" type="text" name="instagram"></label><br>
                <label>Telegram<input id="form-telegram-contact" type="text" name="telegram"></label><br>
                <label>Email<input id="form-email-contact" type="text" name="email"></label><br>
                <label>Whatsapp<input id="form-whatsapp-contact" type="text" name="whatsapp"></label><br>
                <button type="submit">Save</button>
                <button type="button" onclick="hideContactForm()">Cancel</button>
            </form>
        </div>

        <script>
          function showContactForm(){
            $('#contact-form-container').show();
            <?php $contact = findContactFromUsername($_GET["username"]);?>
            $('#form-instagram-contact').val("<?=$contact["instagram"]?>");
            $('#form-email-contact').val("<?=$contact["email"]?>");
            $('#form-telegram-contact').val("<?=$contact["telegram"]?>");
            $('#form-whatsapp-contact').val("<?=$contact["whatsapp"]?>");
            $('#contact-action').val("update");
          }
          function hideContactForm()
          {
            $('#contact-form-container').hide();
          }
        </script>
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
                      <th class="<?=$lotKey?>" ><?= (ucfirst($lotKey)) ?></th>
                    <?php endforeach; ?>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>


        <button onclick="showAddForm()">Add New Item</button>
        </div>

        <!-- FORM FOR ADDING, EDITING LOT ITEM -->
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

        <form action="logout.php" method="POST">
          <button type="submit" class="logout-button">Logout</button>
        </form>

        <script>
        $(document).ready(function() {
            var url = "fetchLotUser.php?username=" + "<?=$_GET['username']?>";
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
        // SHOW THE ADD LOT ITEM FORM
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

        // SHOW THE EDIT LOT ITEM FORM
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

        // DELETE LOT ITEM
        function deleteData(id) {
            if (confirm('Are you sure you want to delete this entry?')) {
                $('<form>', {
                    'method': 'POST',
                    'html': '<input type="hidden" name="id" value="' + id + '"><input type="hidden" name="action" value="delete">'
                }).appendTo(document.body).submit();
            }
        }

        // HIDE FORM
        function hideForm() {
            $('#formModal').hide();
        }
        </script>
        <hr>
      <?php else:?>
        <h2>Library of Things</h2>
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Contact</th>
                    <th>Distance<sup>1</sup> (km)</th>
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
                  // console.log(latitude);
                  // console.log(longitude);
                  $('#example').DataTable({
                     "processing": true,
                     "serverSide": true,
                     "ajax": {
                       "url":"fetchLotTableNearMe.php?latitude="+latitude+"&longitude="+longitude
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
                              "targets": [],
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
                 "url":"fetchLotTableNearMe.php?latitude="+latitude+"&longitude="+longitude
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
                     "targets": [],
                     "visible": false
                   }
               ]
           });
        }
        </script>
        <div id="user-access-container">
          <div class="login-container">
            <h2>Login</h2>
            <form action="login.php" method="POST">
              <input type="text" name="username" placeholder="Enter Username" required>
              <input type="password" name="password" placeholder="Enter Password" required>
              <button type="submit">Login</button>
            </form>
          </div>
          <div class="signup-container">
            <h2>Sign Up</h2>
            <form action="signup.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="text" name="name" placeholder="Name" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Sign Up</button>
            </form>
          </div>
        </div>
      <?php endif; ?>


<!-- <sup>1</sup> Haversine distance between two coordinates -->
<!-- <strong>Reference/Credits:</strong>
<ul>

<li>Table was constructed using <a href="https://datatables.net/">Datatable</a></li>
</ul> -->
</body>
</html>

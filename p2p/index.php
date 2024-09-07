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
      <?php
        if(isset($_GET['username'])):
          include 'user_login_validation.php';
          include 'lotTableUser.php';
        else:
          include 'lotTableNearMe.php';
        endif;?>


<!-- <sup>1</sup> Haversine distance between two coordinates -->
<!-- <strong>Reference/Credits:</strong>
<ul>

<li>Table was constructed using <a href="https://datatables.net/">Datatable</a></li>
</ul> -->
</body>
</html>

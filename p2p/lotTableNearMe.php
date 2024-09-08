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
// getLocation();
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
               "url":"server/fetchLotTableNearMe.php?latitude="+latitude+"&longitude="+longitude
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
         "url":"server/fetchLotTableNearMe.php?latitude="+latitude+"&longitude="+longitude
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
  <div id="login-container">
    <h2>Login</h2>
    <form action="server/login.php" method="POST">
      <input type="text" name="username" placeholder="Enter Username" required>
      <input type="password" name="password" placeholder="Enter Password" required>
      <button type="submit">Login</button>
    </form>
  </div>
  <div id="signup-container">
    <h2>Sign Up</h2>
    <form action="server/signup.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="text" name="name" placeholder="Name" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
    </form>
  </div>
</div>

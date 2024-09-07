<h2>Location</h2>
<div id="map"></div>
<button onclick="updateUserLocation()">Update Location</button>
<script>
  <?php $location = findLocationFromUsername($_GET["username"]);
  if(isset($location['latitude']) && isset($location['longitude'])): ?>
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
  <?php endif;?>

  // Optional: Add a popup to the marker
  // marker.bindPopup("Leh, Ladakh").openPopup();

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
                  // console.log(latitude);
                  // console.log(longitude);
                  // Send the coordinates to the server using jQuery AJAX
                  $('<form>', {
                      'method': 'POST',
                      'html': '<input type="hidden" name="latitude" value="' + latitude + '"><input type="hidden" name="longitude" value="'+ longitude +'"><input type="hidden" name="action" value="updateLocation">'
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

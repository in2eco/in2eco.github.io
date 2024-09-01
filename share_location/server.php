<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lat = $_POST['lat'];
    $lon = $_POST['lon'];
    $label = $_POST['label'];

    // Format data
    $data = "Label: $label, Latitude: $lat, Longitude: $lon\n";

    // Save to file
    $file = 'locations.txt';
    if (file_put_contents($file, $data, FILE_APPEND)) {
        echo "Success";
    } else {
        echo "Error saving the data.";
    }
}
?>

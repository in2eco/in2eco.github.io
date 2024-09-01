let map;
let currentLocationMarker;
let movableMarker;
let markers = [];
let table;
let isCurrentMarkerVisible = true;
const proximityThreshold = 0.01; // Threshold to determine proximity (in degrees)

function initMap() {
    map = L.map('map').setView([0, 0], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };

                map.setView(userLocation, 15);

                // Add current location marker (not draggable)
                currentLocationMarker = L.marker(userLocation, {
                    icon: L.icon({
                        iconUrl: 'current-location-icon.png', // Path to icon for current location
                        iconSize: [25, 41], // Size of the icon
                        iconAnchor: [12, 41], // Point of the icon which will correspond to marker's location
                        popupAnchor: [0, -41] // Point from which the popup should open relative to the iconAnchor
                    }),
                    draggable: false
                }).addTo(map);
                currentLocationMarker.bindPopup("Current Location");

                // Add movable marker (draggable)
                movableMarker = L.marker(userLocation, {
                    icon: L.icon({
                        iconUrl: 'movable-marker-icon.png', // Path to icon for movable marker
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [0, -41]
                    }),
                    draggable: true
                }).addTo(map);
                movableMarker.bindPopup("Drag to set new location");

                movableMarker.on('dragend', (e) => {
                    const latlng = e.target.getLatLng();
                    document.getElementById("marker-info").textContent =
                        `Movable marker adjusted to Latitude: ${latlng.lat.toFixed(5)}, Longitude: ${latlng.lng.toFixed(5)}`;
                    updateLastUpdatedTime();
                });

                loadMarkers(); // Load markers on initialization
            },
            () => {
                alert("Geolocation failed. Please allow location access.");
            }
        );
    } else {
        alert("Geolocation is not supported by your browser.");
    }

    document.getElementById("set-current-location").addEventListener("click", () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };

                    if (currentLocationMarker) {
                        currentLocationMarker.setLatLng(userLocation);
                        if (movableMarker) {
                            movableMarker.setLatLng(userLocation);
                        }
                        map.setView(userLocation);
                        document.getElementById("marker-info").textContent =
                            `Movable marker set to current location: Latitude: ${userLocation.lat.toFixed(5)}, Longitude: ${userLocation.lng.toFixed(5)}`;
                        updateLastUpdatedTime();
                    }
                },
                () => {
                    alert("Failed to get current location.");
                }
            );
        }
    });

    document.getElementById("save-marker").addEventListener("click", () => {
        if (movableMarker) {
            const label = document.getElementById("marker-label").value || 'No Label';
            const latlng = movableMarker.getLatLng();
            const now = new Date().toLocaleString();

            const newMarker = {
                label,
                latlng,
                marker: L.marker(latlng, {
                    icon: L.icon({
                        iconUrl: 'saved-marker-icon.png', // Path to icon for saved marker
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [0, -41]
                    }),
                    draggable: false // Saved markers are not draggable
                }).addTo(map),
                lastUpdated: now,
                showExactLocation: true
            };
            newMarker.marker.bindPopup(label);

            markers.push(newMarker);

            updateTable();
            document.getElementById("marker-info").textContent =
                `Movable marker saved at Latitude: ${latlng.lat.toFixed(5)}, Longitude: ${latlng.lng.toFixed(5)} with label: ${label}`;
            saveMarkers(); // Save markers to the server
        } else {
            alert("No movable marker is placed yet.");
        }
    });

    document.getElementById("toggle-current-location").addEventListener("click", () => {
        if (currentLocationMarker) {
            isCurrentMarkerVisible = !isCurrentMarkerVisible;
            currentLocationMarker.setOpacity(isCurrentMarkerVisible ? 1 : 0.2); // Show or hide marker
            document.getElementById("marker-info").textContent =
                isCurrentMarkerVisible ?
                "Current marker is visible." :
                "Current marker is hidden.";

            // Update the table to show only the closest marker
            if (!isCurrentMarkerVisible) {
                showClosestMarker();
            }
        }
    });

    // Initialize DataTable
    table = $('#places-table').DataTable();
}

function updateLastUpdatedTime() {
    document.getElementById("marker-info").textContent += ` Last updated: ${new Date().toLocaleString()}`;
}

function updateTable() {
    table.clear();

    markers.forEach((place, index) => {
        table.row.add([
            place.label,
            place.latlng.lat.toFixed(5),
            place.latlng.lng.toFixed(5),
            `<button onclick="editPlace(${index})">Edit</button> <button onclick="deletePlace(${index})">Delete</button>`
        ]).draw();
    });
}

function showClosestMarker() {
    if (!movableMarker) return;

    const userLatLng = movableMarker.getLatLng();
    let closestMarker = null;

    markers.forEach((place) => {
        const distance = userLatLng.distanceTo(place.latlng);
        if (distance < proximityThreshold) {
            closestMarker = place;
        }
    });

    markers.forEach((place) => {
        place.marker.setOpacity(place === closestMarker ? 1 : 0.2);
    });

    if (closestMarker) {
        document.getElementById("marker-info").textContent =
            `Showing closest marker: ${closestMarker.label}. Latitude: ${closestMarker.latlng.lat.toFixed(5)}, Longitude: ${closestMarker.latlng.lng.toFixed(5)}`;
    } else {
        document.getElementById("marker-info").textContent =
            "No marker is within proximity.";
    }
}

function editPlace(index) {
    const newLabel = prompt("Enter new label:", markers[index].label);
    if (newLabel !== null) {
        markers[index].label = newLabel;
        markers[index].marker.bindPopup(newLabel).openPopup();
        markers[index].lastUpdated = new Date().toLocaleString();

        updateTable();
        saveMarkers(); // Save markers to the server after edit
    }
}

function deletePlace(index) {
    map.removeLayer(markers[index].marker);
    markers.splice(index, 1);

    updateTable();
    saveMarkers(); // Save markers to the server after delete
}

function saveMarkers() {
    fetch('server.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(markers.map(marker => ({
            label: marker.label,
            latlng: {
                lat: marker.latlng.lat,
                lng: marker.latlng.lng
            },
            lastUpdated: marker.lastUpdated,
            showExactLocation: marker.showExactLocation
        })))
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            console.log("Markers saved successfully.");
        } else {
            console.error("Failed to save markers.");
        }
    });
}

function loadMarkers() {
    fetch('server.php')
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                markers = data.map(marker => ({
                    ...marker,
                    latlng: L.latLng(marker.latlng.lat, marker.latlng.lng),
                    marker: L.marker([marker.latlng.lat, marker.latlng.lng], {
                        icon: L.icon({
                            iconUrl: 'saved-marker-icon.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [0, -41]
                        }),
                        draggable: false // Saved markers are not draggable
                    }).addTo(map)
                    .bindPopup(marker.label)
                }));
                updateTable();
            } else {
                console.log("No saved markers to display.");
            }
        });
}

// Initialize the map on page load
initMap();

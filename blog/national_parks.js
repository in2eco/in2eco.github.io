
    var map = L.map('map1', {
    center: [37.146, -114.758],
    zoom: 6,
    zoomControl: true,          // Disable zoom control buttons
    scrollWheelZoom: false,      // Disable scroll wheel zoom
    doubleClickZoom: false,      // Disable double click zoom
    boxZoom: false,              // Disable box zoom
    keyboard: false,             // Disable keyboard zoom
    dragging: true              // Optional: Disable dragging
    });
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    var crossIcon = L.icon({
      iconUrl: 'data:image/svg+xml;base64,' + btoa(`
       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32">
         <line x1="0" y1="0" x2="26" y2="26" stroke="black" stroke-width="4"/>
         <line x1="26" y1="0" x2="0" y2="26" stroke="black" stroke-width="4"/>
       </svg>`),
     iconSize: [26, 26], // Size of the icon
     iconAnchor: [13, 13], // Point of the icon which will correspond to marker's location
     popupAnchor: [0, -13] // Point from which the popup should open relative to the iconAnchor
  });
    // var marker = L.marker([36.452,-117.120]).addTo(map);
    // marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();
   var markers = [
      { coords: [36.452,-117.120], popup: "Death valley" },
      { coords: [36.1394, -115.4313], popup: "Red rock canyon" },
      { coords: [37.3265,-113.0047], popup: "Zion" },
     // { coords: [36.1684,-115.1498], popup: "Las Vegas" },
     { coords: [37.5119,-111.4975], popup: "Grand staircase" },
     { coords: [37.6229,-111.08], popup: "Glen canyon" },
     { coords: [36.3107,-112.2981], popup: "Grand canyon" },
     { coords: [36.8804530, -111.5161335], popup: "Horseshoe bend" },
      { coords: [37.5734,-112.1848], popup: "Bryce canyon" }
    ];

    markers.forEach(function(marker) {
      var m = L.marker(marker.coords,{ icon: crossIcon }).addTo(map);
      m.bindPopup(marker.popup);
    });


     // var map = L.map('map2').setView([36.523,-119.828], 6);
     var map = L.map('map2', {
     center: [36.523,-120.528],
     zoom: 6,
     zoomControl: true,          // Disable zoom control buttons
     scrollWheelZoom: false,      // Disable scroll wheel zoom
     doubleClickZoom: false,      // Disable double click zoom
     boxZoom: false,              // Disable box zoom
     keyboard: false,             // Disable keyboard zoom
     dragging: true              // Optional: Disable dragging
     });
     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
       attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
     }).addTo(map);
     var crossIcon = L.icon({
       iconUrl: 'data:image/svg+xml;base64,' + btoa(`
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32">
          <line x1="0" y1="0" x2="26" y2="26" stroke="black" stroke-width="4"/>
          <line x1="26" y1="0" x2="0" y2="26" stroke="black" stroke-width="4"/>
        </svg>`),
      iconSize: [26, 26], // Size of the icon
      iconAnchor: [13, 13], // Point of the icon which will correspond to marker's location
      popupAnchor: [0, -13] // Point from which the popup should open relative to the iconAnchor
   });

     // var marker = L.marker([36.452,-117.120]).addTo(map);
     // marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();
     var markers = [
       { coords: [37.8402,-119.5107], popup: "Yosemite" },
       { coords: [36.4964,-118.5548], popup: "Sequoia" },
       // { coords: [37.7740,-122.4193], popup: "San Francisco" },
       { coords: [34.4211,-119.7015], popup: "Santa Barbara" },
       { coords: [37.99743, -122.98225], popup: "Elephant seal overlook" },
       { coords: [37.8963,-122.5797], popup: "Muir woods national monument" }
     ];

     markers.forEach(function(marker) {
       var m = L.marker(marker.coords,{ icon: crossIcon }).addTo(map);
       m.bindPopup(marker.popup);
     });


       // var map = L.map('map3').setView([42.22,-110.402], 5);
       var map = L.map('map3', {
   center: [42.22,-110.402],
   zoom: 5,
   zoomControl: true,          // Disable zoom control buttons
   scrollWheelZoom: false,      // Disable scroll wheel zoom
   doubleClickZoom: false,      // Disable double click zoom
   boxZoom: false,              // Disable box zoom
   keyboard: false,             // Disable keyboard zoom
   dragging: true          // Optional: Disable dragging
 });

       L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
         attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
       }).addTo(map);
       var crossIcon = L.icon({
         iconUrl: 'data:image/svg+xml;base64,' + btoa(`
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32">
            <line x1="0" y1="0" x2="26" y2="26" stroke="black" stroke-width="4"/>
            <line x1="26" y1="0" x2="0" y2="26" stroke="black" stroke-width="4"/>
          </svg>`),
        iconSize: [26, 26], // Size of the icon
        iconAnchor: [13, 13], // Point of the icon which will correspond to marker's location
        popupAnchor: [0, -13] // Point from which the popup should open relative to the iconAnchor
     });
       // var marker = L.marker([36.452,-117.120]).addTo(map);
       // marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();
       var markers = [
         { coords: [44.6198,-110.5499], popup: "Yellowstone" },
         { coords: [43.8107,-110.6296], popup: "Grand Teton" },
         { coords: [40.7618,-111.9012], popup: "Salt lake city" },
         { coords: [38.7252,-109.5612], popup: "Arches" },
         { coords: [38.16664,-109.98400], popup: "Canyonlands" }
       ];

       markers.forEach(function(marker) {
         var m = L.marker(marker.coords,{ icon: crossIcon }).addTo(map);
         m.bindPopup(marker.popup);
       });


         var map = L.map('map-overall', {
     center: [40.72,-115.802],
     zoom: 5,
     zoomControl: true,          // Disable zoom control buttons
     scrollWheelZoom: false,      // Disable scroll wheel zoom
     doubleClickZoom: false,      // Disable double click zoom
     boxZoom: false,              // Disable box zoom
     keyboard: false,             // Disable keyboard zoom
     dragging: true          // Optional: Disable dragging
   });
         L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
           attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
         }).addTo(map);
         var crossIcon = L.icon({
           iconUrl: 'data:image/svg+xml;base64,' + btoa(`
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32">
              <line x1="0" y1="0" x2="26" y2="26" stroke="black" stroke-width="4"/>
              <line x1="26" y1="0" x2="0" y2="26" stroke="black" stroke-width="4"/>
            </svg>`),
          iconSize: [26, 26], // Size of the icon
          iconAnchor: [13, 13], // Point of the icon which will correspond to marker's location
          popupAnchor: [0, -13] // Point from which the popup should open relative to the iconAnchor
       });
         // var marker = L.marker([36.452,-117.120]).addTo(map);
         // marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();
         var markers = [
           { coords: [37.8402,-119.5107], popup: "Yosemite" },
           { coords: [37.1319,-122.3252], popup: "Elephant seal overlook" },
           { coords: [37.8963,-122.5797], popup: "Muir woods national monument" },
           { coords: [44.6198,-110.5499], popup: "Yellowstone" },
           { coords: [43.8107,-110.6296], popup: "Grand Teton" },
           { coords: [36.4964,-118.5548], popup: "Sequoia" },
           { coords: [38.7252,-109.5612], popup: "Arches" },
           { coords: [38.16664,-109.98400], popup: "Canyonlands" },
           { coords: [36.452,-117.120], popup: "Death valley" },
           { coords: [37.3265,-113.0047], popup: "Zion" },
           { coords: [36.3107,-112.2981], popup: "Grand canyon" },
           { coords: [37.5734,-112.1848], popup: "Bryce canyon" }
         ];

         markers.forEach(function(marker) {
           var m = L.marker(marker.coords,{ icon: crossIcon }).addTo(map);
           m.bindPopup(marker.popup);
         });

   // 			var textOverlays = [
   //   { coords: [44.6198,-110.5499], text: "Yellostone" },
   //   { coords: [37.3265,-113.0047], text: "Zion" },
   //   { coords: [37.5734,-112.1848], text: "Bryce canyon" }
   // ];
  //
   // textOverlays.forEach(function(overlay) {
   //   L.popup()
   //     .setLatLng(overlay.coords)
   //     .setContent(overlay.text)
   //     .openOn(map);
   // });

let map;
let infoWindow = new google.maps.InfoWindow();
let directionsService, directionsRenderer;
let userMarker = new google.maps.Marker();
let destinationMarker = new google.maps.Marker();
let routeArray = [], circleArray = [], markerArray = [];

// Initialize and add the map
function initMap(lat = -0.5242972, lng = 100.492333) {
    directionsService = new google.maps.DirectionsService();
    const center = new google.maps.LatLng(lat, lng);
    map = new google.maps.Map(document.getElementById("googlemaps"), {
        zoom: 18,
        center: center,
        mapTypeId: 'roadmap',
    });
    var rendererOptions = {
        map: map
    }
    directionsRenderer = new google.maps.DirectionsRenderer(rendererOptions);
}

// Remove any route shown
function clearRoute() {
    for(i in routeArray) {
        routeArray[i].setMap(null);
    }
    routeArray = [];
}

// Remove any radius shown
function clearRadius() {
    for (i in circleArray) {
        circleArray[i].setMap(null);
    }
    circleArray = [];
}

// Remove any marker shown
function clearMarker() {
    for (i in markerArray) {
        markerArray[i].setMap(null);
    }
    markerArray = [];
}

// Get user's current position
function currentPosition() {
    clearRadius();
    clearRoute();

    google.maps.event.clearListeners(map, 'click');
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };

                infoWindow.close();
                userMarker.setMap(null);
                markerOption = {
                    position: pos,
                    animation: google.maps.Animation.DROP,
                    map: map,
                };
                userMarker.setOptions(markerOption);
                infoWindow.setContent("<span class='fw-bold'>Position found.</span> <br> lat: " + pos.lat + "<br>long: " + pos.lng);
                infoWindow.open(map, userMarker);
                map.setCenter(pos);
                document.getElementById('currentLat').value = pos.lat
                document.getElementById('currentLng').value = pos.lng

                userMarker.addListener('click', () => {
                    infoWindow.open(map, userMarker);
                });
            },
            () => {
                handleLocationError(true, infoWindow, map.getCenter());
            }
        );
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }
}

// Error handler for geolocation
function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(
        browserHasGeolocation
            ? "Error: The Geolocation service failed."
            : "Error: Your browser doesn't support geolocation."
    );
    infoWindow.open(map);
}

// User set position on map
function manualPosition() {

    clearRadius();
    clearRoute();

    Swal.fire('Click on Map');
    map.addListener('click', (mapsMouseEvent) => {

        infoWindow.close();
        pos = mapsMouseEvent.latLng;

        userMarker.setMap(null);
        markerOption = {
            position: pos,
            animation: google.maps.Animation.DROP,
            map: map,
        };
        userMarker.setOptions(markerOption);
        infoWindow.setContent("<span class='fw-bold'>Current Position.</span> <br> lat: " + pos.lat().toFixed(8) + "<br>long: " + pos.lng().toFixed(8));
        infoWindow.open(map, userMarker);

        userMarker.addListener('click', () => {
            infoWindow.open(map, userMarker);
        });

        document.getElementById('currentLat').value = pos.lat().toFixed(8)
        document.getElementById('currentLng').value = pos.lng().toFixed(8)
    });

}

// Render route on selected object
function routeTo(lat, lng) {

    clearRadius();
    clearRoute();

    google.maps.event.clearListeners(map, 'click')
    currentLat = document.getElementById('currentLat').value;
    currentLng = document.getElementById('currentLng').value;
    if (currentLat == 0 && currentLng == 0) {
        return Swal.fire('Determine your position first!');
    }
    start = new google.maps.LatLng(currentLat, currentLng);
    end = new google.maps.LatLng(lat, lng)
    let request = {
        origin: start,
        destination: end,
        travelMode: 'DRIVING'
    };
    directionsService.route(request, function(result, status) {
        if (status == 'OK') {
            directionsRenderer.setDirections(result);
            directionsRenderer.setMap(map);
            routeArray.push(directionsRenderer);
        }
    });

    destinationMarker.setMap(null);
    markerOption = {
        position: end,
        animation: google.maps.Animation.DROP,
        map: map,
    };
    destinationMarker.setOptions(markerOption);
    infoWindow.close();
    infoWindow.setContent("<span class='fw-bold'>Rumah Gadang</span>");
    infoWindow.open(map, destinationMarker);
}

// Display marker for loaded object
function objectMarker(lat, lng) {

    clearRadius();
    clearRoute();
    google.maps.event.clearListeners(map, 'click');
    let pos = new google.maps.LatLng(lat, lng);
    let marker = new google.maps.Marker();
    markerOption = {
        position: pos,
        animation: google.maps.Animation.DROP,
        map: map,
    }
    marker.setOptions(markerOption);
    markerArray.push(marker);
}

// Update radiusValue on search by radius
function updateRadius(postfix) {
    document.getElementById('radiusValue' + postfix).innerHTML = (document.getElementById('inputRadius' + postfix).value * 100) + " m";
}

// Render search by radius
function radiusSearch({postfix= null, oldLat= null, oldLng= null, oldRad= null} = {}) {
    if (!(!oldLat)) {
        console.log(oldLat, oldLng, oldRad)
        pos = new google.maps.LatLng(oldLat, oldLng);
        markerOption = {
            position: pos,
            animation: google.maps.Animation.DROP,
            map: map,
        };
        map.setCenter(pos);
        userMarker.setOptions(markerOption);
        infoWindow.setContent("<span class='fw-bold'>Current Position.</span> <br> lat: " + pos.lat().toFixed(8) + "<br>long: " + pos.lng().toFixed(8));
        infoWindow.open(map, userMarker);
        const radiusCircle = new google.maps.Circle({
            center: pos,
            radius: Number(oldRad),
            map: map,
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.35,
        });
        circleArray.push(radiusCircle);
        document.getElementById('radiusValue' + postfix).innerHTML = oldRad + " m";
        document.getElementById('inputRadius' + postfix).value = oldRad / 100;
        document.getElementById('currentLat').value = oldLat;
        document.getElementById('currentLng').value = oldLng;
        return
    }

    let currentLat = document.getElementById('currentLat').value;
    let currentLng = document.getElementById('currentLng').value;
    if (currentLat == 0 && currentLng == 0) {
        document.getElementById('radiusValue' + postfix).innerHTML = "0 m";
        document.getElementById('inputRadius' + postfix).value = 0;
        return Swal.fire('Determine your position first!');
    }

    clearRadius();
    clearRoute();
    clearMarker();
    destinationMarker.setMap(null);
    google.maps.event.clearListeners(map, 'click')

    pos = new google.maps.LatLng(currentLat, currentLng);
    let radiusValue = parseFloat(document.getElementById('inputRadius' + postfix).value) * 100;
    document.getElementById('inputLat' + postfix).value = currentLat;
    document.getElementById('inputLng' + postfix).value = currentLng;
    document.getElementById('radius' + postfix).value = radiusValue;

    const radiusCircle = new google.maps.Circle({
        center: pos,
        radius: radiusValue,
        map: map,
        strokeColor: "#FF0000",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#FF0000",
        fillOpacity: 0.35,
    });
    circleArray.push(radiusCircle);

}
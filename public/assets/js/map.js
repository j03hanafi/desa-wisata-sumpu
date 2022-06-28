let map, infoWindow;
let directionsService, directionsRenderer;
let routeArray = [];

function init() {
    initMap();
}

// Initialize and add the map
function initMap() {
    directionsService = new google.maps.DirectionsService();
    const center = { lat: -0.5256971, lng: 100.4929705 };
    map = new google.maps.Map(document.getElementById("googlemaps"), {
        zoom: 15,
        center: center,
        mapTypeId: 'roadmap',
    });
    var rendererOptions = {
        map: map
    }
    directionsRenderer = new google.maps.DirectionsRenderer(rendererOptions)
}

function clearRoute() {
    for(i in routeArray) {
        routeArray[i].setMap(null);
    }
}

function currentPosition() {
    clearRoute()
    infoWindow = new google.maps.InfoWindow();
    google.maps.event.clearListeners(map, 'click');
    let marker = new google.maps.Marker();
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };

                marker.setMap(null);
                marker = new google.maps.Marker({
                    position: pos,
                    animation: google.maps.Animation.DROP,
                    map: map,
                });
                infoWindow.setPosition(pos);
                infoWindow.setContent("<span class='fw-bold'>Position found.</span> <br> lat: " + pos.lat + "<br>long: " + pos.lng);
                infoWindow.open(map, marker);
                map.setCenter(pos);
                document.getElementById('currentLat').value = pos.lat
                document.getElementById('currentLng').value = pos.lng
                console.log(pos.lat, pos.lng)

                marker.addListener('click', () => {
                    infoWindow.open(map, marker);
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

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(
        browserHasGeolocation
            ? "Error: The Geolocation service failed."
            : "Error: Your browser doesn't support geolocation."
    );
    infoWindow.open(map);
}

function manualPosition() {
    clearRoute()
    infoWindow = new google.maps.InfoWindow();
    let marker = new google.maps.Marker();
    Swal.fire('Click on Map');
    map.addListener('click', (mapsMouseEvent) => {

        marker.setMap(null);

        infoWindow.close();
        infoWindow = new google.maps.InfoWindow();
        pos = mapsMouseEvent.latLng;

        marker = new google.maps.Marker({
            position: pos,
            animation: google.maps.Animation.DROP,
            map: map,
        });

        infoWindow.setPosition(pos);
        infoWindow.setContent("<span class='fw-bold'>Current Position.</span> <br> lat: " + pos.lat().toFixed(8) + "<br>long: " + pos.lng().toFixed(8));
        infoWindow.open(map, marker);

        marker.addListener('click', () => {
            infoWindow.open(map, marker);
        });

        document.getElementById('currentLat').value = pos.lat().toFixed(8)
        document.getElementById('currentLng').value = pos.lng().toFixed(8)
        console.log(pos.lat(), pos.lng())
    });

}

function routeTo(lat, lng) {

    clearRoute();

    google.maps.event.clearListeners(map, 'click')
    let marker = new google.maps.Marker();
    currentLat = document.getElementById('currentLat').value;
    currentLng = document.getElementById('currentLng').value;
    if (currentLat == 0 && currentLng == 0) {
        Swal.fire('Determine your position first!');
    } else {
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

        infoWindow = new google.maps.InfoWindow();
        marker.setMap(null);
        marker = new google.maps.Marker({
            position: end,
            animation: google.maps.Animation.DROP,
            map: map,
        });
        infoWindow.setPosition(pos);
        infoWindow.setContent("<span class='fw-bold'>Rumah Gadang</span>");
        infoWindow.open(map, marker);
    }
}

<?php
include("connection.php");
include("functions.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT u.username, e.company_id FROM users u LEFT JOIN employee e ON u.user_id = e.driver_id WHERE u.user_id = $user_id";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="user_home.css" type="text/css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZBhaKU-h-mmrjF-G4_AcC0qS74rdBtR0&callback=initMap" async defer></script>
    <script
        src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js"></script>
    <script>
        $(function(){
            $("#header").load("header_user.php");
        });
    </script>
    <style>
        #map {
            height: 700px;
        }

        .custom-map-control-button {
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            margin: 10px;
            padding: 10px;
        }
    </style>
</head>
<body>
<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $drive_id = $_SESSION['drive_id'];
        $comment = $_POST['comment'];

        $sql = "INSERT INTO finished_drives(drive_id, ended_time, comment)
                VALUES('$drive_id', NOW(), '$comment')";
        
        mysqli_query($con, $sql);
        header("Location: driver_home.php");
    }
?>
<div class="float-child" class="map_div" id="map">
        <script>
            let map, infoWindow, geocoder, directionsService, directionsRenderer, usrpos, destination, passangerpos;

            function initMap() {
                geocoder = new google.maps.Geocoder();

            const bounds = {
                north: 85, // Maximum latitude
                south: -75, // Minimum latitude
                east: 180, // Maximum longitude
                west: -180 // Minimum longitude
            };

            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 46.249, lng: 15.272 },
                zoom: 6,
                minZoom: 4,
                restriction: {
                    latLngBounds: bounds,
                    strictBounds: false
                }
            });
                infoWindow = new google.maps.InfoWindow();

                directionsService = new google.maps.DirectionsService();
                directionsRenderer = new google.maps.DirectionsRenderer();
                directionsRenderer.setMap(map);


                fetch('get_drive_directions.php')
                .then(response => response.json())
                .then(data => {
                    // Loop through the people data and create markers on the map
                    /*data.forEach(drive => {
                        var marker = new google.maps.Marker({
                            position: {lat: parseFloat(driver.latitude), lng: parseFloat(driver.longitude)},
                            map: map,
                            title: driver.driver_id
                        });
                        marker.addListener('click', function() {

                        handleMarkerClick(driver);
                    });*/

                    data.forEach(drive => {
                        destination = drive.destination;
                        passangerpos = drive.pickup_location;
                    });
                    geocodeLatLng(geocoder);
                    destinationMarker();
                })
                .catch(error => console.error('Error:', error));



                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                    pos = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude,
                                };
                                usrpos = position.coords.latitude + ',' +position.coords.longitude;

                                var markerp = new google.maps.Marker({
                                position: pos,
                                map: map,
                                });
                            },
                            () => {
                                handleLocationError(true, infoWindow, map.getCenter());
                            },
                        );
                    } else {
                        // Browser doesn't support Geolocation
                        handleLocationError(false, infoWindow, map.getCenter());
                    }

            }

            function destinationMarker(){
                var address = passangerpos;
                var geocoder = new google.maps.Geocoder();

                geocoder.geocode({ 'address': address }, function (results, status) {
                    if (status === 'OK') {
                        var location = results[0].geometry.location;
                        
                        map.setCenter(location);
                        calculateAndDisplayRoute (directionsService, directionsRenderer);
                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
                });
            }


            function calculateAndDisplayRoute (directionsService, directionsRenderer){
                directionsService
                    .route({
                        origin: usrpos,
                        destination: passangerpos,
                        travelMode: google.maps.TravelMode.DRIVING,
                    })
                    .then((response) => {
                        directionsRenderer.setDirections(response);
                    })
                    .catch((e) => window.alert("Directions request failed due to " + e.message));
            }

            function calculateAndDisplayRouteDes (directionsService, directionsRenderer){
                directionsService
                    .route({
                        origin: usrpos,
                        destination: destination,
                        travelMode: google.maps.TravelMode.DRIVING,
                    })
                    .then((response) => {
                        directionsRenderer.setDirections(response);
                    })
                    .catch((e) => window.alert("Directions request failed due to " + e.message));
            }

            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(
                    browserHasGeolocation
                        ? "Error: The Geolocation service failed."
                        : "Error: Your browser doesn't support geolocation.",
                );
                infoWindow.open(map);
            }

            function geocodeLatLng(geocoder) {
                let input = passangerpos;
                let latlngStr = input.split(",", 2);
                let latlng = {
                    lat: parseFloat(latlngStr[0]),
                    lng: parseFloat(latlngStr[1]),
                };

                geocoder
                    .geocode({ location: latlng})
                    .then((response) => {
                        if(response.results[0]) {
                            passangerpos = response.results[0].formatted_address;
                        }else{
                            window.alert("No results found");
                        }
                    })
                    .catch((e) => window.alert("Geocoder failed due to: " + e));
            };
        </script>
    </div>
    <div>
        <input type="button" id="showdes" value="Destination" onclick="calculateAndDisplayRouteDes(directionsService, directionsRenderer)">
        <form method="POST">
            <input type="submit" id="enddrive" value="Submit">
            <input type="text" id="comment" name="comment" value="">
        </form>
    </div>
</body>
</html>
<?php

session_start();

	include("connection.php");
	include("functions.php");

    $user_data = check_login($con);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styling/user_home.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZBhaKU-h-mmrjF-G4_AcC0qS74rdBtR0&callback=initMap" async defer></script>
    <script
        src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous">
    </script>
    <script>
        $(function(){
            $("#header").load("header_user.php");
        });
    </script>
    <style>
        /* Add your custom styles here */
        #map {
            height: 700px;
            width: 800px;
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
    <div id="header"></div><br>

    <div class="map_div" id="map">
        <script>
            let map, infoWindow;

            function initMap() {
                map = new google.maps.Map(document.getElementById("map"), {
                    center: { lat: 46.249, lng: 15.272 },
                    zoom: 6,
                });
                infoWindow = new google.maps.InfoWindow();

                const locationButton = document.createElement("button");

                fetch('get_driver_pos.php')
                .then(response => response.json())
                .then(data => {
                    // Loop through the people data and create markers on the map
                    data.forEach(driver => {
                        var marker = new google.maps.Marker({
                            position: {lat: parseFloat(driver.latitude), lng: parseFloat(driver.longitude)},
                            map: map,
                            title: driver.driver_id
                        });
                    });
                })
                .catch(error => console.error('Error:', error));

                locationButton.textContent = "Pan to Current Location";
                locationButton.classList.add("custom-map-control-button");
                map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
                //locationButton.addEventListener("click", () => {
                    // Try HTML5 geolocation.
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                const pos = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude,
                                };

                                new google.maps.Marker({
                                position: pos,
                                map: map,
                                });

                                //infoWindow.setPosition(pos);
                                //infoWindow.setContent("Location found.");
                                //infoWindow.open(map);
                                //map.setCenter(pos);
                            },
                            () => {
                                handleLocationError(true, infoWindow, map.getCenter());
                            },
                        );
                    } else {
                        // Browser doesn't support Geolocation
                        handleLocationError(false, infoWindow, map.getCenter());
                    }


                //});
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
        </script>
    </div>
</body>
</html>
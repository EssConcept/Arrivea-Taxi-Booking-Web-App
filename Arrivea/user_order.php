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
    <?php 
    include('header_user_order.php');
    ?>
    <style>
        /* Add your custom styles here */
        #map {
            height: 700px;
            width: 800px;
            transform: translatex(500px) translateY(200px);
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
            // Define bounds for restricting map panning and zooming
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
                    strictBounds: false // Allow the map to zoom out slightly beyond the bounds
                }
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
                        marker.addListener('click', function() {

                        handleMarkerClick(driver);
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

            function handleMarkerClick(driver) {
            // You can customize this function to display driver details or perform any action
            // For now, let's just display an alert with the driver ID
            let driverId = driver.driver_id;

            var newUrl = 'user_order.php?driverId=' + encodeURIComponent(driverId);
            window.location.href = newUrl;
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
    <?php

        $isLinkSet;
        if(isset($_GET['driverId'])){
        $isLinkSet = true;
        }
        else{
        $isLinkSet = false;
        echo 'no link';
        }

        if($isLinkSet == true){
            $driver_id = $_GET['driverId'];

            $sql = "SELECT * FROM users WHERE user_id = '$driver_id'";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);

            $sql1 = "SELECT * FROM employee WHERE driver_id = '$driver_id'";
            $result1 = mysqli_query($con, $sql1);
            $row1 = mysqli_fetch_assoc($result1);
            $company_id = $row1['company_id'];

            $sql2 = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result2 = mysqli_query($con, $sql2);
            $row2 = mysqli_fetch_assoc($result2);

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $driver_id = isset($_GET['driverId']) ? $_GET['driverId'] : '';
                $passenger_id = $user_data['user_id'];

                $sql = "INSERT INTO drive(driver_id, passanger_id)
                        VALUES($driver_id, $passenger_id)";

                $stmt = mysqli_prepare($con, $sql);

                if (mysqli_stmt_execute($stmt)) {
                    echo "Drive data inserted successfully.";
                } else {
                    echo "Error while insetring drive data, try again ";
                }
            }
            

            echo '<form method="POST">';
            echo '<div>';
            echo '<p><label for="driver_name">Name:</label> <input type="text" name="driver_name" value="' . htmlspecialchars($row['name']) . '"></p>';
            echo '<p><label for="driver_surname">Surname:</label> <input type="text" name="driver_surname" value="' . htmlspecialchars($row['surname']) . '"></p>';
            echo '<p><label for="company_name">Company Name:</label> <input type="text" name="company_name" value="' . htmlspecialchars($row2['company_name']) . '"></p>';
            echo '<p><label for="price">Price per KM:</label> <input type="text" name="price" value="' . htmlspecialchars($row2['price']) . '"></p>';
            // Hidden driver id
            echo '<input type="hidden" name="driver_id" value="' . $driver_id . '">';
            echo '<input type="hidden" id="pickup_location" name="pickup_location" value="">';
            echo '<input type="submit" value="Submit">';
            echo '</form>';
            echo '</div>';

          }
    ?>
</body>
</html>
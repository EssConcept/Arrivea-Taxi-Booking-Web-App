@ -0,0 +1,306 @@
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
    <div id="header"></div><br>
    <div class="cont">
        <div class="child-left">
            <table> 
            <thead>
                <tr>
                    <td colspan="2">
                        <h2>Cheapest Taxi List</h2>
                    </td>
                </tr>
                <tr>
                    <th>Company</th>
                    <th>Price/km</th>
                </tr>
            </thead>
                <tbody>
                    <?php
                    $sql = "SELECT company_name, price FROM company ORDER BY price ASC LIMIT 20 ";
                    $result = mysqli_query($con, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td align='center'>" . htmlspecialchars($row['company_name']) . "</td>";
                            echo "<td align='center'>" . htmlspecialchars($row['price']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No companies found</td></tr>";
                    }
                    ?>
                </tbody>
                </tr>
            </table>
    
    
    
        </div>
    <div class="float-child" class="map_div" id="map">
        <script>
            let map, infoWindow, directionsService, directionsRenderer, usrpos;

            function initMap() {
                

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

            function handleMarkerClick(driver) {

            let driverId = driver.driver_id;

            var newUrl = 'user_order.php?driverId=' + encodeURIComponent(driverId) + '&userpos=' + encodeURIComponent(usrpos);
            window.location.href = newUrl;
            }

            function destinationMarker(){
                var address = document.getElementById('destination').value;
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
                        destination: document.getElementById("destination").value,
                        travelMode: google.maps.TravelMode.DRIVING,
                    })
                    .then((response) => {
                        directionsRenderer.setDirections(response);
                    })
                    .catch((e) => window.alert("Directions request failed due to " + e.message));
            }

        /*function getUserLocation(destination) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    calculateAndDisplayRoute(userLocation, destination);
                }, function () {
                    alert('Error: The Geolocation service failed.');
                });
            } else {
                alert('Error: Your browser doesn\'t support geolocation.');
            }
        }

        function calculateAndDisplayRoute(origin, destination) {
            var request = {
                origin: origin,
                destination: destination,
                travelMode: 'DRIVING'
            };
            directionsService.route(request, function (result, status) {
                if (status == 'OK') {
                    directionsRenderer.setDirections(result);
                } else {
                    alert('Directions request failed due to ' + status);
                }
            });
        }*/


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
    <div class="float-child2">
    <?php

        $isLinkSet;
        if(isset($_GET['driverId'])){
        $isLinkSet = true;
        }
        else{
        $isLinkSet = false;
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

            echo '<form method="POST">';
            echo '<div>';
            echo '<p><label for="driver_name">Name:</label> <input readonly type="text" name="driver_name" value="' . htmlspecialchars($row['name']) . '"></p>';
            echo '<p><label for="driver_surname">Surname:</label> <input readonly type="text" name="driver_surname" value="' . htmlspecialchars($row['surname']) . '"></p>';
            echo '<p><label for="company_name">Company Name:</label> <input readonly type="text" name="company_name" value="' . htmlspecialchars($row2['company_name']) . '"></p>';
            echo '<p><label for="price">Price per KM:</label> <input readonly type="text" name="price" value="' . htmlspecialchars($row2['price']) . '"></p>';
            // Hidden driver id
            echo '<input type="hidden" name="driver_id" value="' . $driver_id . '">';
            echo '<p><label for="destination">Destination: </label><input type="text" id="destination" name="destination" value="">';
            echo '<input type ="button" id="submitDes" onclick="destinationMarker()" value="Show route"/><br><input class="submitbutton" type="submit" value="Submit">';
            echo '</form>';
            echo '</div>';
          }

          if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $destination = $_POST['destination'];
            $user_id = $_SESSION['user_id'];
            $pickup_location = $_GET["userpos"];

            $query = "SELECT vehicle_id FROM using_vehicle WHERE driver_id = '$driver_id'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);
            $vehicle_id = $row['vehicle_id'];

            $sql = "INSERT INTO drive(driver_id, passanger_id, vehicle_id, pickup_location, destination, order_time)
                    VALUES('$driver_id', '$user_id', '$vehicle_id', '$pickup_location', '$destination', NOW())";
            mysqli_query($con, $sql);
            ?>
            <script>
                newUrl = 'user_order.php';
                window.location.href =newUrl;
            </script>
            <?php
          }

    ?>
    </div>
    </div>

</body>
</html>
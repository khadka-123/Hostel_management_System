<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hostel_management_system2";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname, 3308);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    ?>
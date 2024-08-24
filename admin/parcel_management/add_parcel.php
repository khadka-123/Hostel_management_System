<?php
session_start();

include("../../connection.php");

if (isset($_POST["add"])) {

    //retrieve data from the form
    $parcel_no = $_POST["parcel_no"];
    $sname = $_POST["sname"];
    $roll_no = $_POST["roll_no"];
    $arrival_date = $_POST["arrival_date"];

    $query = "INSERT INTO parcel_table (parcel_no, sname, roll_no, arrival_date) 
              VALUES ('$parcel_no', '$sname', '$roll_no', '$arrival_date')";


    $result = mysqli_query($conn, $query);
    if ($result) {
        //heading back to display webpage
        header("location:admin_parcel.php");
        exit;
    } else {
        die("error:" . mysqli_error($conn));
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="add_parcel.css">
    <title>Add Parcel</title>

</head>

<body>
    <nav class="navbar">
        <div class="container-logo">
            <a class="navbar-logo" href="../../admin/admin_homepage.html" id="logoLink">
                <img src="../../style/logo.jpg" alt="Logo">
            </a>
        </div>

        <div class="Dashboard">
            <p>Parcel Details</p>
        </div>
    </nav>


    <div class="parcel-container">

        <form action="add_parcel.php" method="post" autocomplete="off">
            <div>
                <label for="parcel_no">Parcel No :</label>
                <input class="pno" type="number" id="parcel_no" name="parcel_no">
            </div>
            <br>
            <div>
                <label for="sname">Student Name :</label>
                <input class="sname" type="text" id="sname" name="sname">
            </div>
            <br>
            <div>
                <label for="roll_no">Roll No :</label>
                <input class="roll_no" type="number" name="roll_no" id="roll_no">
            </div>
            <br>
            <div>
                <label for="arrival_date">Arrival Date :</label>
                <input class="adate" type="date" name="arrival_date" id="arrival_date">
            </div>
            <br>

            <div class="btn">
                <!-- <button class="add-btn" type="submit" name="add"><i class="bi bi-plus-circle-fill"></i></button> -->
                <button name="add" class="add-btn">Add</button>
            </div>
        </form>
    </div>
</body>

</html>
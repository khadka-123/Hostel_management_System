<?php
session_start();
include("../../connection.php");

// Check if form is submitted and updateid is set
if (isset($_GET["updateid"])) {
    // Get parcel number
    $p_no = $_GET["updateid"];
    // Fetch data from database for the specified parcel number
    $query = "SELECT * FROM parcel_table WHERE parcel_no='$p_no'";
    $result = mysqli_query($conn, $query);
    // Check if data exists for the given parcel number
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        // Handle case where no data is found
        echo "No data found for parcel number: $p_no";
        exit;
    }
} else {
    header("location: admin_parcel.php");
}

// Check if form is submitted for updating data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    // Get form data
    $p_no = $_POST["parcel_no"];
    $sname = $_POST["sname"];
    $roll_no = $_POST["roll_no"];
    $arrival_date = $_POST["arrival_date"];
    // Update data in the database
    $query = "UPDATE parcel_table SET sname='$sname', roll_no='$roll_no', arrival_date='$arrival_date' WHERE parcel_no='$p_no'";
    $result = mysqli_query($conn, $query);
    // Check if update was successful
    if ($result) {
        header("location: admin_parcel.php");
        exit;
    } else {
        // Handle case where update fails
        echo "Failed to update parcel.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="add_parcel.css">
    <title>Update Parcel</title>
</head>

<body>
    <nav class="navbar">
        <div class="container-logo">
            <a class="navbar-logo" href="../../admin/admin_homepage.html" id="logoLink">
                <img src="../../style/logo.jpg" alt="Logo">
            </a>
        </div>
        <div class="Dashboard">
            <p>Parcel Update</p>
        </div>
    </nav>

    <div class="parcel-container">
        <form action="admin_parcel_update.php" method="post">
            <!-- Hidden input field to store parcel number -->
            <input type="hidden" name="parcel_no" value="<?php echo $p_no; ?>">
            <div>
                <label for="sname">Student Name:</label>
                <input class="sname" value="<?php echo $row["sname"]; ?>" type="text" id="sname" name="sname">
            </div>
            <br>
            <div>
                <label for="roll_no">Roll No:</label>
                <input class="roll_no" value="<?php echo $row["roll_no"]; ?>" type="number" name="roll_no" id="roll_no">
            </div>
            <br>
            <div>
                <label for="arrival_date">Arrival Date:</label>
                <input class="adate" value="<?php echo $row["arrival_date"]; ?>" type="date" name="arrival_date" id="arrival_date">
            </div>
            <br>
            <div class="btn">
                <button class="update-btn" name="update">Update</button>
            </div>
        </form>
    </div>
</body>

</html>

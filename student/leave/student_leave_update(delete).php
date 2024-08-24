<?php
session_start();
include('../../connection.php');

if (isset($_GET["updateid"])) {
    $roll_no = $_GET["updateid"];
    $query = "SELECT * FROM leave_table where roll_no='$roll_no' ";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $roll_no = $_POST["roll_no"];
    $room_no = $_POST["room_no"];
    $departure_date = $_POST["departure_date"];
    $arrival_date = $_POST["arrival_date"];

    $query = "UPDATE leave_table SET roll_no='$roll_no', room_no='$room_no', departure_date='$departure_date', arrival_date='$arrival_date' where roll_no='$roll_no' ";

    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Update failed: " . mysqli_error($con));
    }

    if ($result) {
        header("Location: student_leave.php?roll_no=$roll_no");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Record</title>
    <link rel="stylesheet" href="add_leave.css">
</head>

<body>

    <nav class="navbar">
        <div class="container-logo">
            <a class="navbar-logo" href="../../student/student_homepage.html" id="logoLink">
                <img src="../../style/logo.jpg" alt="Logo">
            </a>
        </div>

        <div class="Dashboard">
            <p>Update Leave Records</p>
        </div>
    </nav>

    <div class="leave-container">
        <form action="student_leave_update.php" method="post">
            <div class="roll_no">
                <label for="roll_no">Roll NO :</label>
                <input type="number" value="<?php echo $row["roll_no"] ?> " id="roll_no" name="roll_no">
            </div>
            <div class="room_no">
                <label for="room_no">Room No :</label>
                <input type="number" value="<?php echo $row["room_no"] ?>" id="room_no" name="room_no">
            </div>
            <div class="ddate">
                <label for="ddate">Departure Date:</label>
                <input type="date" value="<?php echo $row["departure_date"] ?>" id="ddate" name="departure_date">
            </div>
            <div class="adate">
                <label for="adate">Arrival Date :</label>
                <input type="date" value="<?php echo $row["arrival_date"] ?>" id="adate" name="arrival_date">
            </div>

            <div class="btn">
                <button class="add-btn" name="update">Update</button>
            </div>
        </form>
    </div>
</body>

</html>
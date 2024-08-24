<?php
session_start();

include('../../connection.php');

if (isset($_POST["submit"])) {
    $roll_no = "";
    // Get student's roll number based on email
    $email = $_SESSION['email'];
    $query1 = "SELECT roll_no FROM student WHERE email='$email' ";
    $result1 = mysqli_query($conn, $query1);
    if (!$result1) {
        die("Query failed:" . mysqli_error($conn));
    }
    $roll_no_row = mysqli_fetch_assoc($result1);
    $roll_no = $roll_no_row['roll_no'];

    $departure_date = $_POST["departure_date"];

    // Check if departure date is equal to the current date
    $current_date = date("Y-m-d");
    if ($departure_date < $current_date) {
        echo "<script>alert('Error: Departure date must be greater to the current date.');</script>";
    } else {
        $query = "INSERT INTO leave_record (roll_no, departure_date, status_) VALUES ('$roll_no', '$departure_date', 'not arrived')";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die(mysqli_error($conn));
        }
        header("location:student_leave.php");
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
            <p>Add Leave Records</p>
        </div>
    </nav>
    <div class="leave-container">
        <form action="add_leave.php" method="post" autocomplete="off">
            <!-- <div class="roll_no">
                <label for="roll_no">Roll NO :</label>
                <input type="number" id="roll_no" name="roll_no">
            </div> -->
            <!-- <div class="room_no">
                <label for="room_no">Room No :</label>
                <input type="number" id="room_no" name="room_no">
            </div> -->
            <div class="ddate">
                <label for="ddate">Departure Date:</label>
                <input type="date" id="ddate" name="departure_date">
            </div>
            <!-- <div class="adate">
                <label for="adate">Arrival Date :</label>
                <input type="date" id="adate" name="arrival_date">
            </div> -->

            <div class="btn">
                <!-- <button class="update-btn"><a href="leave_update.php?roll_no=<?php echo $row['roll_no']; ?>">Update</a></button> -->
                <!-- <button class="go-btn" type="submit" name="go">Submit</button> -->
                <button class="add-btn" name="submit">Record Leave</button>
            </div>
        </form>
    </div>
</body>

</html>
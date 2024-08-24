<?php
session_start();

include('../../connection.php');

// $query="select * from leave l
//        natural join student s
//        where l.roll_no='$roll_no'";

$query = "SELECT * from leave_record";
$result = mysqli_query($conn, $query);

if (!$result) {
    die(mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Leave Details</title>
    <link rel="stylesheet" href="admin_leave.css">

</head>

<body>
    <nav class="navbar">
        <div class="container-logo">
            <a class="navbar-logo" href="../../admin/admin_homepage.html" id="logoLink">
                <img src="../../style/logo.jpg" alt="Logo">
            </a>
        </div>

        <div class="Dashboard">
            <p>Leave Records</p>
        </div>
    </nav>

    <!-- <div class="add_student">
       <a href="add_leave.php" class="btn btn-primary">Add Leave</a>
    </div> -->

    <table class="content-table">
        <thead>
            <tr>
                <!-- <th class="table-head">Sname</th> -->
                <th class="table-head">Roll No</th>
                <th class="table-head">Hostel</th>
                <th class="table-head">Room No</th>
                <th class="table-head">Departure Date</th>
                <th class="table-head">Arrival Date</th>
                <th class="table-head">Status</th>
                <th class="table-head">Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php

            while ($row = mysqli_fetch_assoc($result)) {
                //find hostel id for e
                $roll_no = $row['roll_no'];

                $query2 = "SELECT hostel_id from student where roll_no = $roll_no";
                $result2 = mysqli_query($conn, $query2);
                if (!$result2) {
                    die("Query failed:" . mysqli_error($conn));
                }
                $row2 = mysqli_fetch_assoc($result2);
                $hostel_id = $row2['hostel_id'];

                // Fetching room number based on hostel ID
                if ($hostel_id == 1) { //boys_hostel
                    $hostel_name = 'Boys Hostel';
                    $query3 = "SELECT room_no from boys_hostel where occupant1_roll_no = $roll_no OR occupant2_roll_no = $roll_no";
                } else { // girls_hostel
                    $hostel_name = 'Girls Hostel';
                    $query3 = "SELECT room_no from girls_hostel where occupant1_roll_no = $roll_no OR occupant2_roll_no = $roll_no";
                }

                $result3 = mysqli_query($conn, $query3);
                if (!$result3) {
                    die("Query failed:" . mysqli_error($conn));
                }

                $row3 = mysqli_fetch_assoc($result3);
                $room_no = $row3['room_no'];

                // <td>' . $row['sname'] . '</td>
                echo '<tr>
                <td>' . $row['roll_no'] . '</td>
                <td>' . $hostel_name . '</td>
                <td>' . $room_no . '</td>
                <td>' . $row['departure_date'] . '</td>
                <td>' . $row['arrival_date'] . '</td>
                <td>' . $row['status_'] . '</td>

                <td class="up_del-btn">
                    <a class="btn btn-danger" href="admin_leave_delete.php?deleteid=' . $roll_no . '">Delete</a>
                </td>
            </tr>';
            }
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</body>

</html>
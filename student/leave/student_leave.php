
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Add Leave</title>
    <link rel="stylesheet" href="../../admin/leave/admin_leave.css">
</head>

<body>
    <nav class="navbar">
        <div class="container-logo">
            <a class="navbar-logo" href="../../student/student_homepage.html" id="logoLink">
                <img src="../../style/logo.jpg" alt="Logo">
            </a>
        </div>

        <div class="Dashboard">
            <p>Leave Records</p>
        </div>
    </nav>

    <div class="add_student">
        <a href="add_leave.php" class="btn btn-primary">Apply Leave</a>
    </div>

    <table class="content-table">
        <thead>
            <tr>
                <th class="table-head">Roll No</th>
                <th class="table-head">Room No</th>
                <th class="table-head">Departure Date</th>
                <th class="table-head">Arrival Date</th>
                <th class="table-head">Actions</th>
            </tr>
        </thead>
        
        <tbody>
            
            <?php
            include('../../connection.php');


            session_start();


            // Get student's roll number based on email
            $email = $_SESSION['email'];
            $q1 = "SELECT hostel_id from student where email = '$email'";
            $res1 = mysqli_query($conn, $q1);
            
            if($r1 = mysqli_fetch_assoc($res1)){
                if($r1['hostel_id'] == NULL){
                    header('Location: ../student_homepage.html');
                    echo "<script>alert('Error: You have not been alloted any hostel(can't use any features!).');</script>";
                }
            }

            $query1 = "SELECT roll_no FROM student WHERE email='$email' ";
            $result1 = mysqli_query($conn, $query1);
            if (!$result1) {
                die("Query failed:" . mysqli_error($conn));
            }
            $roll_no_row = mysqli_fetch_assoc($result1);
            $roll_no = $roll_no_row['roll_no'];

            // Fetching leave records for the student
            $query = "SELECT * from leave_record WHERE roll_no='$roll_no' ";
            $result = mysqli_query($conn, $query);
            if (!$result) {
                die(mysqli_error($conn));
            }

            // Fetching hostel ID for the student
            $query2 = "SELECT hostel_id from student where roll_no = $roll_no";
            $result2 = mysqli_query($conn, $query2);
            if (!$result2) {
                die("Query failed:" . mysqli_error($conn));
            }
            $row2 = mysqli_fetch_assoc($result2);
            $hostel_id = $row2['hostel_id'];

            // Fetching room number based on hostel ID
            if ($hostel_id == 1) { //boys_hostel
                $query3 = "SELECT room_no from boys_hostel where occupant1_roll_no = $roll_no OR occupant2_roll_no = $roll_no";
            } else { // girls_hostel
                $query3 = "SELECT room_no from girls_hostel where occupant1_roll_no = $roll_no OR occupant2_roll_no = $roll_no";
            }
            $result3 = mysqli_query($conn, $query3);
            if (!$result3) {
                die("Query failed:" . mysqli_error($conn));
            }
            if($row3 = mysqli_fetch_assoc($result3))
                $room_no = $row3['room_no'];

            // Display leave records
            while ($row = mysqli_fetch_assoc($result)) {
                echo 
                    '<tr>
                        <td>' . $row['roll_no'] . '</td>
                        <td>' . $room_no . '</td>
                        <td>' . $row['departure_date'] . '</td>
                        <td>' . $row['arrival_date'] . '</td>

                        <td class="up_del-btn">
                        <form action="student_leave.php" method="POST" >
                            <input type="hidden" name="parcel_no" value="' .  $row['roll_no'] . '">
                            <button type="submit" class="btn btn-success" name="arrived">Arrival Date</button>
                        </form>
                        </td>
                    </tr>';

            }

            //arrival date
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['arrived'])) {
                $parcel_no = $_POST['parcel_no'];
                $currentDate = date("Y-m-d"); // Format: Year-Month-Day
                $query = "UPDATE leave_record SET arrival_date='$currentDate', status_ = 'Arrived' WHERE roll_no='$roll_no' ";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    header('Location: student_leave.php');
                    exit();
                } else {
                    die("Query failed:" . mysqli_error($conn));
                }
            }
            mysqli_close($conn);
            ?>

        </tbody>
    </table>
</body>

</html>
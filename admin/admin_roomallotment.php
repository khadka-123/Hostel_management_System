<!-- session start -->
<?php
session_start();
try {
    if (isset($_SESSION['hostel_selected'])) {
        $selectedHostel = $_SESSION['hostel_selected'];
    } else {
        throw new Exception("No hostel selected");
    }
} catch (Exception $e) {
    $error = $e->getMessage();
    echo "Error: " . $error;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Allotment</title>

    <link href="admin_roomallotment.css" rel="stylesheet">
    <link href="../style/roomallotment_style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    include('../connection.php');
    include('room_available.php');
    ?>

    <nav class="navbar">
        <div class="container-logo">
            <a class="navbar-logo" href="admin_homepage.html" id="logoLink">
                <img src="../style/logo.jpg" alt="Logo">
            </a>
        </div>
        <div class="Dashboard">
            <h1><?php echo $selectedHostel ?> Hostel Room Allotment</h1>
        </div>
    </nav>
    <script>
        document.getElementById('logoLink').href = 'admin_homepage.html';
    </script>

    <div class="center">
        <div class="form-container">
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" id="selectRoomForm">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        Select Room
                    </button>
                    <div class="dropdown-menu-container">
                        <ul class="dropdown-menu" id="roomList" aria-labelledby="dropdownMenuButton">
                            <input type="text" id="optionSearch" name="optionSearch" placeholder="Search">

                            <?php
                            // include('room_available.php');
                            foreach ($rooms_available as $room) {
                                echo '<li><button class="dropdown-item" type="submit" name="select_room" value="' . $room . '">' . $room . '</button></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </form>

            <div class="roomDetails">
                <span id="room_d_">Room Details</span>
                <div id="roommate_details">
                    <?php

                    $flag_roll = false;
                    $flag_select_room = false;
                    $occupant1_rollno = "";
                    $occupant2_rollno = "";
                    $no_of_occupant = 0;
                    $gender = $_SESSION['hostel_selected']; //session['hostel_selected'] contains(Boys/Girls)
                    $table_name = ($gender == 'Boys') ? 'boys_hostel' : 'girls_hostel';

                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['select_room'])) {
                        $_SESSION['room_no'] = $_POST['select_room'];
                        if (!empty($_POST['select_room'])) {
                            $flag_select_room = true;
                        }
                        $room_number = $_SESSION['room_no'];

                        //no of occupants (0/1)
                        $query = "SELECT `status_`, `occupant1_roll_no`, `occupant2_roll_no` FROM $table_name WHERE `room_no` = $room_number";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) > 0) {
                            // If rows were returned, fetch the data
                            $row = mysqli_fetch_assoc($result);
                            $no_of_occupant = $row['status_']; // Set no of occupants based on status

                            if (!empty($row['occupant1_roll_no'])) {
                                $occupant1_rollno = $row['occupant1_roll_no'];
                            } else if (!empty($row['occupant2_roll_no'])) {
                                $occupant2_rollno = $row['occupant2_roll_no'];
                            }
                        }

                        echo '<div id="room_no">';
                        echo '<span class="room_d" style="background-color: #654321;">ROOM NO.: ' . $_SESSION['room_no'] . '</span>';
                        echo '</div>';

                        echo '<div id="room_properties">';
                        echo '<span class="room_d">No. of occupants: <span class="inner">' . $no_of_occupant . '</span></span>';

                        if ($no_of_occupant > 0) { //display details of room
                            //display rollno
                            $occupant_rollno = $occupant1_rollno && $occupant1_rollno != 0 ? $occupant1_rollno : $occupant2_rollno;
                            echo '<span class="room_d">Occupant Rollno: <span class="inner">' . $occupant_rollno . '</span></span>';

                            //display name and address
                            $query = "SELECT `sname`, `address` FROM `student` WHERE `roll_no` = $occupant_rollno";
                            $result2 = mysqli_query($conn, $query);
                            if (mysqli_num_rows($result2) > 0) {
                                $row = mysqli_fetch_assoc($result2);
                                $sname = $row['sname'];
                                $address = $row['address'];
                                echo '<span class="room_d">Occupant Name: <span class="inner">' . $sname . '</span></span>';
                                echo '<span class="room_d">Occupant Address: <span class="inner">' . $address . '</span></span>';
                            }

                            //display bathroom or no bathroom
                        }
                        if ($_SESSION['room_no'] <= 255) {
                            echo '<span class="room_d">No Attached Bathroom</span>';
                        } else {
                            echo '<span class="room_d">Attached Bathroom</span>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" id="addStudentForm">
                <input class="form-control" type="text" name="rollno" placeholder="Roll No (0-9)" required pattern="[0-9]*">
                <button type="submit" class="btn btn-secondary" name="add_student">Add Student</button>
            </form>
        </div>
    </div>

    <?php
    //------------------------ Add student to the selected room ----------------
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rollno']) && isset($_POST['add_student'])) {
        $rollno = $_POST['rollno'];
        $room_number = $_SESSION['room_no'];

        // Check if the room number are set
        if (empty($room_number)) {
            echo "<script>alert('Error: Room not selected, Please try again.');</script>";
            exit;
        }

        // Check if the roll number exists in the student table
        $query_check_rollno = "SELECT COUNT(*) AS count FROM student WHERE roll_no = '$rollno'";
        $result_check_rollno = mysqli_query($conn, $query_check_rollno);
        $row_check_rollno = mysqli_fetch_assoc($result_check_rollno);
        $rollno_exists = $row_check_rollno['count'];
        if ($rollno_exists == 0) {
            echo "<script>alert('Error: Rollno does not exist, Please try again.');</script>";
            exit;
        }

        //check if roll number is already allocated
        $query_check_alloted = "SELECT COUNT(*) AS count FROM (
            SELECT * FROM boys_hostel WHERE occupant1_roll_no = '$rollno' or occupant2_roll_no = '$rollno'
            UNION
            SELECT * FROM girls_hostel WHERE occupant1_roll_no = '$rollno' or occupant2_roll_no = '$rollno'
        ) AS combined_results";

        $result_check_alloted = mysqli_query($conn, $query_check_alloted);
        $row_check_alloted = mysqli_fetch_assoc($result_check_alloted);
        $rollno_alloted = $row_check_alloted['count'];
        if ($rollno_alloted > 0) {
            echo "<script>alert('Error: Entered rollno has already been alloted a room');</script>";
            exit();
        } else { //add student to table
            //1. add new record or 2. add to existing record
            $results = false;
            $temp = '';
            $room_number = (int)$room_number;

            $q_no_of_occupant = "SELECT `status_` FROM $table_name WHERE `room_no` = $room_number";
            $r = mysqli_query($conn, $q_no_of_occupant);
            $no_of_occupant = mysqli_num_rows($r);
            //update to student
            $hos_id = "";
            if ($gender == 'Boys') {
                $hos_id = 1;
            } else
                $hos_id = 2;

            $update_student = "UPDATE student SET hostel_id = '$hos_id' WHERE `roll_no` = $rollno";
            $r = mysqli_query($conn, $update_student);
            if(!$r){
                echo mysqli_error($conn);
                exit();
            }

            if ($no_of_occupant > 0) { // 1. add new record
                if (!empty($occupant1_rollno) || $occupant1_rollno != 0)
                    $temp = 'occupant2_roll_no';
                else
                    $temp = 'occupant1_roll_no';

                // $t = (int)$rollno;
                $t = $rollno;
                $query = "UPDATE $table_name
                SET $temp = '$t',
                status_ = 2
                WHERE `room_no` = '$room_number'";

                try {
                    $results = mysqli_query($conn, $query);
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    echo "Error: " . $error;
                    exit;
                }
            } else { //2. add to existing tuple/record
                $query = "INSERT INTO $table_name (`room_no`, `occupant1_roll_no`, `status_`)
                                VALUES ($room_number, $rollno, 1)";
                try {
                    $results = mysqli_query($conn, $query);
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    echo "Error: " . $error;
                    exit;
                }
            }

            if ($results) {
                echo "<script>alert('Student added successfully to room $temp $rollno $room_number in $table_name');</script>";
                $result = false;
                include('room_available.php');
                exit();
            } else {
                echo "<script>alert('Error adding student: " . mysqli_error($conn) . "');</script>";
                exit();
            }
        }
    }
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="admin_ra.js"></script>
</body>

</html>
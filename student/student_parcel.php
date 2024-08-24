<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>my parcel</title>
    <link rel="stylesheet" href="../style_k/admin_parcel.css">

</head>

<body>
    <nav class="navbar">
        <div class="container-logo">
            <a class="navbar-logo" href="../student/student_homepage.html" id="logoLink">
                <img src="../style/logo.jpg" alt="Logo">
            </a>
        </div>
        <div class="Dashboard">
            <p>My Parcel</p>
        </div>
    </nav>

    <!-- <div class="add_student">
       <a href="student_parcel.php" class="btn btn-primary">Add Parcel</a>
    </div> -->

    <table class="content-table">
        <thead>
            <tr>
                <th class="table-head">Pno</th>
                <th class="table-head">Sname</th>
                <th class="table-head">Roll No</th>
                <th class="table-head">Arrival Date</th>
                <th class="table-head">Received Date</th>
                <th class="table-head">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            session_start();
            include('../connection.php');

            // Get student's roll number based on email
            $email = $_SESSION['email'];
            $q1 = "SELECT hostel_id from student where email = '$email'";
            $res1 = mysqli_query($conn, $q1);
            
            if($r1 = mysqli_fetch_assoc($res1)){
                if($r1['hostel_id'] == NULL){
                    echo "<script>alert('Error: You have not been alloted any hostel(can't use any features!).');</script>";
                    header('Location: student_homepage.html');
                }
            }

            $query1 = "SELECT roll_no FROM student WHERE email='$email' ";
            $result1 = mysqli_query($conn, $query1);
            if (!$result1) {
                die("Query failed:" . mysqli_error($conn));
            }
            $roll_no_row = mysqli_fetch_assoc($result1);
            $roll_no = $roll_no_row['roll_no'];


            // $query1 = "SELECT roll_no FROM student JOIN parcel_table WHERE roll_no='$roll_no'";

            // $result1 = mysqli_query($conn, $query1);
            // $roll_no = "";
            // if ($result1 && mysqli_fetch_assoc($result1)) {
            //     $roll_no_row = mysqli_fetch_assoc($result1);
            //     $roll_no = $roll_no_row;
            // }

            $query = "SELECT * FROM parcel_table WHERE roll_no='$roll_no' ";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                die("Query failed:" . mysqli_error($conn));
            }

            while ($row = mysqli_fetch_assoc($result)) {
                $p_no = $row['parcel_no'];

                echo '<tr>
                <td>' . $row['parcel_no'] . '</td>
                <td>' . $row['sname'] . '</td>
                <td>' . $row['roll_no'] . '</td>
                <td>' . $row['arrival_date'] . '</td>
                <td>' . $row['received_date'] . '</td>
        
                <td class="up_del-btn">
                    <form action="student_parcel.php" method="POST" >
                        <input type="hidden" name="parcel_no" value="' . $p_no . '">
                        <button type="submit" class="btn btn-success" name="received">Received Date</button>
                    </form>
                </td>
            </tr>';
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['received'])) {
                $parcel_no = $_POST['parcel_no'];
                $currentDate = date("Y-m-d"); // Format: Year-Month-Day
                $query = "UPDATE parcel_table SET received_date='$currentDate' WHERE parcel_no='$parcel_no' ";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    header('Location: student_parcel.php');
                    exit();
                } else {
                    die("Query failed:" . mysqli_error($conn));
                }
            }
            ?>


        </tbody>
    </table>


</body>

</html>
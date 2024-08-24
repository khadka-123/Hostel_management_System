<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link rel="stylesheet" href="../styles_d/style1.css">
</head>

<body>
<nav class="navbar">
        <div class="container-logo">
            <a class="navbar-logo" href="../admin/admin_homepage.html" id="logoLink">
                <img src="../style/logo.jpg" alt="Logo">
            </a>
        </div>
        <div class="Dashboard">
            <p>Student Details</p>
        </div>
    </nav>

    <table class="content-table">
        <thead>
            <tr>
                <th>Roll No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>gender</th>
                <th>Hostel name</th>
                <th>Room No</th>
            </tr>
        </thead>

        <tbody>
            <?php
            if (!session_id()) {
                session_start();
            }
            $server = "localhost";
            $username = "root";
            $password = "";
            $database = "hostel_management_system";

            include('../connection.php');

            $sql = "SELECT * FROM student";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                die("Invalid query: " . $conn->error);
            }

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["roll_no"] . "</td>
                        <td>" . $row["sname"] . "</td>
                        <td>" . $row["email"] . "</td>
                        <td>" . $row["phone_no"] . "</td>
                        <td>" . $row["gender"] . "</td>";

                if ($row["hostel_id"] == 1) {
                    echo "<td>Boys Hostel</td>";
                    $q = "SELECT room_no FROM boys_hostel WHERE occupant1_roll_no = '{$row['roll_no']}' OR occupant2_roll_no = '{$row['roll_no']}'";
                    $result2 = mysqli_query($conn, $q);

                    if ($result2) {
                        if ($row2 = mysqli_fetch_assoc($result2)) {
                            echo "<td>" . $row2["room_no"] . "</td>";
                        }
                        else{
                            echo "<td>nil</td>";
                        }
                    } 
                } else if($row["hostel_id"] == 2) {
                    echo "<td>Girls Hostel</td>";
                    $q = "SELECT room_no FROM girls_hostel WHERE occupant1_roll_no = '{$row['roll_no']}' OR occupant2_roll_no = '{$row['roll_no']}'";
                    $result2 = mysqli_query($conn, $q);

                    if ($result2) {
                        if ($row2 = mysqli_fetch_assoc($result2)) {
                            echo "<td>" . $row2["room_no"] . "</td>";
                        }
                        else{
                            echo "<td>nil</td>";
                        }
                    } 

                }
                else{
                    echo "<td>not alloted</td>";
                    echo "<td>nil</td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>
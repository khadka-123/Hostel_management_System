<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Detail</title>
    <link rel="stylesheet" href="../styles_d/style2.css">
</head>

<body>
    <header>
        <div class="navbar">
            <div class="nav-logo">
                <a href="../student/student_homepage.html">
                    <div class="logo"></div>
                </a>
            </div>

            <div class="stu">
                <h2>My Details</h2>
            </div>
        </div>
    </header>

    <!-- <form action="my_detail.php" method="post">
        <input type="text" id="name" name="roll_no" placeholder="Enter your Roll number"><br><br>
        <button class="btn">Submit</button>
    </form> -->

    <!-- Show details -->
    <?php

    if (!session_id()) {
        session_start();
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
        } else {
            echo "please login";
        }
    }


    // Database connection details
    include('../connection.php');

    $sql = "SELECT * FROM student WHERE email = '$email'";  // using session
    $result = $conn->query($sql);
    $hostel_id = "";

    if ($row = mysqli_fetch_assoc($result)) {
        if ($row['hostel_id'] != NULL)
            $hostel_id = $row['hostel_id'];
    }

    $hostel_name = "";
    if ($hostel_id != "") {
        // Read data from the database table
        $sql = "SELECT * FROM student NATURAL JOIN hostel WHERE email = '$email'";  // using session
        $result = $conn->query($sql);

        if ($row = mysqli_fetch_assoc($result)) {
            $hostel_name = $row['hostel_name'];
        }
    }

    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
    ?>
        <div id="temp">
            <div class="box">
                <div class="grid-container">
                    <?php
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <div class="grid-item-r1">
                            <h3>Name :</h3>
                        </div>
                        <div class="grid-item-r2">
                            <p><?php echo $row["sname"]; ?></p>
                        </div>
                        <div class="grid-item-r1">
                            <h3>Roll no :</h3>
                        </div>
                        <div class="grid-item-r2">
                            <p><?php echo $row["roll_no"]; ?></p>
                        </div>
                        <div class="grid-item-r1">
                            <h3>Email :</h3>
                        </div>
                        <div class="grid-item-r2">
                            <p><?php echo $row["email"]; ?></p>
                        </div>
                        <div class="grid-item-r1">
                            <h3>Gender :</h3>
                        </div>
                        <div class="grid-item-r2">
                            <p><?php echo $row["gender"]; ?></p>
                        </div>
                        <div class="grid-item-r1">
                            <h3>Address :</h3>
                        </div>
                        <div class="grid-item-r2">
                            <p><?php echo $row["address"]; ?></p>
                        </div>
                        <div class="grid-item-r1">
                            <h3>Phone no. :</h3>
                        </div>
                        <div class="grid-item-r2">
                            <p><?php echo $row["phone_no"]; ?></p>
                        </div>
                        <div class="grid-item-r1">
                            <h3>Hostel name :</h3>
                        </div>
                        <div class="grid-item-r2">
                            <p><?php echo $hostel_name; ?></p>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php
    } else {
        echo "No records found.";
    }
    $conn->close();
    ?>
</body>

</html>
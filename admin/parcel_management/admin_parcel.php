<?php
session_start();

include("../../connection.php");
            
            $query="select * from parcel_table";
            $result=mysqli_query($conn,$query);

            if(!$result){
                die("Query failed:" .mysqli_error($conn));
            }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Parcel Details</title>
    <link rel="stylesheet" href="admin_parcel.css">

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

    <div class="add_student">
       <a href="add_parcel.php" class="btn btn-primary">Add Parcel</a>
    </div>

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

            while($row=mysqli_fetch_assoc($result)){
                $p_no=$row['parcel_no'];

                echo '<tr>
                <td>' . $row['parcel_no'] . '</td>
                <td>' . $row['sname'] . '</td>
                <td>' . $row['roll_no'] . '</td>
                <td>' . $row['arrival_date'] . '</td>
                <td>' . $row['received_date'] . '</td>

                <td class="up_del-btn">
                    <a class="btn btn-success" href="admin_parcel_update.php?updateid=' .$p_no. '">Update</a>
                    <a class="btn btn-danger" href="admin_parcel_delete.php?deleteid=' .$p_no. '">Delete</a>
                </td>
            </tr>';
        }
        mysqli_close($conn);
                ?>

        </tbody>
    </table>


</body>
</html>
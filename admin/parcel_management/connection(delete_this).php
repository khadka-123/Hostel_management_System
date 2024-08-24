<?php
$conn=mysqli_connect("localhost","root","","hostel_management_system", 3308);

if(!$conn){
    die("connection failed:" .mysqli_connect_error());
}
?>
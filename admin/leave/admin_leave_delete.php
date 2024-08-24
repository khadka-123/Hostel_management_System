<?php
session_start();

include('../../connection.php');

//using get method we can access the
//vaue from the url (i.e parameter passed in url)
 if(isset($_GET["deleteid"])){
    $roll_no=$_GET["deleteid"];
    $query="DELETE FROM leave_record where roll_no = '$roll_no' ";
    $result=mysqli_query($conn,$query);

    if($result){
        header("location:admin_leave.php");
        exit;
    }
    else{
        die("errro deleting parcel:" .mysqli_error($con));
    }
 }

?>
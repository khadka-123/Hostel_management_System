<?php
session_start();

include('../../connection.php');

//using get method we can access the
//vaue from the url (i.e parameter passed in url)
 if(isset($_GET["deleteid"])){
    $p_no=$_GET["deleteid"];
    $query="DELETE FROM parcel_table where parcel_no='$p_no' ";
    $result=mysqli_query($conn,$query);

    if($result){
        header("location:admin_parcel.php");
        exit;
    }
    else{
        die("errro deleting parcel:" .mysqli_error($conn));
    }
 }

?>
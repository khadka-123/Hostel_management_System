<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration</title>
  <link href="registration.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
    <h1>Student Registration</h1>
    <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input type="email" placeholder="example@123.com" class="form-control" name="email" aria-describedby="emailHelp" required style="font-size: small;">
    </div>
    <div class="mb-3">
      <label for="password">Password</label>
      <input type="password" placeholder="(a-z) (A-Z) (0-9) (No special chars)" class="form-control" name="password" required style="font-size: small;">
    </div>
    <div class="mb-3">
      <label for="confirm">Confirm password </label>
      <input type="text" placeholder="Confirm password" class="form-control" name="confirm" required style="font-size: small;">
    </div>
    <div class="mb-3">
      <label for="name">Name</label>
      <input type="text" placeholder="First and Last name" class="form-control" name="name" required style="font-size: small;">
    </div>
    <div class="mb-3">
      <label for="roll_no">Roll no</label>
      <input type="text" placeholder="0-9" class="form-control" name="roll_no" required pattern="[0-9]*" style="font-size: small;">
    </div>
    <div class="mb-3">
      <label for="address">Address</label>
      <input type="text" placeholder="Your Address" class="form-control" name="address" required style="font-size: small;">
    </div>
    <div class="mb-3">
      <label>Gender</label><br>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="gender" id="male" value="male">
        <label class="form-check-label" for="male">Male</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="gender" id="female" value="female" required>
        <label class="form-check-label" for="female">Female</label>
      </div>
    </div>

    <div class="mb-3">
      <label for="phone_no">Phone number</label>
      <input type="text" placeholder="10 digit (0-9)" class="form-control" name="phone_no" pattern="[0-9]{10}" style="font-size: small;">
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Register</button>
  </form>
</body>

</html>
<?php 
if (!session_id()) {
  session_start();
}
include('connection.php');

$flag1 = true; //if true till the end, we add to the db ( for email)
$flag2 = true; //for password match

if (isset($_POST['email']) ) {
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
  
  // Check if the email already exists
  $check_email_sql = "SELECT * FROM `student` WHERE `email` = '$email'";
  $check_email_result = mysqli_query($conn, $check_email_sql);

  if (mysqli_num_rows($check_email_result) > 0) {
    echo "<script>alert('Error: Email already exists. Please use a different email.');</script>";
    $flag1 = false;
  } 
  else {
    $flag1 = true;
  }
}

if (isset($_POST['roll_no']) ) {
  $roll_no = filter_input(INPUT_POST, 'roll_no', FILTER_SANITIZE_SPECIAL_CHARS);
  
  // Check if the email already exists
  $check_roll_no_sql = "SELECT * FROM `student` WHERE `roll_no` = '$roll_no'";
  $check_roll_no_result = mysqli_query($conn, $check_roll_no_sql);

  if (mysqli_num_rows($check_roll_no_result) > 0) {
    echo "<script>alert('Error: Roll no already exists. Please use a different roll no.');</script>";
    $flag1 = false;
  } else {
    $flag1 = true;
  }
}

if (isset($_POST['password']) && isset($_POST['confirm'])) {
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
  $confirm = filter_input(INPUT_POST, 'confirm', FILTER_SANITIZE_SPECIAL_CHARS);
  if ($confirm != $password) {
    echo "<script>alert('Error: Passwords do not match. Please try again.');</script>";
    $flag2 = false;
  } else {
    $flag2 = true;
  }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && $flag1 == true && $flag2 == true) {
  $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
  $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_SPECIAL_CHARS);
  $phone_no = filter_input(INPUT_POST, 'phone_no', FILTER_SANITIZE_SPECIAL_CHARS);
  $address = $_POST['address'];

  //add user to data base

  // Add user to the database if email doesn't exist
  $sql = "INSERT INTO `student` (`roll_no`, `sname`, `email`, `phone_no`, `gender`, `password`, `address`)
  VALUES ('$roll_no', '$name', '$email', '$phone_no', '$gender', '$password', '$address')";


  $result = mysqli_query($conn, $sql);

  if ($result) {
    echo "<script>alert('User registered successfully.');</script>";
    header('Location: login.php');
  } else {
    echo "<script>alert('Error: Unable to register user.');</script>";
  }
}
?>
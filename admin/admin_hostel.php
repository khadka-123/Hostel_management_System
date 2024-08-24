<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['hostel'])) {
    $_SESSION['hostel_selected'] = $_POST['hostel'];
    header("Location: admin_roomallotment.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Selection</title>
    <link href="../style/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body{
            background-image: url("../style/3hp.jpg"); 
        }
        .container{
            margin-top: 8%;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container-logo">
            <a class="navbar-logo" href="#" id="logoLink">
                <img src="../style/logo.jpg" alt="Logo">
            </a>
        </div>
        <div class="Dashboard">
            <p>Hostels</p>
        </div>
    </nav>

    <div class="container">
        <div class="content">
            <!-- Form for selecting hostel -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="card" onclick="selectHostel('Boys')" >
                <!-- style="background-color: " -->
                <img src="../style/male.jpg">
                    <p>Boys Hostel</p>
                    <input type="hidden" name="hostel" value="Boys">
                </div>
            </form>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="card" onclick="selectHostel('Girls');">
                    <img src="../style/female.jpg">
                    <p class="title">Girls Hostel</p>
                    <input type="hidden" name="hostel" value="Girls">
                </div>
            </form>
        </div>
    </div>

    <script>
        function selectHostel(hostel) {
            document.querySelector(`input[name="hostel"][value="${hostel}"]`).closest('form').submit();
        }
    </script>

</body>

</html>

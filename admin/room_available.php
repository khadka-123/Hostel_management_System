<?php
if (!session_id()) {
    session_start();
}

//generate the rooms
$rooms_available = [];

include('../connection.php');

// available rooms
$hostel = $_SESSION['hostel_selected'];

if ($hostel == 'Boys') {
    $temp = "boys_hostel";
} else
    $temp = "girls_hostel";

$query = "SELECT `room_no` FROM $temp WHERE `status_` = 2";
$result = mysqli_query($conn, $query);

// Fetch unavailable room numbers and store them in an array
$unavailable_rooms = [];
while ($row = mysqli_fetch_assoc($result)) {
    $unavailable_rooms[] = $row['room_no'];
}

// Generate available room numbers
for ($i = 1; $i <= 755; $i++) {
    $room_number = $i;
    // Check if the room number falls within the valid ranges and is not in the unavailable_rooms array
    if (
        ($room_number >= 1 && $room_number <= 55) ||
        ($room_number >= 100 && $room_number <= 155) ||
        ($room_number >= 200 && $room_number <= 255) ||
        ($room_number >= 300 && $room_number <= 355) ||
        ($room_number >= 400 && $room_number <= 455) ||
        ($room_number >= 500 && $room_number <= 555) ||
        ($room_number >= 600 && $room_number <= 655) ||
        ($room_number >= 700 && $room_number <= 755)
    ) {
        if (in_array($room_number, $unavailable_rooms)) {
            continue; // Skip this room if it's unavailable
        } else {
            $rooms_available[] = $room_number;
        }
    } else {
        $i += 43; // Jump to next floor
    }
}

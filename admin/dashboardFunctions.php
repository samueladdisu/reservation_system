<?php session_start(); ?>
<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php
// header("Content-Type: application/json"); 
// header("Access-Control-Allow-Origin: *"); 
// header("Access-Control-Allow-Methods: GET,POST,OPTIONS,DELETE,PUT"); 
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$received_data = json_decode(file_get_contents("php://input"));

if ($received_data->action == 'noRoomsAvailable') {
    $location = $received_data->location;
    $bookedRoomsNumber = 0;
    $availableRooms = 0;
    if ($location == "all") {

        $update_query = "SELECT * FROM reservations WHERE res_checkin = CURDATE() AND res_status != 'Canceled'";
        $update_result = mysqli_query($connection, $update_query);

        $exists = mysqli_num_rows($update_result);
        if ($exists == 0) {
            $update_query = " SELECT COUNT(*) FROM rooms";
            $update_result = mysqli_query($connection, $update_query);
            $row = mysqli_fetch_assoc($update_result);
            $availableRooms = $row['COUNT(*)'];

            $response = array(
                "booked" => $bookedRoomsNumber,
                "AvailableRooms" => $availableRooms,
            );


            echo json_encode($response);
        } else {

            while ($row = mysqli_fetch_assoc($update_result)) {
                $rooms[] = $row['res_roomIDs'];
            }

            $combined = implode(",", $rooms); // Combining both array into a single string
            $results = json_decode("[" . $combined . "]", true); // Converting string into array
            $count = count($results[0]); // Counting the number of elements in array

            $bookedRoomsNumber =  $count; // Output the result

            $update_query = "SELECT COUNT(*) FROM rooms";
            $update_result = mysqli_query($connection, $update_query);
            $row = mysqli_fetch_assoc($update_result);
            $availableRooms = $row['COUNT(*)'] - $count;

            $response = array(
                "booked" => $bookedRoomsNumber,
                "AvailableRooms" => $availableRooms,
            );

            echo json_encode($response);
        }
        // echo json_encode($exists);
    } else {

        $update_query = "SELECT * FROM reservations WHERE res_checkin = CURDATE() AND res_location = '$location' AND res_status != 'Canceled'";
        $update_result = mysqli_query($connection, $update_query);

        $exists = mysqli_num_rows($update_result);
        if ($exists == 0) {
            $update_query = " SELECT COUNT(*) FROM rooms WHERE room_location = '$location'";
            $update_result = mysqli_query($connection, $update_query);
            $row = mysqli_fetch_assoc($update_result);
            $availableRooms = $row['COUNT(*)'];

            $response = array(
                "booked" => $bookedRoomsNumber,
                "AvailableRooms" => $availableRooms,

            );


            echo json_encode($response);
        } else {
            while ($row = mysqli_fetch_assoc($update_result)) {
                $roomIDs = json_decode($row['res_roomIDs']); // Convert the string to an array
                $rooms[] = $roomIDs;
            }
            // echo json_encode($rooms);

            // $combined = implode(",", $rooms); // Combining both array into a single string
            $results = array_merge(...$rooms); // Converting string into array
            $count = count($results); // Counting the number of elements in array

            $bookedRoomsNumber =  $count; // Output the result

            $update_query = "SELECT COUNT(*) FROM rooms WHERE room_location = '$location'";
            $update_result = mysqli_query($connection, $update_query);
            $row = mysqli_fetch_assoc($update_result);
            $availableRooms = $row['COUNT(*)'] - $count;

            $response = array(
                "booked" => $bookedRoomsNumber,
                "AvailableRooms" => $availableRooms,
            );

            echo json_encode($response);
        }
    }
}


if ($received_data->action == 'arrivalDeparture') {
    $location = $received_data->location;
    if ($location == "all") {
        $update_query = "SELECT COUNT(CASE WHEN res_checkout = CURDATE() THEN 1 ELSE NULL END) AS rooms_leaving_today, COUNT(CASE WHEN res_checkin = CURDATE() THEN 1 ELSE NULL END) AS rooms_arriving_today FROM reservations WHERE res_status != 'Canceled' ";
        $update_result = mysqli_query($connection, $update_query);
        $row = mysqli_fetch_assoc($update_result);
        echo json_encode($row);
    } else {
        $update_query = "SELECT COUNT(CASE WHEN res_checkout = CURDATE() THEN 1 ELSE NULL END) AS rooms_leaving_today, COUNT(CASE WHEN res_checkin = CURDATE() THEN 1 ELSE NULL END) AS rooms_arriving_today FROM reservations WHERE res_location = '$location' AND res_status != 'Canceled'";
        $update_result = mysqli_query($connection, $update_query);
        $row = mysqli_fetch_assoc($update_result);
        echo json_encode($row);
    }
}

if ($received_data->action == 'barGraph') {
    $location = $received_data->location;

    $update_query = "SELECT COUNT(CASE WHEN res_status = 'checkedIn' THEN 1 ELSE NULL END) AS checkedIn, COUNT(CASE WHEN res_status = 'checkedOut' THEN 1 ELSE NULL END) AS checkedout FROM reservations WHERE res_location = '$location' AND res_checkin = CURDATE()";

    $update_result = mysqli_query($connection, $update_query);
    $row = mysqli_fetch_assoc($update_result);
    echo json_encode($row);
}

if ($received_data->action == 'specialRequest') {
    $location = $received_data->location;

    if ($location == "all") {
        $update_query = "SELECT 
        COUNT(CASE WHEN type = 'lunch' THEN 1 END) AS lunch_count,
        COUNT(CASE WHEN type = 'wedding' THEN 1 END) AS wedding_count,
        COUNT(CASE WHEN type = 'birthday' THEN 1 END) AS birthday_count,
        COUNT(CASE WHEN type = 'anniversary' THEN 1 END) AS anniversary_count,
        COUNT(CASE WHEN type = 'proposal' THEN 1 END) AS proposal_count,
        COUNT(CASE WHEN type = 'shuttle' THEN 1 END) AS shuttle_count,
        COUNT(CASE WHEN type = 'landscape' THEN 1 END) AS landscape_count,
        COUNT(CASE WHEN type = 'other' THEN 1 END) AS other_count,
        COUNT(*) AS total_count
    FROM special_request
    WHERE date = DATE(NOW())";
        $update_result = mysqli_query($connection, $update_query);

        $exists = mysqli_num_rows($update_result);
        $row = mysqli_fetch_assoc($update_result);
        echo json_encode($row);
    } else {
        $update_query = "SELECT 
        COUNT(CASE WHEN type = 'lunch' THEN 1 END) AS lunch_count,
        COUNT(CASE WHEN type = 'wedding' THEN 1 END) AS wedding_count,
        COUNT(CASE WHEN type = 'birthday' THEN 1 END) AS birthday_count,
        COUNT(CASE WHEN type = 'anniversary' THEN 1 END) AS anniversary_count,
        COUNT(CASE WHEN type = 'proposal' THEN 1 END) AS proposal_count,
        COUNT(CASE WHEN type = 'shuttle' THEN 1 END) AS shuttle_count,
        COUNT(CASE WHEN type = 'landscape' THEN 1 END) AS landscape_count,
        COUNT(CASE WHEN type = 'other' THEN 1 END) AS other_count,
        COUNT(*) AS total_count
    FROM special_request
    WHERE date = DATE(NOW()) AND location = '$location'";
        $update_result = mysqli_query($connection, $update_query);

        $exists = mysqli_num_rows($update_result);
        $row = mysqli_fetch_assoc($update_result);
        echo json_encode($row);
    }
}


if ($received_data->action == 'DonutChart') {
    $location = $received_data->location;
    $query = "SELECT rooms.room_acc, COUNT(rooms.room_acc) - COUNT(reservations.res_roomType) AS free_rooms FROM rooms LEFT JOIN reservations ON rooms.room_acc = reservations.res_roomType AND reservations.res_checkin <= CURRENT_DATE() AND reservations.res_checkout >= CURRENT_DATE() AND reservations.res_location = '$location' AND reservations.res_status != 'Canceled' WHERE
    rooms.room_location = '$location' GROUP BY rooms.room_acc";

    $update_result = mysqli_query($connection, $query);

    $exists = mysqli_num_rows($update_result);
    while ($row = mysqli_fetch_assoc($update_result)) {
        $data[] = $row;
    }


    echo json_encode($data);
}


if ($received_data->action == 'cancelation') {
    $location = $received_data->location;
    $query = "SELECT COUNT(*) AS canceled FROM reservations WHERE res_status = 'Canceled' AND res_checkin = CURDATE() AND res_location = '$location'";

    $update_result = mysqli_query($connection, $query);

    $exists = mysqli_num_rows($update_result);
    $row = mysqli_fetch_assoc($update_result);


    echo json_encode($row);
}

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
    $update_query = "SELECT  SUM(CASE WHEN room_status = 'booked' THEN 1 ELSE 0 END) AS booked_rooms, SUM(CASE WHEN room_status = 'Not_booked' THEN 1 ELSE 0 END) AS available_rooms FROM  rooms";
    $update_result = mysqli_query($connection, $update_query);
    $row = mysqli_fetch_assoc($update_result);
    // confirm($update_result);

    echo json_encode($row);
}


if ($received_data->action == 'arrivalDeparture') {
    $location = $received_data->location;
    $update_query = "SELECT COUNT(CASE WHEN res_checkout = CURDATE() THEN 1 ELSE NULL END) AS rooms_leaving_today, COUNT(CASE WHEN res_checkin = CURDATE() THEN 1 ELSE NULL END) AS rooms_arriving_today FROM reservations";
    $update_result = mysqli_query($connection, $update_query);
    $row = mysqli_fetch_assoc($update_result);
    // confirm($update_result);

    echo json_encode($row);
}

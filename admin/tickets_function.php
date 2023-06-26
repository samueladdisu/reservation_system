<?php session_start(); ?>
<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php

$received_data = json_decode(file_get_contents("php://input"));
date_default_timezone_set('Africa/Addis_Ababa');


$location = $_SESSION['user_location'];
$role = $_SESSION['user_role'];
$filterd_data = array();
$Not_booked_array = array();
$allData = array();
$data = array();
$rooms = array();


if ($received_data->action == "fetchAllTickets") {
    if ($role == "SA" || ($location == "Boston" && $role == 'RA')) {
        $query = "SELECT * FROM activity_reservation_superapps WHERE order_status != 'redeemed' ORDER BY id DESC";
    } else {
        $query = "SELECT * FROM activity_reservation_superapps WHERE location = '$location' AND order_status != 'redeemed' ORDER BY id DESC";
    }

    $result = mysqli_query($connection, $query);

    $exists = mysqli_num_rows($result);

    if ($exists > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            $data[] = $row;
        }

        echo json_encode($data);
    } else {
        echo json_encode("empty");
    }
}


if ($received_data->action == "fetchAllTicketsR") {
    if ($role == "SA" || ($location == "Boston" && $role == 'RA')) {
        $query = "SELECT * FROM activity_reservation_superapps WHERE order_status = 'redeemed' ORDER BY id DESC";
    } else {
        $query = "SELECT * FROM activity_reservation_superapps WHERE location = '$location' AND order_status = 'redeemed' ORDER BY id DESC";
    }

    $result = mysqli_query($connection, $query);

    $exists = mysqli_num_rows($result);

    if ($exists > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            $data[] = $row;
        }

        echo json_encode($data);
    } else {
        echo json_encode("empty");
    }
}



if ($received_data->action == "fetchLocationTickets") {

    $loco =  $received_data->location;

    $query = "SELECT * FROM activity_reservation_superapps WHERE location = '$loco' AND order_status != 'redeemed' ORDER BY id DESC";


    $result = mysqli_query($connection, $query);

    $exists = mysqli_num_rows($result);

    if ($exists > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            $data[] = $row;
        }

        echo json_encode($data);
    } else {
        echo json_encode([]);
    }
}


if ($received_data->action == "fetchLocationTicketsR") {

    $loco =  $received_data->location;

    $query = "SELECT * FROM activity_reservation_superapps WHERE location = '$loco' AND order_status = 'redeemed' ORDER BY id DESC";


    $result = mysqli_query($connection, $query);

    $exists = mysqli_num_rows($result);

    if ($exists > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            $data[] = $row;
        }

        echo json_encode($data);
    } else {
        echo json_encode([]);
    }
}

if ($received_data->action == "redeemTicket") {

    $ID =  $received_data->ID;

    $query = "UPDATE activity_reservation_superapps SET order_status = 'redeemed' WHERE id = $ID";


    $result = mysqli_query($connection, $query);
    confirm($result);

    return true;
}

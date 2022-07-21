<?php
ob_start();
session_start();
require  '../admin/includes/db.php';
require  '../admin/includes/functions.php';
require '../vendor/autoload.php';

$cybsResponse = $_REQUEST;
$Response = json_encode($cybsResponse);
$jsonl = json_decode($Response, true);
$decision = $jsonl["decision"];
$reason = $jsonl["reason_code"];

if (isset($_COOKIE['cart'])) {

    $cart = json_decode($_COOKIE['cart']);
}
var_dump($cart);
$id = array();
echo $location = $_SESSION['location'];
echo $checkIn =  $_SESSION['checkIn'];
echo $checkOut = $_SESSION['checkOut'];
echo $total_price = $_SESSION['total'];
echo $slocation = $_SESSION['Selectedlocation'];


function getName($n)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}

$res_confirmID = getName(8);
foreach ($cart as  $val) {
    $id[] = $val->room_id;
}
$id_sql = json_encode($id);
$id_int = implode(',', $id);


$app_id = $_ENV['FRONT_APP_ID'];
$app_key = $_ENV['FRONT_KEY'];
$app_secret = $_ENV['FRONT_SECRET'];
$app_cluster = 'mt1';

$pusher = new Pusher\Pusher($app_key, $app_secret, $app_id, ['cluster' => $app_cluster]);

if ($decision == "ACCEPT" && $reason == "100") {
    foreach ($id  as $value) {

        //  Select room details from room id 


        $room_query = "SELECT room_acc, room_location FROM rooms WHERE room_id = $value";

        $room_result = mysqli_query($connection, $room_query);
        confirm($room_result);
        $room_row = mysqli_fetch_assoc($room_result);


        // Insert into booked table

        $booked_query = "INSERT INTO booked_rooms(b_roomId, b_roomType, b_roomLocation, b_checkin, b_checkout) ";
        $booked_query .= "VALUES ($value, '{$room_row['room_acc']}', '{$room_row['room_location']}',  '{$checkIn}', '{$checkOut}')";

        $booked_result = mysqli_query($connection, $booked_query);

        confirm($booked_result);
    }

    $query = "INSERT INTO reservations(res_firstname, res_lastname, res_phone, res_email, res_checkin, res_checkout, res_country, res_address, res_city, res_zipcode, res_paymentMethod, res_roomIDs, res_price, res_location, res_confirmID, res_specialRequest, res_guestNo, 	res_agent) ";
    $query .= "VALUES('{$params['res_firstname']}', '{$_SESSION['res_lastname']}', '{$_SESSION['res_phone']}', '{$_SESSION['res_email']}', '$checkIn', '$checkOut', '{$params['res_country']}', '{$_SESSION['res_address']}', '{$_SESSION['res_city']}', '{$_SESSION['res_zip']}', '{$_SESSION['res_paymentMethod']}', '$id_sql', '{$total_price}', '{$location}', '{$res_confirmID}', '{$_SESSION['res_specialRequest']}', '{$_SESSION['res_guestNo']}', 'website') ";

    $result = mysqli_query($connection, $query);
    confirm($result);


    $status_query = "UPDATE `rooms` SET `room_status` = 'booked' WHERE `room_id` IN ($id_int)";
    $result_status = mysqli_query($connection, $status_query);
    confirm($result_status);

    $data = true;


    $_SESSION['cart']       = null;
    $_SESSION['slocation']   = null;
    $_SESSION['location']   = null;
    $_SESSION['checkIn']    = null;
    $_SESSION['checkOut']   = null;
    $_SESSION['total']      = 0;

    $pusher->trigger('front_notifications', 'front_reservation', $data);
} elseif ($reason == "481") {

    file_put_contents("Lemlem.txt", $reason . PHP_EOL . PHP_EOL, FILE_APPEND);
} else {

    file_put_contents("Lemlem.txt", $reason . PHP_EOL . PHP_EOL, FILE_APPEND);
}

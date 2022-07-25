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

function returnid(array $CHARS)
{
    $IDfromUID = "";
    for ($x = 13; $x < sizeof($CHARS); $x++) {
        $IDfromUID .= $CHARS[$x];
    }
    return $IDfromUID;
}
$intoArray = str_split($jsonl["req_transaction_uuid"]);
$PayerId = returnid($intoArray);

$queryFetch = "SELECT * FROM temp_res WHERE temp_ID = '$PayerId'";
$temp_res = mysqli_query($connection, $queryFetch);

confirm($temp_res);
$temp_row = mysqli_fetch_assoc($temp_res);

$firstName = $temp_row['firstName'];
$lastName = $temp_row['lastName'];
$email = $temp_row['email'];
$address = $temp_row['resAddress'];
$city = $temp_row['city'];
$country = $temp_row['country'];
$phonNum = $temp_row['phoneNum'];
$zipCode = $temp_row['zipCode'];
$specReq = $temp_row['specialRequest'];
$promoCode = $temp_row['promoCode'];
$total = $temp_row['total'];
$cart2 = $temp_row['cart'];
$PayMethod = $temp_row['paymentMethod'];
$cart = json_decode($cart2);


file_put_contents("Lemlem.txt", gettype($cart2) . PHP_EOL . PHP_EOL, FILE_APPEND);
file_put_contents("Lemlem.txt", $cart2['adults'] . PHP_EOL . PHP_EOL, FILE_APPEND);
file_put_contents("Lemlem.txt", $cart['adults'] . PHP_EOL . PHP_EOL, FILE_APPEND);
file_put_contents("Lemlem.txt", gettype($cart['adults'])  . PHP_EOL . PHP_EOL, FILE_APPEND);
file_put_contents("Lemlem.txt", $PayerId . PHP_EOL . PHP_EOL, FILE_APPEND);


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

$checkinDate = "";
$checkoutDate = "";
$id = array();

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
    $singleRoom = $cart;
    // foreach ($cart as  $singleRoom) {

    if (($checkinDate == $singleRoom['checkin'] && $checkoutDate == $singleRoom["checkout"]) || ($checkinDate == '' && $checkoutDate == '')) {
        $checkinDate = $singleRoom["checkin"];
        $checkoutDate = $singleRoom["checkout"];
        $roomID = $singleRoom["room_id"];
        $location = $singleRoom["room_location"];
        $guestNum = [$singleRoom["adults"], $singleRoom["kid"], $singleRoom["teen"]];
        $guestNumS = json_encode($guestNum);
        //  Select room details from room id 


        $room_query = "SELECT room_acc, room_location FROM rooms WHERE room_id = $roomID";


        $room_result = mysqli_query($connection, $room_query);
        confirm($room_result);
        $room_row = mysqli_fetch_assoc($room_result);


        // Insert into booked table

        $booked_query = "INSERT INTO booked_rooms(b_roomId, b_roomType, b_roomLocation, b_checkin, b_checkout) ";
        $booked_query .= "VALUES ($value, '{$room_row['room_acc']}', '{$room_row['room_location']}',  '{$checkinDate}', '{$checkoutDate}')";

        $booked_result = mysqli_query($connection, $booked_query);

        confirm($booked_result);


        $query = "INSERT INTO reservations(res_firstname, res_lastname, res_phone, res_email, res_checkin, res_checkout, res_country, res_address, res_city, res_zipcode, res_paymentMethod, res_roomIDs, res_price, res_location, res_confirmID, res_specialRequest, res_guestNo, 	res_agent) ";
        $query .= "VALUES('$firstName', '$lastName', '$phoneNum', '$email', '$checkinDate', '$checkoutDate', '$country', '$address', '$city', '$zipCode', '$PayMethod', '$roomID', '{$total}', '{$location}', '{$res_confirmID}', '$specReq', '$guestNumS', 'website') ";

        $result = mysqli_query($connection, $query);
        confirm($result);


        $status_query = "UPDATE `rooms` SET `room_status` = 'booked' WHERE `room_id` IN ($roomID)";
        $result_status = mysqli_query($connection, $status_query);
        confirm($result_status);

        $data = true;
    }
    // }
    $data = true;
    $pusher->trigger('front_notifications', 'front_reservation', $data);
} elseif ($reason == "481") {

    file_put_contents("Lemlem.txt", $reason . PHP_EOL . PHP_EOL, FILE_APPEND);
} else {

    file_put_contents("Lemlem.txt", $reason . PHP_EOL . PHP_EOL, FILE_APPEND);
}

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
$room_ids = json_decode($temp_row['room_id']);
$guestInfos = json_decode($temp_row['guestInfo']);
$room_nums = json_decode($temp_row['room_num']);
$room_accs = json_decode($temp_row['room_acc']);
$room_locs = json_decode($temp_row['room_location']);
$CiCos = json_decode($temp_row['CinCoutInfo']);


file_put_contents("Lemlem.txt", gettype($cart2) . PHP_EOL . PHP_EOL, FILE_APPEND);
// file_put_contents("Lemlem.txt", $cart2['adults'] . PHP_EOL . PHP_EOL, FILE_APPEND);
file_put_contents("Lemlem.txt", $cart['adults'] . PHP_EOL . PHP_EOL, FILE_APPEND);
file_put_contents("Lemlem.txt", gettype($cart)  . PHP_EOL . PHP_EOL, FILE_APPEND);
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

// $checkinDate = "";
// $checkoutDate = "";
// $id = array();

// foreach ($cart as  $val) {
//     $id[] = $val->room_id;
// }
// $id_sql = json_encode($id);
// $id_int = implode(',', $id);

$res_confirmID = getName(5);

// $app_id = $_ENV['FRONT_APP_ID'];
// $app_key = $_ENV['FRONT_KEY'];
// $app_secret = $_ENV['FRONT_SECRET'];
// $app_cluster = 'mt1';

// $pusher = new Pusher\Pusher($app_key, $app_secret, $app_id, ['cluster' => $app_cluster]);

if ($decision == "ACCEPT" && $reason == "100") {
    // $singleRoom = $cart;

    $numofRooms = count($room_ids);
    $i=0;
    $carts = array();
    while ($i<$numofRooms){

       $oneReservation = array(
            'Checkin' => $CiCos[$i][0],
            'Checkout' => $CiCo[$i][1],
            'roomId' => $room_ids[$i],
            'adults' => $guestInfos[$i][0],
            'teens' => $guestInfos[$i][1],
            'kid' => $guestInfos[$i][2],
            'roomNum' => $room_nums[$i],
            'roomAcc' => $room_accs[$i],
            'roomLocation' => $room_locs[$i],
            'guestnums' => [$guestInfos[$i][0], $guestInfos[$i][1], $guestInfos[$i][2]]
        
        );
        array_push($carts, $oneReservation );
        
   $i++;

}

foreach ($carts  as $value) {
$guestNums = json_encode($values['guestnums']);
    
        $booked_query = "INSERT INTO booked_rooms(b_roomId, b_roomType, b_roomLocation, b_checkin, b_checkout) ";
        $booked_query .= "VALUES ('{$value['roomId']}', '{$value['roomAcc']}', '{$value['roomLocation']}',  '{$value['Checkin']}', '{$value['Checkout']}')";

        $booked_result = mysqli_query($connection, $booked_query);

        confirm($booked_result);

          $query = "INSERT INTO reservations(res_firstname, res_lastname, res_phone, res_email, res_checkin, res_checkout, res_country, res_address, res_city, res_zipcode, res_paymentMethod, res_roomIDs, res_price, res_location, res_confirmID, res_specialRequest, res_guestNo, 	res_agent) ";
        $query .= "VALUES('$firstName', '$lastName', '$phoneNum', '$email', '{$value['Checkin']}', '{$value['Checkout']}', '$country', '$address', '$city', '$zipCode', '$PayMethod', '{$value['roomId']}',
         '{$total}', '{$value['roomLocation']}', '{$res_confirmID}', '$specReq', '$guestNums', 'website') ";

        $result = mysqli_query($connection, $query);
        confirm($result);

         $last_record_query = "SELECT res_id FROM reservations ORDER BY res_id DESC LIMIT 1";
          $last_record_result = mysqli_query($connection, $last_record_query);
          confirm($last_record_result);
          $row = mysqli_fetch_assoc($last_record_result);

          $res_Id=$row;

        $booked_query = "INSERT INTO guest_info(info_res_id, info_adults, info_kids, info_teens, info_room_id, info_room_number, info_room_acc, info_room_location, info_board) ";
        $booked_query .= "VALUES ('$res_Id', '{$value['adults']}', '{$value['kid']}',  '{$value['teens']}', '{$value['roomId']}', '{$value['roomNum']}', '{$value['roomAcc']}', '{$value['roomLocation']}', 'full')";
        $booked_result = mysqli_query($connection, $booked_query);
        confirm($booked_result);

        $status_query = "UPDATE `rooms` SET `room_status` = 'booked' WHERE `room_id` IN '{$value['roomId']}'";
        $result_status = mysqli_query($connection, $status_query);
        confirm($result_status);


}


    
    // if (($checkinDate == $singleRoom['checkin'] && $checkoutDate == $singleRoom["checkout"]) || ($checkinDate == '' && $checkoutDate == '')) {
    //     $checkinDate = $singleRoom["checkin"];
    //     $checkoutDate = $singleRoom["checkout"];
    //     $roomID = $singleRoom["room_id"];
    //     $location = $singleRoom["room_location"];
    //     $guestNum = [$singleRoom["adults"], $singleRoom["kid"], $singleRoom["teen"]];
    //     $guestNumS = json_encode($guestNum);
    //     //  Select room details from room id 


    //     $room_query = "SELECT room_acc, room_location FROM rooms WHERE room_id = $roomID";


    //     $room_result = mysqli_query($connection, $room_query);
    //     confirm($room_result);
    //     $room_row = mysqli_fetch_assoc($room_result);


    //     // Insert into booked table

    //     $booked_query = "INSERT INTO booked_rooms(b_roomId, b_roomType, b_roomLocation, b_checkin, b_checkout) ";
    //     $booked_query .= "VALUES ($value, '{$room_row['room_acc']}', '{$room_row['room_location']}',  '{$checkinDate}', '{$checkoutDate}')";

    //     $booked_result = mysqli_query($connection, $booked_query);

    //     confirm($booked_result);


    //     $query = "INSERT INTO reservations(res_firstname, res_lastname, res_phone, res_email, res_checkin, res_checkout, res_country, res_address, res_city, res_zipcode, res_paymentMethod, res_roomIDs, res_price, res_location, res_confirmID, res_specialRequest, res_guestNo, 	res_agent) ";
    //     $query .= "VALUES('$firstName', '$lastName', '$phoneNum', '$email', '$checkinDate', '$checkoutDate', '$country', '$address', '$city', '$zipCode', '$PayMethod', '$roomID', '{$total}', '{$location}', '{$res_confirmID}', '$specReq', '$guestNumS', 'website') ";

    //     $result = mysqli_query($connection, $query);
    //     confirm($result);


    //     $status_query = "UPDATE `rooms` SET `room_status` = 'booked' WHERE `room_id` IN ($roomID)";
    //     $result_status = mysqli_query($connection, $status_query);
    //     confirm($result_status);

    //     $data = true;
    // }
    // // }
    // $data = true;
    // $pusher->trigger('front_notifications', 'front_reservation', $data);
} elseif ($reason == "481") {

    file_put_contents("Lemlem.txt", $reason . PHP_EOL . PHP_EOL, FILE_APPEND);
} else {

    file_put_contents("Lemlem.txt", $reason . PHP_EOL . PHP_EOL, FILE_APPEND);
}

<?php
// ob_start();
// session_start();
require  '../admin/includes/db.php';
require  '../admin/includes/functions.php';
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(dirname(__FILE__)));
$dotenv->load();



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

file_put_contents("Lemlem.txt", $decision . PHP_EOL . PHP_EOL, FILE_APPEND);
file_put_contents("Lemlem.txt", $reason . PHP_EOL . PHP_EOL, FILE_APPEND);

$queryFetch = "SELECT * FROM temp_res WHERE userGID = '$PayerId'";
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
$created_at = $temp_row['created_at'];
$payment_confirmed_at = date('Y-m-d h:i:s');
$PayMethod = $temp_row['paymentMethod'];
$cart = json_decode($cart2);
$room_ids = json_decode($temp_row['room_id']);
$guestInfos = json_decode($temp_row['guestInfo']);
$room_nums = json_decode($temp_row['room_num']);
$room_accs = json_decode($temp_row['room_acc']);
$room_locs = json_decode($temp_row['room_location']);
$CiCos = json_decode($temp_row['CinCoutInfo']);
$board = json_decode($temp_row['temp_board']);






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
  $i = 0;
  $carts = array();
  $oldCI = '';
  $oldCO = '';
  while ($i < $numofRooms) {

    $queryRoom = "SELECT room_price from rooms WHERE room_id = '$room_ids[$i]'";
    $last_record_result = mysqli_query($connection,  $queryRoom);
    confirm($last_record_result);
    $row = mysqli_fetch_assoc($last_record_result);

    $oneReservation = array(
      'Checkin' => $CiCos[$i][0],
      'Checkout' => $CiCos[$i][1],
      'room_id' => $room_ids[$i],
      'adults' => $guestInfos[$i][0],
      'teens' => $guestInfos[$i][1],
      'kids' => $guestInfos[$i][2],
      'room_number' => $room_nums[$i],
      'room_acc' => $room_accs[$i],
      'room_location' => $room_locs[$i],
      'guestnums' => [$guestInfos[$i][0], $guestInfos[$i][1], $guestInfos[$i][2]],
      "room_price" => $row,
      "res_board" => $board[$i]

    );

    array_push($carts, $oneReservation);

    $i++;
  }
  $cartStingfy = json_encode($carts);
  foreach ($carts  as $value) {
    $guestNums = json_encode($value['guestnums']);
    $cartStingfy = json_encode($carts);
    $nowCI = strtotime($value['Checkin']);
    $nowCO = strtotime($value['Checkout']);
    if (($nowCI != $oldCI || $nowCO != $oldCO) || ($oldCI == '' && $oldCO == '')) {
      $query = "INSERT INTO reservations(res_firstname, res_lastname, res_phone, res_email, res_checkin, res_checkout, res_country, res_address, res_city, res_zipcode, res_paymentMethod, res_roomIDs, res_price, res_location, res_confirmID, res_specialRequest, res_guestNo, 	res_agent, res_cart, res_roomType, res_roomNo, created_at, payment_confirmed_at) ";
      $query .= "VALUES('$firstName', '$lastName', '$phonNum', '$email', '{$value['Checkin']}', '{$value['Checkout']}', '$country', '$address', '$city', '$zipCode', '$PayMethod', '{$value['room_id']}',
             '{$total}', '{$value['room_location']}', '{$res_confirmID}', '$specReq', '{$temp_row['guestInfo']}', 'website', '$cartStingfy', '{$temp_row['room_acc']}', '{$temp_row['room_num']}', '$created_at', '$payment_confirmed_at') ";

      $result = mysqli_query($connection, $query);
      confirm($result);
      $oldCI = strtotime($value['Checkin']);
      $oldCO = strtotime($value['Checkout']);
    }


    $last_record_query = "SELECT * FROM reservations WHERE res_confirmID = '$res_confirmID'";
    $last_record_result = mysqli_query($connection, $last_record_query);
    confirm($last_record_result);
    $row = mysqli_fetch_assoc($last_record_result);

    $res_Id = $row['res_id'];

    $booked_query = "INSERT INTO booked_rooms(b_res_id, b_roomId, b_roomType, b_roomLocation, b_checkin, b_checkout) ";
    $booked_query .= "VALUES ('$res_Id', '{$value['room_id']}', '{$value['room_acc']}', '{$value['room_location']}',  '{$value['Checkin']}', '{$value['Checkout']}')";

    $booked_result = mysqli_query($connection, $booked_query);

    confirm($booked_result);

    $booked_query = "INSERT INTO guest_info(info_res_id, info_adults, info_kids, info_teens, info_room_id, info_room_number, info_room_acc, info_room_location, info_board) ";
    $booked_query .= "VALUES ('$res_Id', '{$value['adults']}', '{$value['kids']}',  '{$value['teens']}', '{$value['room_id']}', '{$value['room_number']}', '{$value['room_acc']}', '{$value['room_location']}', '{$value['res_board']}')";
    $booked_result = mysqli_query($connection, $booked_query);
    confirm($booked_result);

    $status_query = "UPDATE `rooms` SET `room_status` = 'booked' WHERE `room_id` = '{$value['room_id']}'";
    $result_status = mysqli_query($connection, $status_query);
    confirm($result_status);
  }

  $delete_temp_query = "DELETE FROM temp_res WHERE userGID = '$PayerId'";
  $delete_result = mysqli_query($connection, $delete_temp_query);
} elseif ($reason == "481") {

  file_put_contents("Lemlem.txt", $reason . PHP_EOL . PHP_EOL, FILE_APPEND);
} else {

  file_put_contents("Lemlem.txt", $reason . PHP_EOL . PHP_EOL, FILE_APPEND);
}

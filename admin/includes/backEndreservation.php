<?php ob_start(); ?>
<?php include  './db.php'; ?>
<?php include  './functions.php'; ?>
<?php session_start(); ?>
<?php

$incoming = json_decode(file_get_contents("php://input"));

$location = $_SESSION['user_location'];
$role = $_SESSION['user_role'];
$data = array();
$filterd_data = array();
if ($incoming->action == 'fetchRes') {
  if ($role == "SA" || ( $location == "Boston" && $role == 'RA')) {
    $query = "SELECT * FROM reservations ORDER BY res_id DESC";
  } else {
    $query = "SELECT * FROM reservations WHERE res_location = '$location' ORDER BY res_id DESC";
  }

  $result = mysqli_query($connection, $query);

  while ($row = mysqli_fetch_assoc($result)) {

    $data[] = $row;
  }

  echo json_encode($data);
}

if ($incoming->action == 'filter') {
  $location = $incoming->location;
  $date = $incoming->date;

  if ($location && $date) {
    $query = "SELECT * FROM reservations WHERE res_location = '$location' AND res_checkin = '$date'";
  } else if (!$location && $date) {
    $query = "SELECT * FROM reservations WHERE res_checkin = '$date'";
  } else if ($location && !$date) {
    $query = "SELECT * FROM reservations WHERE res_location = '$location'";
  }

  $result = mysqli_query($connection, $query);
  confirm($result);
  while ($row = mysqli_fetch_assoc($result)) {
    $filterd_data[] = $row;
  }

  echo json_encode($filterd_data);
}

if ($incoming->action == 'addSingleRes') {
  $firstName = $incoming->firstName;
  $lastName = $incoming->lastName;
  $email = $incoming->email;
  $phone = $incoming->phone;
  $dob = $incoming->dob;
  $remark = $incoming->remark;
  $tempRow = $incoming->row;
  $res_agent = $_SESSION['username'];
  $roomId = json_decode($tempRow->res_roomIDs);

  $room_query = "SELECT room_price, room_location FROM rooms WHERE room_id = $roomId[0]";
  $room_result = mysqli_query($connection, $room_query);

  $row = mysqli_fetch_row($room_result);

  $query = "INSERT INTO reservations(res_firstname, res_lastname, res_phone, res_email, res_guestNo, res_checkin, res_checkout, res_country, res_address, res_city, res_zipcode, res_paymentMethod, res_roomIDs, res_price, res_location, res_confirmID, res_groupName, res_specialRequest, res_agent, res_paymentStatus, res_remark, res_promo, res_extraBed, res_dob) ";
  $query .= "VALUES ('$firstName', '$lastName', '$phone', '$email', '$tempRow->res_guestNo', '$tempRow->res_checkin', '$tempRow->res_checkout', '$tempRow->res_country', '$tempRow->res_address', '$tempRow->res_city', '$tempRow->res_zipcode', '$tempRow->res_paymentMethod', '$roomId[0]', $row[0],'$row[1]', '$tempRow->res_confirmID', '$tempRow->res_groupName', '$tempRow->res_specialRequest', '$res_agent', '$tempRow->res_paymentStatus', '$remark', '$tempRow->res_promo', '$tempRow->res_extraBed', '$dob')";

  $result = mysqli_query($connection, $query);
  confirm($result);

  // update room quantity
  array_shift($roomId);
  $roomIds = json_encode($roomId);

  $update_res = "UPDATE `reservations` SET `res_roomIDs` = '$roomIds' WHERE `reservations`.`res_id` = $tempRow->res_id";

  $update_result = mysqli_query($connection, $update_res);

  confirm($update_result);

  echo json_encode($roomId);
}

if ($incoming->action == "delete") {
  $res_id = $incoming->row->res_id;
  $rooms = array();
  $select_rooms_query = "SELECT res_roomIDs FROM reservations WHERE res_id = $res_id";
  $select_rooms_result = mysqli_query($connection, $select_rooms_query);

  confirm($select_rooms_result);

  while ($row = mysqli_fetch_assoc($select_rooms_result)) {
    foreach ($row as  $val) {

      $rooms = json_decode($val);
    }
  }
  // echo json_encode();

  if(gettype($rooms) == 'integer'){

    // CHANGE ROOM STATUS TO NOT BOOKED 

    $change_status_query = "UPDATE rooms SET room_status = 'Not_booked' WHERE room_id = '$rooms'";
    $change_status_result = mysqli_query($connection, $change_status_query);
    confirm($change_status_result);

      // REMOVE ROOMS FROM BOOKED ROOMS TABLE 
    
    $delete_booked_rooms = "DELETE FROM booked_rooms WHERE b_roomId = $val";
    $delete_booked_rooms_result = mysqli_query($connection, $delete_booked_rooms);

     confirm($delete_booked_rooms_result);
  }else if(gettype($rooms) == 'array'){
    
    foreach ($rooms as  $val) {

      // CHANGE ROOM STATUS TO NOT BOOKED 

      $change_status_query = "UPDATE rooms SET room_status = 'Not_booked' WHERE room_id = '$val'";
      $change_status_result = mysqli_query($connection, $change_status_query);
      confirm($change_status_result);

      // REMOVE ROOMS FROM BOOKED ROOMS TABLE 

      $delete_booked_rooms = "DELETE FROM booked_rooms WHERE b_roomId = $val";
      $delete_booked_rooms_result = mysqli_query($connection, $delete_booked_rooms);
 
       confirm($delete_booked_rooms_result);
      echo json_encode(confirm($delete_booked_rooms_result));
    }
  }

  $delete_query = "DELETE FROM reservations WHERE res_id = $res_id";
  $delete_result = mysqli_query($connection, $delete_query);
  confirm($delete_result);

 
}

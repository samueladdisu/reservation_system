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
  if ($role == "SA" || ($location == "Boston" && $role == 'RA')) {
    // $query = "SELECT * FROM reservations ORDER BY res_id DESC";
    $query = "SELECT * FROM reservations WHERE res_checkin = CURDATE() ORDER BY res_id DESC";
  } else {
    $query = "SELECT * FROM reservations WHERE res_location = '$location' AND res_checkin = CURDATE() ORDER BY res_id DESC";
  }

  $result = mysqli_query($connection, $query);

  while ($row = mysqli_fetch_assoc($result)) {

    $data[] = $row;
  }

  echo json_encode($data);
}


if ($incoming->action == 'fetchResDate') {

  $select_start_date = $incoming->startDate;
  $select_end_date = $incoming->endDate;

  if ($role == "SA" || ($location == "Boston" && $role == 'RA')) {
    $query = "SELECT * FROM reservations WHERE res_checkin >= STR_TO_DATE('$select_start_date','%Y-%m-%d') 
    AND res_checkout <= STR_TO_DATE('$select_end_date','%Y-%m-%d') ORDER BY res_id DESC";
  } else {
    $query = "SELECT * FROM reservations WHERE res_location = '$location' AND res_checkin >= STR_TO_DATE('$select_start_date','%Y-%m-%d') 
    AND res_checkout <= STR_TO_DATE('$select_end_date','%Y-%m-%d') ORDER BY res_id DESC";
  }

  $result = mysqli_query($connection, $query);

  while ($row = mysqli_fetch_assoc($result)) {

    $data[] = $row;
  }

  echo json_encode($data);
}

if ($incoming->action == 'fetchResDaily') {
  $date = date('Y-m-d');
  if ($role == "SA" || ($location == "Boston" && $role == 'RA')) {
    $query = "SELECT * FROM reservations WHERE res_checkin = '$date' ORDER BY res_id DESC";
  } else {
    $query = "SELECT * FROM reservations WHERE res_location = '$location' AND res_checkin = '$date' ORDER BY res_id DESC";
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

  $query = "INSERT INTO reservations(res_firstname, res_lastname, res_phone, res_email, res_adults, res_teens, res_kids, res_checkin, res_checkout, res_country, res_address, res_city, res_zipcode, res_paymentMethod, res_roomIDs, res_price, res_location, res_confirmID, res_groupName, res_specialRequest, res_agent, res_paymentStatus, res_remark, res_promo, res_extraBed, res_dob) ";
  $query .= "VALUES ('$firstName', '$lastName', '$phone', '$email', '$tempRow->res_adults', '$tempRow->res_teens', '$tempRow->res_kids','$tempRow->res_checkin', '$tempRow->res_checkout', '$tempRow->res_country', '$tempRow->res_address', '$tempRow->res_city', '$tempRow->res_zipcode', '$tempRow->res_paymentMethod', '$roomId[0]', $row[0],'$row[1]', '$tempRow->res_confirmID', '$tempRow->res_groupName', '$tempRow->res_specialRequest', '$res_agent', '$tempRow->res_paymentStatus', '$remark', '$tempRow->res_promo', '$tempRow->res_extraBed', '$dob')";

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
if ($incoming->action == "guestInfo") {
  $res_id = $incoming->id;

  $guest_query = "SELECT * FROM guest_info WHERE info_res_id = $res_id";
  $guest_result = mysqli_query($connection, $guest_query);

  while ($row = mysqli_fetch_assoc($guest_result)) {
    $data[] = $row;
  }
  echo json_encode($data);
}
if ($incoming->action == "delete") {
  $res_id = $incoming->row->res_id;
  $group_name = $incoming->row->res_groupName;
  $group_id = $incoming->row->res_groupID;
  $rooms = array();

  if ($group_name == "") {
    $select_rooms_query = "SELECT res_roomIDs FROM reservations WHERE res_id = $res_id";
    $select_rooms_result = mysqli_query($connection, $select_rooms_query);

    confirm($select_rooms_result);

    while ($row = mysqli_fetch_assoc($select_rooms_result)) {
      foreach ($row as  $val) {

        $rooms = json_decode($val);
      }
    }

    if (gettype($rooms) == 'integer') {

      // CHANGE ROOM STATUS TO NOT BOOKED 

      $change_status_query = "UPDATE rooms SET room_status = 'Not_booked' WHERE room_id = '$rooms'";
      $change_status_result = mysqli_query($connection, $change_status_query);
      confirm($change_status_result);
    } else if (gettype($rooms) == 'array') {

      foreach ($rooms as  $val) {

        // CHANGE ROOM STATUS TO NOT BOOKED 

        $change_status_query = "UPDATE rooms SET room_status = 'Not_booked' WHERE room_id = '$val'";
        $change_status_result = mysqli_query($connection, $change_status_query);
        confirm($change_status_result);
      }
    }

    $delete_query = "DELETE FROM reservations WHERE res_id = $res_id";
    $delete_result = mysqli_query($connection, $delete_query);
    confirm($delete_result);

    $guest_info_query = "DELETE FROM guest_info WHERE info_res_id = $res_id";
    $guest_info_result = mysqli_query($connection, $guest_info_query);
    confirm($guest_info_result);

    $delete_booked_rooms = "DELETE FROM booked_rooms WHERE b_res_id = $res_id";
    $delete_booked_rooms_result = mysqli_query($connection, $delete_booked_rooms);

    confirm($delete_booked_rooms_result);

    echo json_encode(confirm($delete_booked_rooms_result));
  } else {
    echo json_encode($incoming->row);

    $g_res_id    = $incoming->row->res_groupID;
    $g_room_Id   = $incoming->row->res_roomIDs;
    $g_room_acc  = $incoming->row->res_roomType;
    $g_room_num  = $incoming->row->res_roomNo;
    $g_room_loc  = $incoming->row->res_location;

    // Update the group reservation availability

    $group_query = "UPDATE group_reservation SET group_remainingRooms = group_remainingRooms + 1 WHERE group_id = $group_id";
    $group_result = mysqli_query($connection, $group_query);
    confirm($group_result);

    // insert The room back to the group room table

    $insert_group_query = "INSERT INTO group_rooms(g_res_id, g_room_id, g_room_acc, g_room_number, g_room_location) ";

    $insert_group_query .= "VALUES ($g_res_id, $g_room_Id, '$g_room_acc', $g_room_num, '$g_room_loc')";

    $insert_result = mysqli_query($connection, $insert_group_query);
    confirm($insert_result);
    // delete the reservation 
    $delete_query = "DELETE FROM reservations WHERE res_id = $res_id";
    $delete_result = mysqli_query($connection, $delete_query);
    confirm($delete_result);

    $guest_info_query = "DELETE FROM guest_info WHERE info_res_id = $res_id";
    $guest_info_result = mysqli_query($connection, $guest_info_query);
    confirm($guest_info_result);
  }
}

if ($incoming->action == "roomStatus") {
  $data = array();
  $location = $incoming->location;
  $date = $incoming->date;

  if ($location == "all") {

    $query = "SELECT r.room_id, r.room_acc, r.room_number, res.res_firstname, gr.group_name, g.info_adults, g.info_kids, g.info_teens,b.b_checkin, b.b_checkout, r.room_location, res.res_remark
    FROM rooms AS r
    LEFT JOIN booked_rooms AS b
    ON r.room_id = b.b_roomId AND '$date' BETWEEN b_checkin AND b_checkout
    LEFT JOIN reservations AS res
    ON res.res_id = b.b_res_id
    LEFT JOIN group_reservation AS gr
    ON gr.group_id = b.b_group_res_id
    LEFT JOIN guest_info AS g
    ON g.info_res_id = b.b_res_id AND g.info_room_id = b.b_roomId";
  } else {

    $query = "SELECT r.room_id, r.room_acc, r.room_number, res.res_firstname, gr.group_name, g.info_adults, g.info_kids, g.info_teens,b.b_checkin, b.b_checkout, r.room_location, res.res_remark
    FROM rooms AS r
    LEFT JOIN booked_rooms AS b
    ON r.room_id = b.b_roomId AND '$date' BETWEEN b_checkin AND b_checkout
    LEFT JOIN reservations AS res
    ON res.res_id = b.b_res_id
    LEFT JOIN group_reservation AS gr
    ON gr.group_id = b.b_group_res_id
    LEFT JOIN guest_info AS g
    ON g.info_res_id = b.b_res_id AND g.info_room_id = b.b_roomId
    WHERE r.room_location = '$location'";
  }

  $result = mysqli_query($connection, $query);

  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
  }

  echo json_encode($data);
}

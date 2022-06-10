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

if ($received_data->action == "getRooms") {

  $id = $received_data->id;

  $query = "SELECT * FROM group_rooms WHERE g_res_id = $id";
  $result = mysqli_query($connection, $query);

  confirm($result);
  while ($row = mysqli_fetch_assoc($result)) {
    $rooms[] = $row;
  }

  echo json_encode($rooms);
}

if ($received_data->action == "addSingleRes") {

  $room       = $received_data->room;
  $checkin    = $received_data->checkin;
  $checkout   = $received_data->checkout;
  $formData   = $received_data->formData;
  $group_name = $received_data->group_name;
  $group_id = $received_data->group_id;

  $res_agent = $_SESSION['username'];

  $last_record_query = "SELECT res_id FROM reservations ORDER BY res_id DESC LIMIT 1";

  $last_record_result = mysqli_query($connection, $last_record_query);
  confirm($last_record_result);

  $row = mysqli_fetch_assoc($last_record_result);

  if (empty($row)) {
    echo json_encode("empty");

    /**
     * Reset The Table if the table is empty
     */
    $reset_query = "TRUNCATE TABLE reservations";
    $reset_result = mysqli_query($connection, $reset_query);

    confirm($reset_result);
  } else {
    echo json_encode("not empty");

    /**
     * if the table is not empty reset the auto increment so that 
     * It'll start from the last id
     */
    foreach ($row as $value) {
      
      $reset_auto_increment = "ALTER TABLE reservations AUTO_INCREMENT = $value";
      $result = mysqli_query($connection, $reset_auto_increment);
      confirm($result);

      $last_record_query = "SELECT res_id FROM reservations ORDER BY res_id DESC LIMIT 1";

      $last_record_result = mysqli_query($connection, $last_record_query);
      confirm($last_record_result);

      $row = mysqli_fetch_assoc($last_record_result);

      foreach ($row as $val) {
        $id = $val;
      }
    }
  }



  $last_id = $id + 1;


  $guest_info_query = "INSERT INTO guest_info(info_res_id, info_adults, info_kids, info_teens, info_room_id, info_room_number, info_room_acc, info_room_location) ";

  $guest_info_query .= "VALUES ($last_id, 1, 0, 0, $room->g_room_id, $room->g_room_number, '$room->g_room_acc', '$room->g_room_location')";

  $guest_info_result = mysqli_query($connection, $guest_info_query);
  confirm($guest_info_result);


  $cart[] = array(
    "adults" => 1,
    "kids"   => 0,
    "teens"  => 0,
    "room_id" => $room->g_room_id,
    "room_number" => $room->g_room_number,
    "room_acc"   => $room->g_room_acc,
    "room_location"   => $room->g_room_location,
  );


  $res_cart = json_encode($cart);

  $query = "INSERT INTO reservations(res_firstname, res_lastname, res_phone, res_email, res_guestNo, res_cart, res_checkin, res_checkout, res_roomIDs, res_roomNo, res_roomType, res_location, res_groupName, res_groupID, res_agent, res_remark, res_dob) ";

  $query .= "VALUES('{$formData->firstName}', '{$formData->lastName}', '{$formData->phone}', '{$formData->email}', '1', '{$res_cart}',  '$checkin', '$checkout', '{$room->g_room_id}', '{$room->g_room_number}', '{$room->g_room_acc}', '{$room->g_room_location}', '{$group_name}', $group_id, '$res_agent', '{$formData->remark}', '{$formData->dob}')";

  $result = mysqli_query($connection, $query);

  confirm($result);

  // Delete Selected Room from group rooms table(temp store)

  $delete_query = "DELETE FROM group_rooms WHERE g_id = $room->g_id";

  $delete_result = mysqli_query($connection, $delete_query);
  confirm($delete_result);

  // Update Ava. rooms in group_reservation table

  $update_query = "UPDATE group_reservation SET group_remainingRooms = group_remainingRooms - 1 WHERE group_id = $room->g_res_id";

  $update_result = mysqli_query($connection, $update_query);
  confirm($update_result);
}

if ($received_data->action == 'delete') {

  $group_id = $received_data->row->group_id;

  $group_room_query = "SELECT * FROM group_rooms WHERE g_res_id = $group_id";
  $result = mysqli_query($connection, $group_room_query);

  confirm($result);

  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = intval($row['g_room_id']);
  }

  foreach ($data as $val) {
    // delete All rooms registered under group id

    $delete_booked_query = "DELETE FROM booked_rooms WHERE b_roomId = $val";
    $delete_booked_result = mysqli_query($connection, $delete_booked_query);

    confirm($delete_booked_result);

    $update_room_query = "UPDATE rooms SET room_status = 'Not_booked' WHERE room_id = $val";
    $update_room_result = mysqli_query($connection, $update_room_query);

    confirm($update_room_result);
  }


  $delete_temp_query = "DELETE FROM group_rooms WHERE g_res_id = $group_id";
  $delete_temp_result = mysqli_query($connection, $delete_temp_query);

  confirm($delete_temp_result);

  $delete_group_query = "DELETE FROM group_reservation WHERE group_id = $group_id";
  $delete_group_result = mysqli_query($connection, $delete_group_query);

  confirm($delete_group_result);
}
if ($received_data->action == 'fetchRes') {
  if ($role == "SA" || ($location == "Boston" && $role == 'RA')) {
    $query = "SELECT * FROM group_reservation ORDER BY group_id DESC";
  } else {
    $query = "SELECT * FROM group_reservation WHERE group_location = '$location' ORDER BY group_id DESC";
  }

  $result = mysqli_query($connection, $query);

  while ($row = mysqli_fetch_assoc($result)) {

    $data[] = $row;
  }

  echo json_encode($data);
}

if ($received_data->action == 'filter') {

  $room_quantity_array = array();
  $location = $received_data->location;
  $roomType = $received_data->roomType;
  $checkin = $received_data->checkin;
  $checkout = $received_data->checkout;
  $roomQuantity = $received_data->roomQuantity;

  if (($checkin && $checkout) && ($location && $roomType)) {

    $query = "SELECT DISTINCT b_roomId 
    FROM booked_rooms 
    WHERE b_checkout<= '$checkin' 
    AND b_roomLocation = '$location'
    AND b_roomType = '$roomType'
    UNION
    SELECT DISTINCT b_roomId
    FROM booked_rooms
    WHERE b_checkin >= '$checkout'
    AND b_roomLocation = '$location'
    AND b_roomType = '$roomType'";
  } else if (($checkin && $checkout) && !$location && !$roomType) {

    $query = "SELECT DISTINCT b_roomId
    FROM booked_rooms 
    WHERE b_checkout<= '$checkin' 
    UNION
    SELECT DISTINCT b_roomId
    FROM booked_rooms
    WHERE b_checkin >= '$checkout'";
  } else if (($checkin && $checkout) && !$location && $roomType) {
    $query = "SELECT DISTINCT b_roomId 
    FROM booked_rooms 
    WHERE b_checkout<= '$checkin' 
    AND b_roomType = '$roomType'
    UNION
    SELECT DISTINCT b_roomId
    FROM booked_rooms
    WHERE b_checkin >= '$checkout'
    AND b_roomType = '$roomType'";
  } else if (($checkin && $checkout) && $location && !$roomType) {
    $query = "SELECT DISTINCT b_roomId
    FROM booked_rooms 
    WHERE b_checkout<= '$checkin' 
    AND b_roomLocation = '$location'
    UNION
    SELECT DISTINCT b_roomId
    FROM booked_rooms
    WHERE b_checkin >= '$checkout'
    AND b_roomLocation = '$location'";
  }

  $result = mysqli_query($connection, $query);
  confirm($result);

  $exists = mysqli_num_rows($result);

  if ($exists) {
    while ($row = mysqli_fetch_assoc($result)) {

      $select_room_query = "SELECT * 
      FROM rooms 
      WHERE room_id = {$row['b_roomId']}";

      $select_room_result = mysqli_query($connection, $select_room_query);
      confirm($select_room_result);
      while ($row2 = mysqli_fetch_assoc($select_room_result)) {

        $filterd_data[] = $row2;
      }
    }

    if ($location && $roomType) {
      $select_not_booked_query = "SELECT * 
    FROM rooms
    WHERE room_status = 'Not_booked'
    AND room_location = '$location'
    AND room_acc = '$roomType'";
    } else if ($location && !$roomType) {
      $select_not_booked_query = "SELECT * 
      FROM rooms
      WHERE room_status = 'Not_booked'
      AND room_location = '$location'";
    } else if (!$location && $roomType) {
      $select_not_booked_query = "SELECT * 
    FROM rooms
    WHERE room_status = 'Not_booked'
    AND room_acc = '$roomType'";
    }

    $select_not_booked_result = mysqli_query($connection, $select_not_booked_query);
    confirm($select_not_booked_result);

    while ($row3 = mysqli_fetch_assoc($select_not_booked_result)) {
      $Not_booked_array[] = $row3;
    }

    $merged_array = array_merge($filterd_data, $Not_booked_array);
    $merged_array = array_slice($merged_array, 0, $roomQuantity);
    echo json_encode($merged_array);
  } else {
    if ($location && $roomType) {
      $ava_query = "SELECT * 
      FROM rooms 
      WHERE room_status = 'Not_booked' 
      AND room_location = '$location'
      AND room_acc = '$roomType' LIMIT $roomQuantity";
    } else if ($location && !$roomType) {
      $ava_query = "SELECT * 
      FROM rooms 
      WHERE room_status = 'Not_booked' 
      AND room_location = '$location' LIMIT $roomQuantity";
    } else if (!$location && $roomType) {
      $ava_query = "SELECT *
      FROM rooms
      WHERE room_status = 'Not_booked'
      AND room_acc = '$roomType' LIMIT $roomQuantity";
    }
    $ava_result = mysqli_query($connection, $ava_query);
    confirm($ava_result);
    while ($row_ava = mysqli_fetch_assoc($ava_result)) {

      $filterd_data[] = $row_ava;
    }
    echo json_encode($filterd_data);
  }
}


if ($received_data->action === 'add') {

  $checkin = $received_data->checkin;
  $checkout = $received_data->checkout;
  $rooms = $received_data->rooms;
  $form = $received_data->form;
  $reason = $received_data->form->group_reason;


  $price = 0.00;
  // calculate number of days
  $days       = array();
  $start      = new DateTime($checkin);
  $end        = new DateTime($checkout);

  for ($date = $start; $date < $end; $date->modify('+1 day')) {
    $days[] = $date->format('l');
  }

  $last_record_query = "SELECT group_id FROM group_reservation ORDER BY group_id DESC LIMIT 1";

  $last_record_result = mysqli_query($connection, $last_record_query);
  confirm($last_record_result);

  $row = mysqli_fetch_assoc($last_record_result);

  if (empty($row)) {
    $reset_table = "TRUNCATE TABLE group_reservation";
    $reset_result = mysqli_query($connection, $reset_table);

    confirm($reset_result);
  } else {
    foreach ($row as $value) {
      $id = $value;
    }
  }


  $last_id = $id + 1;

  foreach ($rooms as $value) {
    $int_roomId = intval($value->room_id);
    $room_num   = intval($value->room_number);
    $group_location     = $value->room_location;

    // Insert into booked table

    $booked_query = "INSERT INTO booked_rooms(b_group_res_id, b_roomId, b_roomType, b_roomLocation, b_checkin, b_checkout) ";
    $booked_query .= "VALUES ($last_id, $int_roomId , '{$value->room_acc}', '{$value->room_location}',  '{$checkin}', '{$checkout}')";

    $booked_result = mysqli_query($connection, $booked_query);

    confirm($booked_result);

    // Update room to booked

    $update_query = "UPDATE rooms SET room_status = 'booked' WHERE room_id = $int_roomId";

    $update_result = mysqli_query($connection, $update_query);
    confirm($update_result);

    $group_query = "INSERT INTO group_rooms(g_res_id, g_room_id, g_room_acc, g_room_number, g_room_location) ";

    $group_query .= "VALUES ($last_id, $int_roomId, '{$value->room_acc}', $room_num, '{$value->room_location}')";

    $group_result = mysqli_query($connection, $group_query);

    confirm($group_result);
  }

  if ($reason == 'con') {

    if (count($rooms) < 50) {

      foreach ($rooms as $val) {
        foreach ($days as $day) {
          switch ($day) {
            case 'Friday':
              $price += 135;
              break;
            case 'Saturday':
              $price += 135;
              break;
            default:
              $price += 125;
              break;
          }
        }
      }
    } else if (count($rooms) >= 51 && count($rooms) < 80) {
      foreach ($rooms as $val) {
        foreach ($days as $day) {
          switch ($day) {
            case 'Friday':
              $price += 125;
              break;
            case 'Saturday':
              $price += 125;
              break;
            default:
              $price += 110;
              break;
          }
        }
      }
    } else if (count($rooms) > 80) {
      foreach ($rooms as $val) {
        foreach ($days as $day) {
          switch ($day) {
            case 'Friday':
              $price += 110;
              break;
            case 'Saturday':
              $price += 110;
              break;
            default:
              $price += 99;
              break;
          }
        }
      }
    }
  } else if ($reason == 'wed') {
    $price = count($rooms) * count($days) * 150;
  }

  echo json_encode($price);

  $res_agent = $_SESSION['username'];
  $group_rooms = json_encode($rooms);
  $quantity = count($rooms);

  $query = "INSERT INTO group_reservation(group_name, group_roomQuantity, group_remainingRooms, group_checkin, group_checkout, group_paymentStatus, group_reason, group_price, group_remark, group_agent, group_location) ";

  $query .= "VALUES ('{$form->group_name}', $quantity, $quantity, '{$checkin}', '{$checkout}', '{$form->group_paymentStatus}', '{$form->group_reason}', $price, '{$form->group_remark}', '{$res_agent}', '{$group_location}')";

  $result = mysqli_query($connection, $query);
  confirm($result);
}

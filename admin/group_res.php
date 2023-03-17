<?php session_start(); ?>
<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php


function  weekendsPricing($row, $room_pattern, $GuestNum, $TeaB, $BBQ, $Dineer,  $LunchNum)
{

  $rakRate =  $row['group_weeends'];
  $breakfast = $row['group_breakfast'];
  $extraBed =  $row['group_extrabed'];
  $teaBreak =  $row['group_tea'];
  $LunchPrice = $row['group_lunch'];
  $BBQ_Price = $row['group_BBQ'];
  $Dinner_price = $row['group_dinner'];

  $price = 0.00;


  foreach ($room_pattern as $num) {
    if ($num == 2) {
      $price += ($rakRate + $breakfast);
    } else if ($num == 1) {
      $price += $rakRate;
    } else if ($num == 3) {
      $price += ($rakRate + (2 * $breakfast) + $extraBed);
    }
  }

  $Lunch = $LunchNum * $LunchPrice;
  $BBQTotal = $BBQ * $BBQ_Price;
  $DinnerTotal = $Dineer  * $Dinner_price;
  $Tea = $TeaB *  $teaBreak;

  $price += ($Lunch + $Tea +  $DinnerTotal + $BBQTotal);

  return $price;
}

function weekdaysPricing($row, $room_pattern, $GuestNum, $TeaB, $BBQ, $Dineer,  $LunchNum)
{
  $rakRate = $row['group_weekday'];
  $breakfast = $row['group_breakfast'];
  $extraBed =  $row['group_extrabed'];
  $teaBreak =  $row['group_tea'];
  $LunchPrice = $row['group_lunch'];
  $BBQ_Price = $row['group_BBQ'];
  $Dinner_price = $row['group_dinner'];

  $price = 0.00;

  foreach ($room_pattern as $num) {
    if ($num == 2) {
      $price += ($rakRate + $breakfast);
    } else if ($num == 1) {
      $price += $rakRate;
    } else if ($num == 3) {
      $price += ($rakRate + (2 * $breakfast) + $extraBed);
    }
  }

  $Lunch = $LunchNum * $LunchPrice;
  $BBQTotal = $BBQ * $BBQ_Price;
  $DinnerPrice = $Dineer  * $Dinner_price;
  $Tea = $TeaB *  $teaBreak;

  $price += ($Lunch + $Tea +  $DinnerPrice + $BBQTotal);

  return $price;
}

function weekdaysPricingCustom($row, $room_pattern, $GuestNum, $TeaB, $BBQ, $Dineer,  $LunchNum)
{

  $rakRate = $row['WeekdaysPricing'];
  $breakfast = $row['breakfast_price'];
  $extraBed = $row['Extrabed_price'];
  $teaBreak = $row['TeaBreak_price'];
  $LunchPrice = $row['Lunch_price'];
  $BBQ_Price = $row['BBQ_price'];
  $Dinner_price = $row['Dinner_price'];
  $price = 0.00;

  foreach ($room_pattern as $num) {
    if ($num == 2) {
      $price += ($rakRate + $breakfast);
    } else if ($num == 1) {
      $price += $rakRate;
    } else if ($num == 3) {
      $price += ($rakRate + (2 * $breakfast) + $extraBed);
    }
  }

  $Lunch = $LunchNum * $LunchPrice;
  $BBQTotal = $BBQ * $BBQ_Price;
  $DinnerPrice = $Dineer  * $Dinner_price;
  $Tea = $TeaB *  $teaBreak;

  $price += ($Lunch + $Tea +  $DinnerPrice + $BBQTotal);

  return $price;
}


function weekendsPricingCustom($row, $room_pattern, $GuestNum, $TeaB, $BBQ, $Dineer,  $LunchNum)
{

  $rakRate = $row['WeekendPricing'];
  $breakfast = $row['breakfast_price'];
  $extraBed = $row['Extrabed_price'];
  $teaBreak = $row['TeaBreak_price'];
  $LunchPrice = $row['Lunch_price'];
  $BBQ_Price = $row['BBQ_price'];
  $Dinner_price = $row['Dinner_price'];

  $price = 0.00;

  foreach ($room_pattern as $num) {
    if ($num == 2) {
      $price += ($rakRate + $breakfast);
    } else if ($num == 1) {
      $price += $rakRate;
    } else if ($num == 3) {
      $price += ($rakRate + (2 * $breakfast) + $extraBed);
    }
  }

  $Lunch = $LunchNum * $LunchPrice;
  $BBQTotal = $BBQ * $BBQ_Price;
  $DinnerPrice = $Dineer  * $Dinner_price;
  $Tea = $TeaB *  $teaBreak;

  $price += ($Lunch + $Tea +  $DinnerPrice + $BBQTotal);

  return $price;
}



$received_data = json_decode(file_get_contents("php://input"));
date_default_timezone_set('Africa/Addis_Ababa');


$group_app_id = $_ENV['BACK_GROUP_APP_ID'];
$group_key = $_ENV['BACK_GROUP_KEY'];
$group_secret = $_ENV['BACK_GROUP_SECRET'];
$group_cluster = "mt1";

$pusher = new Pusher\Pusher($group_key, $group_secret, $group_app_id, ['cluster' => $group_cluster]);

$location = $_SESSION['user_location'];
$role = $_SESSION['user_role'];
$filterd_data = array();
$Not_booked_array = array();
$allData = array();
$data = array();
$rooms = array();

if ($received_data->action == "fetchResDaily") {
  $date = date('Y-m-d');
  if ($role == "SA" || ($location == "Boston" && $role == 'RA')) {
    $query = "SELECT * FROM group_reservation WHERE group_checkin = '$date' ORDER BY group_id DESC";
  } else {
    $query = "SELECT * FROM group_reservation WHERE group_checkin = '$date' AND group_location = '$location' ORDER BY group_id DESC";
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

if ($received_data->action == "guestInfo") {
  $id = $received_data->id;
  $query = "SELECT * FROM group_reservation WHERE group_id = $id";
  $result = mysqli_query($connection, $query);
  confirm($result);

  $row = mysqli_fetch_row($result);
  echo json_encode($row);
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

  $data = true;

  $pusher->trigger('group_notifications', 'group_reservation', $data);
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

if ($received_data->action == 'fetchResDate') {

  $select_start_date = $received_data->startDate;
  $select_end_date = $received_data->endDate;


  if ($role == "SA" || ($location == "Boston" && $role == 'RA')) {
    $query = "SELECT * FROM group_reservation WHERE group_checkin >= STR_TO_DATE('$select_start_date','%Y-%m-%d') 
    AND group_checkout <= STR_TO_DATE('$select_end_date','%Y-%m-%d') ORDER BY group_id DESC";
  } else {
    $query = "SELECT * FROM group_reservation WHERE group_location = '$location' AND group_checkin >= STR_TO_DATE('$select_start_date','%Y-%m-%d') 
    AND group_checkout <= STR_TO_DATE('$select_end_date','%Y-%m-%d') ORDER BY group_id DESC";
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
    // $query = "SELECT * 
    // FROM rooms 
    // WHERE room_id 
    // NOT IN 
    //   ( SELECT b_roomId
    //     FROM booked_rooms 
    //     WHERE '$checkin'
    //     BETWEEN b_checkin AND b_checkout 
    //     UNION
    //     SELECT b_roomId
    //     FROM booked_rooms
    //     WHERE '$checkout'
    //     BETWEEN b_checkin AND b_checkout
    //     )
    // AND room_acc = '$roomType'
    // AND room_location = '$location'
    // AND room_status <> 'Hold'";

    $query = "SELECT rooms.*
    FROM rooms
    LEFT JOIN booked_rooms
    ON rooms.room_id = booked_rooms.b_roomId
    AND (('$checkin' >= b_checkin AND '$checkin' < b_checkout)
        OR ('$checkout' > b_checkin AND '$checkout' <= b_checkout)
        OR ('$checkin' <= b_checkin AND '$checkout' >= b_checkout))
    WHERE booked_rooms.b_roomId IS NULL
    AND room_location = '$location' AND room_acc = '$roomType' AND room_status NOT IN ('Hold', 'bishoftu_hold')";
  } else if (($checkin && $checkout) && !$location && !$roomType) {
    //   $query = "SELECT * 
    //   FROM rooms 
    //   WHERE room_id 
    //   NOT IN 
    //     ( SELECT b_roomId
    //       FROM booked_rooms 
    //       WHERE '$checkin'
    //       BETWEEN b_checkin AND b_checkout 
    //       UNION
    //       SELECT b_roomId
    //       FROM booked_rooms
    //       WHERE '$checkout'
    //       BETWEEN b_checkin AND b_checkout
    //       )
    //   AND room_status <> 'Hold'
    //  ";

    $query = "SELECT rooms.*
    FROM rooms
    LEFT JOIN booked_rooms
    ON rooms.room_id = booked_rooms.b_roomId
    AND (('$checkin' >= b_checkin AND '$checkin' < b_checkout)
        OR ('$checkout' > b_checkin AND '$checkout' <= b_checkout)
        OR ('$checkin' <= b_checkin AND '$checkout' >= b_checkout))
    WHERE booked_rooms.b_roomId IS NULL
    AND room_status NOT IN ('Hold', 'bishoftu_hold')";
  } else if (($checkin && $checkout) && !$location && $roomType) {
    // $query = "SELECT * 
    // FROM rooms 
    // WHERE room_id 
    // NOT IN 
    //   ( SELECT b_roomId
    //     FROM booked_rooms 
    //     WHERE '$checkin'
    //     BETWEEN b_checkin AND b_checkout 
    //     UNION
    //     SELECT b_roomId
    //     FROM booked_rooms
    //     WHERE '$checkout'
    //     BETWEEN b_checkin AND b_checkout
    //     )
    // AND room_acc = '$roomType'
    // AND room_status <> 'Hold'";

    $query = "SELECT rooms.*
    FROM rooms
    LEFT JOIN booked_rooms
    ON rooms.room_id = booked_rooms.b_roomId
    AND (('$checkin' >= b_checkin AND '$checkin' < b_checkout)
        OR ('$checkout' > b_checkin AND '$checkout' <= b_checkout)
        OR ('$checkin' <= b_checkin AND '$checkout' >= b_checkout))
    WHERE booked_rooms.b_roomId IS NULL
    AND room_acc = '$roomType' AND room_status NOT IN ('Hold', 'bishoftu_hold')";
  } else if (($checkin && $checkout) && $location && !$roomType) {
    // $query = "SELECT * 
    // FROM rooms 
    // WHERE room_id 
    // NOT IN 
    //   ( SELECT b_roomId
    //     FROM booked_rooms 
    //     WHERE '$checkin'
    //     BETWEEN b_checkin AND b_checkout 
    //     UNION
    //     SELECT b_roomId
    //     FROM booked_rooms
    //     WHERE '$checkout'
    //     BETWEEN b_checkin AND b_checkout
    //     )
    // AND room_location = '$location'
    // AND room_status <> 'Hold'";

    $query = "SELECT rooms.*
    FROM rooms
    LEFT JOIN booked_rooms
    ON rooms.room_id = booked_rooms.b_roomId
    AND (('$checkin' >= b_checkin AND '$checkin' < b_checkout)
        OR ('$checkout' > b_checkin AND '$checkout' <= b_checkout)
        OR ('$checkin' <= b_checkin AND '$checkout' >= b_checkout))
    WHERE booked_rooms.b_roomId IS NULL
    AND room_location = '$location' AND room_status NOT IN ('Hold', 'bishoftu_hold')";
  }

  $result = mysqli_query($connection, $query);
  confirm($result);

  $exists = mysqli_num_rows($result);

  if ($exists > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $filterd_data[] = $row;
    }
    echo json_encode($filterd_data);
  } else {
    echo json_encode("empty");
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

  $data = true;

  $pusher->trigger('group_notifications', 'group_reservation', $data);
}




if ($received_data->action === 'Newadd') {

  $checkin = $received_data->checkin;
  $checkout = $received_data->checkout;
  $rooms = $received_data->rooms;
  $form = $received_data->form;
  $reason = $received_data->form->group_reason;
  $location =  $received_data->location;

  $created_at = date('Y-m-d H:i:s');

  $placement = [];
  $gustNum = $form->group_GNum;
  $TeaB = $form->group_TeaBreak ? $form->group_TeaBreak : 0;
  $BBQ = $form->group_BBQ;
  $Dineer = $form->group_Dinner;
  $LunchNum  = $form->group_Lunch;
  $status = $form->group_status;
  $group_rooms = json_encode($rooms);
  $Roomquantity = count($rooms);

  $WeekDaysrakRate = 0.00;
  $WeekEndsrakRate = 0.00;
  $breakfast = 0.00;
  $extraBed = 0.00;
  $teaBreak = 0.00;
  $LunchBBQ = 0.00;


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
    $id = 0;
  } else {
    foreach ($row as $value) {

      $reset_auto_increment = "ALTER TABLE group_reservation AUTO_INCREMENT = $value";
      $result = mysqli_query($connection, $reset_auto_increment);
      confirm($result);

      $last_record_query = "SELECT group_id FROM group_reservation ORDER BY group_id DESC LIMIT 1";

      $last_record_result = mysqli_query($connection, $last_record_query);
      confirm($last_record_result);

      $row = mysqli_fetch_assoc($last_record_result);

      foreach ($row as $val) {
        $id = $val;
      }
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

  if ($status == 'def') {


    if ($Roomquantity == $gustNum) {

      for ($sta = 0; $sta < $Roomquantity; $sta++) {

        array_push($placement, 1);
      }
    } else if ($Roomquantity < $gustNum) {
      $doubleRooms = $gustNum - $Roomquantity;

      for ($sta = 0; $sta < $Roomquantity; $sta++) {
        array_push($placement, 1);
      }

      if ($doubleRooms > $Roomquantity) {
        $ThirdRooms = $doubleRooms - $Roomquantity;

        for ($i = 0; $i <  $Roomquantity; $i++) {

          $group = 2;
        }

        for ($i = 0; $i <  $ThirdRooms; $i++) {

          $placement[$i] = 3;
        }
      } else if ($doubleRooms <= $Roomquantity) {

        for ($i = 0; $i < $doubleRooms; $i++) {

          $placement[$i] = 2;
        }
      }
    }

    $group_query_price = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_reason = '$reason'";

    $record_result = mysqli_query($connection,  $group_query_price);
    confirm($record_result);

    $numResult = mysqli_num_rows($record_result);

    if ($numResult > 1) {


      if ($gustNum <= 50) {

        $group_query_priceR = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_range = '0-50' AND group_reason = '$reason'";
      } else if ($gustNum > 50 && $gustNum <= 80) {

        $group_query_priceR = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_range = '51-80' AND group_reason = '$reason'";
      } else if ($gustNum > 80) {

        $group_query_priceR = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_range = '80 above' AND group_reason = '$reason'";
      }

      $record_resultR = mysqli_query($connection,  $group_query_priceR);
      confirm($record_resultR);
      $row = mysqli_fetch_assoc($record_resultR);
    } else {
      $row = mysqli_fetch_assoc($record_result);
    }


    foreach ($days as $dy) {
      if ($dy == 'Friday' || $dy == 'Saturday') {
        $price += weekendsPricing($row, $placement, $gustNum, $TeaB, $BBQ, $Dineer,  $LunchNum);
      } else {
        $price += weekdaysPricing($row, $placement, $gustNum, $TeaB, $BBQ, $Dineer,  $LunchNum);
      }
    }
  } else if ($status == 'cus') {

    // Price fetch
    $CustomPrice['WeekendPricing'] = $form->Weekends;
    $CustomPrice['WeekdaysPricing'] = $form->Weekdays;
    $CustomPrice['TeaBreak_price'] = $form->custom_TeaBreak;
    $CustomPrice['BBQ_price'] = $form->custom_BBQ;
    $CustomPrice['Dinner_price'] = $form->custom_Dinner;
    $CustomPrice['Lunch_price'] = $form->custom_Lunch;
    $CustomPrice['breakfast_price'] = $form->custom_BreakFast;
    $CustomPrice['Extrabed_price'] = $form->custom_Extrabed;




    if (
      $CustomPrice['WeekendPricing'] || $CustomPrice['WeekdaysPricing'] ||
      $CustomPrice['TeaBreak_price'] || $CustomPrice['BBQ_price'] || $CustomPrice['Dinner_price'] || $CustomPrice['Lunch_price'] || $CustomPrice['breakfast_price']
      || $CustomPrice['Extrabed_price']
    ) {


      // Choose the default


      $group_query_price = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_reason = '$reason'";

      $record_result = mysqli_query($connection,  $group_query_price);
      confirm($record_result);

      $numResult = mysqli_num_rows($record_result);

      if ($numResult > 1) {


        if ($gustNum <= 50) {

          $group_query_priceR = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_range = '0-50'";
        } else if ($gustNum > 50 && $gustNum <= 80) {

          $group_query_priceR = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_range = '51-80'";
        } else if ($gustNum > 80) {

          $group_query_priceR = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_range = '80 above'";
        }

        $record_resultR = mysqli_query($connection,  $group_query_priceR);
        confirm($record_resultR);
        $row = mysqli_fetch_assoc($record_resultR);

        $CustomPrice['WeekendPricing'] = $CustomPrice['WeekendPricing'] ? $form->Weekends :  $row['group_weekday'];
        $CustomPrice['WeekdaysPricing'] = $CustomPrice['WeekdaysPricing'] ? $form->Weekdays : $row['group_weeends'];
        $CustomPrice['TeaBreak_price'] = $CustomPrice['TeaBreak_price'] ? $form->custom_TeaBreak : $row['group_tea'];
        $CustomPrice['BBQ_price'] = $CustomPrice['BBQ_price'] ? $form->custom_BBQ : $row['group_BBQ'];
        $CustomPrice['Dinner_price'] = $CustomPrice['Dinner_price'] ? $form->custom_Dinner : $row['group_dinner'];
        $CustomPrice['Lunch_price'] = $CustomPrice['Lunch_price'] ? $form->custom_Lunch :  $row['group_lunch'];
        $CustomPrice['breakfast_price'] = $CustomPrice['breakfast_price'] ? $form->custom_BreakFast : $row['group_breakfast'];
        $CustomPrice['Extrabed_price'] = $CustomPrice['Extrabed_price'] ? $form->custom_Extrabed : $row['group_extrabed'];
      } else {
        $row = mysqli_fetch_assoc($record_result);
        $CustomPrice['WeekendPricing'] = $CustomPrice['WeekendPricing'] ? $form->Weekends :  $row['group_weekday'];
        $CustomPrice['WeekdaysPricing'] = $CustomPrice['WeekdaysPricing'] ? $form->Weekdays : $row['group_weeends'];
        $CustomPrice['TeaBreak_price'] = $CustomPrice['TeaBreak_price'] ? $form->custom_TeaBreak : $row['group_tea'];
        $CustomPrice['BBQ_price'] = $CustomPrice['BBQ_price'] ? $form->custom_BBQ : $row['group_BBQ'];
        $CustomPrice['Dinner_price'] = $CustomPrice['Dinner_price'] ? $form->custom_Dinner : $row['group_dinner'];
        $CustomPrice['Lunch_price'] = $CustomPrice['Lunch_price'] ? $form->custom_Lunch : $row['group_lunch'];
        $CustomPrice['breakfast_price'] = $CustomPrice['breakfast_price'] ? $form->custom_BreakFast : $row['group_breakfast'];
        $CustomPrice['Extrabed_price'] = $CustomPrice['Extrabed_price'] ? $form->custom_Extrabed : $row['group_extrabed'];
      }
    }




    if ($Roomquantity >= $gustNum) {

      for ($sta = 0; $sta < $Roomquantity; $sta++) {

        array_push($placement, 1);
      }
    } else if ($Roomquantity < $gustNum) {
      $doubleRooms = $gustNum - $Roomquantity;

      for ($sta = 0; $sta < $Roomquantity; $sta++) {
        array_push($placement, 1);
      }

      if ($doubleRooms > $Roomquantity) {
        $ThirdRooms = $doubleRooms - $Roomquantity;

        for ($i = 0; $i <  $Roomquantity; $i++) {

          $placement[$i] = 2;
        }

        for ($i = 0; $i <  $ThirdRooms; $i++) {

          $placement[$i] = 3;
        }
      } else if ($doubleRooms <= $Roomquantity) {

        for ($i = 0; $i < $doubleRooms; $i++) {

          $placement[$i] = 2;
        }
      }
    }

    foreach ($days as $dy) {
      if ($dy == 'Friday' || $dy == 'Saturday') {
        $price += weekendsPricingCustom($CustomPrice, $placement, $gustNum, $TeaB, $BBQ, $Dineer,  $LunchNum);
      } else {
        $price += weekdaysPricingCustom($CustomPrice, $placement, $gustNum, $TeaB, $BBQ, $Dineer,  $LunchNum);
      }
    }
  }



  $res_agent = $_SESSION['username'];
  $group_rooms = json_encode($rooms);
  $quantity = count($rooms);

  $query = "INSERT INTO group_reservation(group_name, group_guest, group_roomQuantity, group_remainingRooms, group_checkin, group_checkout, group_paymentStatus, group_reason, group_price, group_remark, group_agent, group_location) ";

  $query .= "VALUES ('{$form->group_name}', $gustNum, $quantity, $quantity, '{$checkin}', '{$checkout}', '{$form->group_paymentStatus}', '{$form->group_reason}', $price, '{$form->group_remark}', '{$res_agent}', '{$group_location}')";

  $result = mysqli_query($connection, $query);
  confirm($result);

  echo json_encode($result);

  $data = true;

  $pusher->trigger('group_notifications', 'group_reservation', $data);
}



if ($received_data->action === 'EditBulkRes') {

  $checkin = $received_data->checkin;
  $checkout = $received_data->checkout;
  $rooms = $received_data->rooms;
  $form = $received_data->form;
  $reason = $received_data->form->group_reason;
  $location =  $received_data->location;
  $OldId = $received_data->GID;
  $oldRooms = $received_data->oldRooms;
  $created_at = date('Y-m-d H:i:s');

  $placement = [];
  $gustNum = $form->group_GNum;
  $TeaB = $form->group_TeaBreak ? $form->group_TeaBreak : 0;
  $BBQ = $form->group_BBQ;
  $Dineer = $form->group_Dinner;
  $LunchNum  = $form->group_Lunch;
  $status = $form->group_status;
  $group_rooms = json_encode($rooms);
  $Roomquantity = count($rooms);

  $WeekDaysrakRate = 0.00;
  $WeekEndsrakRate = 0.00;
  $breakfast = 0.00;
  $extraBed = 0.00;
  $teaBreak = 0.00;
  $LunchBBQ = 0.00;


  $price = 0.00;
  // calculate number of days
  $days       = array();
  $start      = new DateTime($checkin);
  $end        = new DateTime($checkout);

  foreach ($oldRooms as $value) {
    $int_roomIdup = intval($value->room_number);
    $update_query = "UPDATE rooms SET room_status = 'Not_booked' WHERE room_id = $int_roomIdup";

    $update_result = mysqli_query($connection, $update_query);
    confirm($update_result);
  }

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
    $id = 0;
  } else {
    foreach ($row as $value) {

      $reset_auto_increment = "ALTER TABLE group_reservation AUTO_INCREMENT = $value";
      $result = mysqli_query($connection, $reset_auto_increment);
      confirm($result);

      $last_record_query = "SELECT group_id FROM group_reservation ORDER BY group_id DESC LIMIT 1";

      $last_record_result = mysqli_query($connection, $last_record_query);
      confirm($last_record_result);

      $row = mysqli_fetch_assoc($last_record_result);

      foreach ($row as $val) {
        $id = $val;
      }
    }
  }


  $last_id = $id + 1;

  foreach ($rooms as $value) {
    $int_roomId = intval($value->room_number);
    $room_num   = intval($value->g_room_number);
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

  if ($status == 'def') {


    if ($Roomquantity == $gustNum) {

      for ($sta = 0; $sta < $Roomquantity; $sta++) {

        array_push($placement, 1);
      }
    } else if ($Roomquantity < $gustNum) {
      $doubleRooms = $gustNum - $Roomquantity;

      for ($sta = 0; $sta < $Roomquantity; $sta++) {
        array_push($placement, 1);
      }

      if ($doubleRooms > $Roomquantity) {
        $ThirdRooms = $doubleRooms - $Roomquantity;

        for ($i = 0; $i <  $Roomquantity; $i++) {

          $group = 2;
        }

        for ($i = 0; $i <  $ThirdRooms; $i++) {

          $placement[$i] = 3;
        }
      } else if ($doubleRooms <= $Roomquantity) {

        for ($i = 0; $i < $doubleRooms; $i++) {

          $placement[$i] = 2;
        }
      }
    }

    $group_query_price = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_reason = '$reason'";

    $record_result = mysqli_query($connection,  $group_query_price);
    confirm($record_result);

    $numResult = mysqli_num_rows($record_result);

    if ($numResult > 1) {


      if ($gustNum <= 50) {

        $group_query_priceR = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_range = '0-50' AND group_reason = '$reason'";
      } else if ($gustNum > 50 && $gustNum <= 80) {

        $group_query_priceR = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_range = '51-80' AND group_reason = '$reason'";
      } else if ($gustNum > 80) {

        $group_query_priceR = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_range = '80 above' AND group_reason = '$reason'";
      }

      $record_resultR = mysqli_query($connection,  $group_query_priceR);
      confirm($record_resultR);
      $row = mysqli_fetch_assoc($record_resultR);
    } else {
      $row = mysqli_fetch_assoc($record_result);
    }


    foreach ($days as $dy) {
      if ($dy == 'Friday' || $dy == 'Saturday') {
        $price += weekendsPricing($row, $placement, $gustNum, $TeaB, $BBQ, $Dineer,  $LunchNum);
      } else {
        $price += weekdaysPricing($row, $placement, $gustNum, $TeaB, $BBQ, $Dineer,  $LunchNum);
      }
    }
  } else if ($status == 'cus') {

    // Price fetch
    $CustomPrice['WeekendPricing'] = $form->Weekends;
    $CustomPrice['WeekdaysPricing'] = $form->Weekdays;
    $CustomPrice['TeaBreak_price'] = $form->custom_TeaBreak;
    $CustomPrice['BBQ_price'] = $form->custom_BBQ;
    $CustomPrice['Dinner_price'] = $form->custom_Dinner;
    $CustomPrice['Lunch_price'] = $form->custom_Lunch;
    $CustomPrice['breakfast_price'] = $form->custom_BreakFast;
    $CustomPrice['Extrabed_price'] = $form->custom_Extrabed;




    if (
      $CustomPrice['WeekendPricing'] || $CustomPrice['WeekdaysPricing'] ||
      $CustomPrice['TeaBreak_price'] || $CustomPrice['BBQ_price'] || $CustomPrice['Dinner_price'] || $CustomPrice['Lunch_price'] || $CustomPrice['breakfast_price']
      || $CustomPrice['Extrabed_price']
    ) {


      // Choose the default


      $group_query_price = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_reason = '$reason'";

      $record_result = mysqli_query($connection,  $group_query_price);
      confirm($record_result);

      $numResult = mysqli_num_rows($record_result);

      if ($numResult > 1) {


        if ($gustNum <= 50) {

          $group_query_priceR = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_range = '0-50'";
        } else if ($gustNum > 50 && $gustNum <= 80) {

          $group_query_priceR = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_range = '51-80'";
        } else if ($gustNum > 80) {

          $group_query_priceR = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_range = '80 above'";
        }

        $record_resultR = mysqli_query($connection,  $group_query_priceR);
        confirm($record_resultR);
        $row = mysqli_fetch_assoc($record_resultR);

        $CustomPrice['WeekendPricing'] = $CustomPrice['WeekendPricing'] ? $form->Weekends :  $row['group_weekday'];
        $CustomPrice['WeekdaysPricing'] = $CustomPrice['WeekdaysPricing'] ? $form->Weekdays : $row['group_weeends'];
        $CustomPrice['TeaBreak_price'] = $CustomPrice['TeaBreak_price'] ? $form->custom_TeaBreak : $row['group_tea'];
        $CustomPrice['BBQ_price'] = $CustomPrice['BBQ_price'] ? $form->custom_BBQ : $row['group_BBQ'];
        $CustomPrice['Dinner_price'] = $CustomPrice['Dinner_price'] ? $form->custom_Dinner : $row['group_dinner'];
        $CustomPrice['Lunch_price'] = $CustomPrice['Lunch_price'] ? $form->custom_Lunch :  $row['group_lunch'];
        $CustomPrice['breakfast_price'] = $CustomPrice['breakfast_price'] ? $form->custom_BreakFast : $row['group_breakfast'];
        $CustomPrice['Extrabed_price'] = $CustomPrice['Extrabed_price'] ? $form->custom_Extrabed : $row['group_extrabed'];
      } else {
        $row = mysqli_fetch_assoc($record_result);
        $CustomPrice['WeekendPricing'] = $CustomPrice['WeekendPricing'] ? $form->Weekends :  $row['group_weekday'];
        $CustomPrice['WeekdaysPricing'] = $CustomPrice['WeekdaysPricing'] ? $form->Weekdays : $row['group_weeends'];
        $CustomPrice['TeaBreak_price'] = $CustomPrice['TeaBreak_price'] ? $form->custom_TeaBreak : $row['group_tea'];
        $CustomPrice['BBQ_price'] = $CustomPrice['BBQ_price'] ? $form->custom_BBQ : $row['group_BBQ'];
        $CustomPrice['Dinner_price'] = $CustomPrice['Dinner_price'] ? $form->custom_Dinner : $row['group_dinner'];
        $CustomPrice['Lunch_price'] = $CustomPrice['Lunch_price'] ? $form->custom_Lunch : $row['group_lunch'];
        $CustomPrice['breakfast_price'] = $CustomPrice['breakfast_price'] ? $form->custom_BreakFast : $row['group_breakfast'];
        $CustomPrice['Extrabed_price'] = $CustomPrice['Extrabed_price'] ? $form->custom_Extrabed : $row['group_extrabed'];
      }
    }




    if ($Roomquantity >= $gustNum) {

      for ($sta = 0; $sta < $Roomquantity; $sta++) {

        array_push($placement, 1);
      }
    } else if ($Roomquantity < $gustNum) {
      $doubleRooms = $gustNum - $Roomquantity;

      for ($sta = 0; $sta < $Roomquantity; $sta++) {
        array_push($placement, 1);
      }

      if ($doubleRooms > $Roomquantity) {
        $ThirdRooms = $doubleRooms - $Roomquantity;

        for ($i = 0; $i <  $Roomquantity; $i++) {

          $placement[$i] = 2;
        }

        for ($i = 0; $i <  $ThirdRooms; $i++) {

          $placement[$i] = 3;
        }
      } else if ($doubleRooms <= $Roomquantity) {

        for ($i = 0; $i < $doubleRooms; $i++) {

          $placement[$i] = 2;
        }
      }
    }

    foreach ($days as $dy) {
      if ($dy == 'Friday' || $dy == 'Saturday') {
        $price += weekendsPricingCustom($CustomPrice, $placement, $gustNum, $TeaB, $BBQ, $Dineer,  $LunchNum);
      } else {
        $price += weekdaysPricingCustom($CustomPrice, $placement, $gustNum, $TeaB, $BBQ, $Dineer,  $LunchNum);
      }
    }
  }



  $res_agent = $_SESSION['username'];
  $group_rooms = json_encode($rooms);
  $quantity = count($rooms);

  $query = "INSERT INTO group_reservation(group_name, group_guest, group_roomQuantity, group_remainingRooms, group_checkin, group_checkout, group_paymentStatus, group_reason, group_price, group_remark, group_agent, group_location) ";

  $query .= "VALUES ('{$form->group_name}', $gustNum, $quantity, $quantity, '{$checkin}', '{$checkout}', '{$form->group_paymentStatus}', '{$form->group_reason}', $price, '{$form->group_remark}', '{$res_agent}', '{$group_location}')";

  $result = mysqli_query($connection, $query);
  confirm($result);

  $last_record_Delete = "DELETE FROM group_rooms WHERE g_res_id = $OldId";

  $last_record_Delete = mysqli_query($connection, $last_record_Delete);
  confirm($last_record_Delete);

  $last_Guest_Delete = "DELETE FROM group_reservation WHERE group_id = $OldId";

  $last_Guest_Delete = mysqli_query($connection, $last_Guest_Delete);
  confirm($last_Guest_Delete);

  echo json_encode($result);

  $data = true;

  $pusher->trigger('group_notifications', 'group_reservation', $data);
}

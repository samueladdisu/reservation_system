
<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php

$received_data = json_decode(file_get_contents("php://input"));
date_default_timezone_set('Africa/Addis_Ababa');

if ($received_data->action == 'filter') {

  $room_quantity_array = array();
  $filterd_data = array();
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


    // echo json_encode($row); 
     
      $query = "SELECT DISTINCT b_roomId 
      FROM booked_rooms 
      WHERE b_checkout>= '$checkin' 
      AND b_roomId = {$row['b_roomId']}
      UNION
      SELECT DISTINCT b_roomId
      FROM booked_rooms
      WHERE b_checkin <= '$checkout'
      AND b_roomId = {$row['b_roomId']}";

      $result = mysqli_query($connection, $query);
      while ($row = mysqli_fetch_assoc($result)) {

          $filterd_data[] = $row;
        }
      
        // $select_room_query = "SELECT * 
        // FROM rooms 
        // WHERE room_id = {$row['b_roomId']}";

        // $select_room_result = mysqli_query($connection, $select_room_query);
        // confirm($select_room_result);
        // while ($row2 = mysqli_fetch_assoc($select_room_result)) {

        //   $filterd_data[] = $row2;
        // }
    }

    echo json_encode($filterd_data);

    // if ($location && $roomType) {
    //   $select_not_booked_query = "SELECT * 
    // FROM rooms
    // WHERE room_status = 'Not_booked'
    // AND room_location = '$location'
    // AND room_acc = '$roomType'";
    // } else if ($location && !$roomType) {
    //   $select_not_booked_query = "SELECT * 
    //   FROM rooms
    //   WHERE room_status = 'Not_booked'
    //   AND room_location = '$location'";
    // } else if (!$location && $roomType) {
    //   $select_not_booked_query = "SELECT * 
    // FROM rooms
    // WHERE room_status = 'Not_booked'
    // AND room_acc = '$roomType'";
    // }

    // $select_not_booked_result = mysqli_query($connection, $select_not_booked_query);
    // confirm($select_not_booked_result);

    // while ($row3 = mysqli_fetch_assoc($select_not_booked_result)) {
    //   $Not_booked_array[] = $row3;
    // }

    // $merged_array = array_merge($filterd_data, $Not_booked_array);
    // $merged_array = array_slice($merged_array, 0, $roomQuantity);
    // echo json_encode($merged_array);
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
    // echo json_encode($filterd_data);
  }
}

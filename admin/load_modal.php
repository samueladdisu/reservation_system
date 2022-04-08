<?php session_start(); ?>
<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php

$received_data = json_decode(file_get_contents("php://input"));
date_default_timezone_set('Africa/Addis_Ababa');

$location = $_SESSION['user_location'];
$role = $_SESSION['user_role'];
$filterd_data = array();
$allData = array();

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


if ($received_data->action == 'filter') {
  $location = $received_data->location;
  $roomType = $received_data->roomType;
  $checkin = $received_data->checkin;
  $checkout = $received_data->checkout;


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

      if ($location && $roomType) {
        $select_room_query = "SELECT * 
      FROM rooms 
      WHERE room_id = {$row['b_roomId']}
      UNION
      SELECT * 
      FROM rooms
      WHERE room_status = 'Not_booked'
      AND room_location = '$location'
      AND room_acc = '$roomType'";
      } else if ($location && !$roomType) {
        $select_room_query = "SELECT * 
        FROM rooms 
        WHERE room_id = {$row['b_roomId']}
        UNION
        SELECT * 
        FROM rooms
        WHERE room_status = 'Not_booked'
        AND room_location = '$location'";
      } else if (!$location && $roomType) {
        $select_room_query = "SELECT * 
      FROM rooms 
      WHERE room_id = {$row['b_roomId']}
      UNION
      SELECT * 
      FROM rooms
      WHERE room_status = 'Not_booked'
      AND room_acc = '$roomType'";
      }

      $select_room_result = mysqli_query($connection, $select_room_query);
      confirm($select_room_result);
      while ($row2 = mysqli_fetch_assoc($select_room_result)) {

        $filterd_data[] = $row2;
      }
    }
    echo json_encode($filterd_data);
  } else {
    if ($location && $roomType) {
      $ava_query = "SELECT * 
      FROM rooms 
      WHERE room_status = 'Not_booked' 
      AND room_location = '$location'
      AND room_acc = '$roomType'";
    } else if ($location && !$roomType) {
      $ava_query = "SELECT * 
      FROM rooms 
      WHERE room_status = 'Not_booked' 
      AND room_location = '$location'";
    } else if (!$location && $roomType) {
      $ava_query = "SELECT *
      FROM rooms
      WHERE room_status = 'Not_booked'
      AND room_acc = '$roomType'";
    }
    $ava_result = mysqli_query($connection, $ava_query);
    confirm($ava_result);
    while ($row_ava = mysqli_fetch_assoc($ava_result)) {

      $filterd_data[] = $row_ava;
    }
    echo json_encode($filterd_data);
  }
}

if ($received_data->action == 'fetchAll') {

  if ($role == "SA" || ($location == "Boston" && $role == 'RA')) {
    $query = "SELECT * FROM rooms WHERE room_status = 'Not_booked'";
  } else {

    $query = "SELECT * FROM rooms WHERE room_status = 'Not_booked' AND room_location = '$location'";
  }

  $result = mysqli_query($connection, $query);
  confirm($result);
  while ($row = mysqli_fetch_assoc($result)) {
    $allData[] = $row;
  }

  echo json_encode($allData);
}

if ($received_data->action == 'fetchAllRoom') {
  $query = "SELECT * FROM rooms";
  $result = mysqli_query($connection, $query);
  confirm($result);
  while ($row = mysqli_fetch_assoc($result)) {
    $allData[] = $row;
  }

  echo json_encode($allData);
}
if ($received_data->action == 'addReservation') {

  $form_data  = $received_data->Form;
  $checkin    = $received_data->checkin;
  $checkout   = $received_data->checkout;
  $rooms      = $received_data->rooms;
  $price      = 0.00;
  $room_types = array();
  $room_num   = array();
  $res_location = '';

  // calculate number of days
  $days       = array();
  $start      = new DateTime($checkin);
  $end        = new DateTime($checkout);

  for ($date = $start; $date < $end; $date->modify('+1 day')) {
    $days[] = $date->format('l');
  }


  foreach ($rooms as $value) {
    $intRooms = intval($value->room_id);
    $adults   = intval($value->adults);
    $teens    = intval($value->teens);
    $kids     = intval($value->kids);

    $room_types[] = $value->room_acc;
    $room_num[]   = intval($value->room_id);
    $res_location = $value->room_location;
    // Insert into booked table

    $booked_query = "INSERT INTO booked_rooms(b_roomId, b_roomType, b_roomLocation, b_checkin, b_checkout) ";
    $booked_query .= "VALUES ($intRooms , '{$value->room_acc}', '{$value->room_location}',  '{$checkin}', '{$checkout}')";

    $booked_result = mysqli_query($connection, $booked_query);

    confirm($booked_result);

    // Update room to booked

    $update_query = "UPDATE rooms SET room_status = 'booked' WHERE room_id = $intRooms";

    $update_result = mysqli_query($connection, $update_query);
    confirm($update_result);



  }

  foreach ($room_types as $value){
    $query_type = "SELECT * FROM room_type WHERE type_name = '$value'";
    $result_type = mysqli_query($connection, $query_type);
    confirm($result_type);
  
  
  
    while ($row_type = mysqli_fetch_assoc($result_type)) {
  
      // double occupancy rate
      $dbRack    = doubleval($row_type['d_rack_rate']);
      $dbWeekend = doubleval($row_type['d_weekend_rate']);
      $dbWeekdays = doubleval($row_type['d_weekday_rate']);
      $dbMember  = doubleval($row_type['d_member_rate']);
  
      // Single occupancy rate
      $sRack     = doubleval($row_type['s_rack_rate']);
      $sWeekend  = doubleval($row_type['s_weekend_rate']);
      $sWeekdays = doubleval($row_type['s_weekday_rate']);
      $sMember  = doubleval($row_type['s_member_rate']);
  
      if ($row_type['type_location'] == 'Bishoftu') {
  
        foreach ($days as $day) {
          switch ($day) {
            case 'Friday':
              // $price +=  doubleval($row_type['d_weekend_rate']);
              $price += calculatePrice($adults, $kids, $teens, $sWeekend, $dbWeekend);
              break;
            case 'Saturday':
              // $price += doubleval($row_type['d_rack_rate']);
              $price += calculatePrice($adults, $kids, $teens, $sRack, $dbRack);
              break;
            default:
              // $price += doubleval($row_type['d_weekday_rate']);
              $price += calculatePrice($adults, $kids, $teens, $sWeekdays, $dbWeekdays);
              break;
          }
        }
      } else if ($row_type['type_location'] == 'Awash') {
        foreach ($days as $day) {
          switch ($day) {
            case 'Friday':
              // $price += doubleval($row_type['d_rack_rate']);
              $price += calculatePrice($adults, $kids, $teens, $sRack, $dbRack);
              break;
            case 'Saturday':
              $price += calculatePrice($adults, $kids, $teens, $sRack, $dbRack);
              break;
            default:
              $price += calculatePrice($adults, $kids, $teens, $sWeekdays, $dbWeekdays);
              break;
          }
        }
      }
    }

  }

  


  echo json_encode($price);

  // // echo json_encode($room_types);

  $res_confirmID = getName(8);


  $extraBed = isset($form_data->res_extraBed) ? 'yes' : 'no';

  $roomIds = json_encode($room_num);

  // echo $params['res_extraBed'];

  $res_agent = $_SESSION['username'];
  $query = "INSERT INTO reservations(res_firstname, res_lastname, res_phone, res_email, res_adults, res_teens, res_kids, res_groupName, res_checkin, res_checkout, res_paymentMethod, res_roomIDs, res_location, res_specialRequest, res_agent, res_remark, res_promo, res_extraBed, res_confirmID, res_price) ";

  $query .= "VALUES ('{$form_data->res_firstname}', '{$form_data->res_lastname}', '{$form_data->res_phone}', '{$form_data->res_email}', $adults, $teens, $kids, '{$form_data->res_groupName}', '{$checkin}', '{$checkout}', '{$form_data->res_paymentMethod}', '{$roomIds}', '{$res_location}', '{$form_data->res_specialRequest}', '{$res_agent}', '{$form_data->res_remark}', '{$form_data->res_promo}', '$extraBed', '$res_confirmID', $price) ";

  $result = mysqli_query($connection, $query);
  confirm($result);

}


if ($received_data->action == 'promoCode') {
  $code = $received_data->data;
  $promoData = array();
  $promo_query = "SELECT * FROM promo WHERE promo_code = '$code'";
  $promo_result = mysqli_query($connection, $promo_query);

  confirm($promo_result);

  while ($row = mysqli_fetch_assoc($promo_result)) {
    foreach ($row as $key => $value) {
      $params[$key] = $value;
    }

    $current_date = date('m/d/Y h:i:s', time());

    if ($params['promo_time'] > $current_date && $params['promo_usage'] > 0) {
      $updated_usage = $params['promo_usage'] - 1;
      $update_promo = "UPDATE promo SET promo_usage = $updated_usage WHERE promo_id = {$params['promo_id']}";

      $update_promo_result = mysqli_query($connection, $update_promo);
      confirm($update_promo_result);
      echo json_encode($params['promo_amount']);
    } else {
      echo json_encode(false);
    }
  }
}

?>
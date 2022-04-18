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
  $room_numbers = array();
  $guests = array();
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

    $guests[]         = array($adults, $kids, $teens);
    $room_types[]     = $value->room_acc;
    $room_num[]       = intval($value->room_id);
    $room_numbers[]   = intval($value->room_number);
    $res_location     = $value->room_location;

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

  $index = 0;
  foreach ($room_types as $value) {
    $query_type = "SELECT * FROM room_type WHERE type_name = '$value'";
    $result_type = mysqli_query($connection, $query_type);
    confirm($result_type);


    // echo json_encode("room type");
    // echo json_encode($value);
    // echo json_encode($guests[$index][0]);

    while ($row_type = mysqli_fetch_assoc($result_type)) {

      // double occupancy rate
      $type_location = $row_type['type_location'];



      $dbRack    = doubleval($row_type['d_rack_rate']);
      $dbWeekend = doubleval($row_type['d_weekend_rate']);
      $dbWeekdays = doubleval($row_type['d_weekday_rate']);
      $dbMember  = doubleval($row_type['d_member_rate']);

      // Single occupancy rate
      $sRack     = doubleval($row_type['s_rack_rate']);
      $sWeekend  = doubleval($row_type['s_weekend_rate']);
      $sWeekdays = doubleval($row_type['s_weekday_rate']);
      $sMember  = doubleval($row_type['s_member_rate']);
    }

    if ($type_location == 'Bishoftu') {

      foreach ($days as $day) {
        switch ($day) {
          case 'Friday':
            $price += calculatePrice($guests[$index][0], $guests[$index][1], $guests[$index][2], $sWeekend, $dbWeekend);
            break;
          case 'Saturday':
            $price += calculatePrice($guests[$index][0], $guests[$index][1], $guests[$index][2], $sRack, $dbRack);
            break;
          default:
            // $price += doubleval($row_type['d_weekday_rate']);
            $price += calculatePrice($guests[$index][0], $guests[$index][1], $guests[$index][2], $sWeekdays, $dbWeekdays);
            break;
        }
      }
    } else if ($type_location == 'Awash') {
      foreach ($days as $day) {
        switch ($day) {
          case 'Friday':
            $price += calculatePrice($guests[$index][0], $guests[$index][1], $guests[$index][2], $sRack, $dbRack);
            break;
          case 'Saturday':
            $price += calculatePrice($guests[$index][0], $guests[$index][1], $guests[$index][2], $sRack, $dbRack);
            break;
          default:
            $price += calculatePrice($guests[$index][0], $guests[$index][1], $guests[$index][2], $sWeekdays, $dbWeekdays);
            break;
        }
      }
    }
    $index++;
  }



  echo json_encode("Total Price");
  echo json_encode($price);

  if ($form_data->res_promo) {

    if($form_data->res_promo == "member"){
      $promo_query = "SELECT * FROM promo WHERE promo_code = '$form_data->res_promo' LIMIT 1";
      $promo_result = mysqli_query($connection, $promo_query);

      confirm($promo_result);

      $row =  mysqli_fetch_assoc($promo_result);

      
      $price = $price - ($price * ($row['promo_amount'] / 100));

    }else{
      
      $promo_query = "SELECT * FROM promo WHERE promo_code = '$form_data->res_promo'";
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

  }

  echo json_encode("Discount");
  echo json_encode($price);

  $res_confirmID   = getName(8);

  $roomIds         = json_encode($room_num);
  $roomNumbers     = json_encode($room_numbers);
  $roomTypes       = json_encode($room_types);
  $res_guests      = json_encode($guests);

  $res_agent = $_SESSION['username'];
  $query = "INSERT INTO reservations(res_firstname, res_lastname, res_phone, res_email, res_guestNo, res_groupName, res_checkin, res_checkout, res_paymentMethod, res_roomIDs, res_roomNo, res_roomType, res_location, res_specialRequest, res_agent, res_remark, res_promo, res_extraBed, res_confirmID, res_price) ";

  $query .= "VALUES ('{$form_data->res_firstname}', '{$form_data->res_lastname}', '{$form_data->res_phone}', '{$form_data->res_email}', '{$res_guests}', '{$form_data->res_groupName}', '{$checkin}', '{$checkout}', '{$form_data->res_paymentMethod}', '{$roomIds}', '{$roomNumbers}', '{$roomTypes}', '{$res_location}', '{$form_data->res_specialRequest}', '{$res_agent}', '{$form_data->res_remark}', '{$form_data->res_promo}', 'Null', '$res_confirmID', $price) ";

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

if ($received_data->action == 'fetchPromo') {
  $query = $received_data->query;
  $data = array();

  if ($query != '') {

    $sql = "SELECT * FROM promo WHERE promo_code LIKE '%" . $query . "%' AND promo_active = 'yes'";
    $result = mysqli_query($connection, $sql);
    confirm($result);

    while ($row = mysqli_fetch_assoc($result)) {
      $data[] = $row;
    }
  }

  echo json_encode($data);
  // echo json_encode(confirm($result));
}

?>
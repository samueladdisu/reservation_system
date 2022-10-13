<?php include  'config.php'; ?>


<?php

$received_data = json_decode(file_get_contents("php://input"));

$data = array();
$output = array();
$filterd_data1 = array();
$filterd_data2 = array();
$Not_booked = array();
$booked = array();
$merged_array = array();


if ($received_data->action == 'filter') {
  $location = $received_data->location;
  $checkin = $received_data->checkin;
  $checkout = $received_data->checkout;

  $count = 0;
  $roomAcc_temp = '';
  $roomLocation = '';
  $dataCount = [];

  $query = "SELECT * 
  FROM rooms 
  WHERE room_id 
  NOT IN 
    ( SELECT b_roomId
      FROM booked_rooms 
      WHERE '$checkin'
      BETWEEN b_checkin AND b_checkout 
      UNION
      SELECT b_roomId
      FROM booked_rooms
      WHERE '$checkout'
      BETWEEN b_checkin AND b_checkout
      )
  AND room_location = '$location' ORDER BY room_acc";

  $result = mysqli_query($connection, $query);
  confirm($result);

  $exists = mysqli_num_rows($result);


  if ($exists > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
      $merged_array[] = $row;
    }
    foreach ($merged_array as $key => $value) {


      if ($roomAcc_temp == '' || $roomLocation == '') {
        $roomAcc_temp = $merged_array[$key]["room_acc"];
        $roomLocation = $merged_array[$key]["room_location"];
        array_push($data, $merged_array[$key]);
      } else if ($roomAcc_temp == $merged_array[$key]["room_acc"] && $roomLocation == $merged_array[$key]["room_location"]) {

        array_push($data, $merged_array[$key]);
      } else if ($roomAcc_temp !== $merged_array[$key]["room_acc"] || $roomLocation !== $merged_array[$key]["room_location"]) {
        $roomAcc_temp = $merged_array[$key]["room_acc"];
        $roomLocation = $merged_array[$key]["room_location"];
        array_push($dataCount, $data);
        $data = [];
        array_push($data, $merged_array[$key]);
        // goto here;


      }
    }


    if (count($data) >= 1) {
      array_push($dataCount, $data);
    }
    echo json_encode($dataCount);
  } 
}


if ($received_data->action == 'fetchall') {
  $count = 0;
  $roomAcc_temp = '';
  $roomLocation = '';
  $dataCount = [];
  // $query2 = "SELECT * FROM rooms WHERE room_status = 'Not_booked'";
  // $query = "SELECT * FROM rooms GROUP BY room_acc";
  //  $query2 = "SELECT *, COUNT(room_acc) AS cnt FROM rooms GROUP BY room_acc HAVING room_status = 'Not_booked';";
  // $result = mysqli_query($connection, $query);
  // $query2 = "SELECT *, COUNT(room_acc) AS cnt FROM rooms WHERE room_status = 'Not_booked' GROUP BY room_acc;";
  $query2 = "SELECT * FROM rooms WHERE room_status = 'Not_booked' ORDER BY room_acc;";

  $result2 = mysqli_query($connection, $query2);

  // confirm($result);
  confirm($result2);
  while ($row = mysqli_fetch_assoc($result2)) {

    if ($roomAcc_temp == '' || $roomLocation == '') {
      $roomAcc_temp = $row["room_acc"];
      $roomLocation = $row["room_location"];
    } else if ($roomAcc_temp == $row["room_acc"] && $roomLocation == $row["room_location"]) {
      array_push($data, $row);
    } else if ($roomAcc_temp !== $row["room_acc"] || $roomLocation !== $row["room_location"]) {
      $roomAcc_temp = $row["room_acc"];
      $roomLocation = $row["room_location"];
      array_push($dataCount, $data);
      $data = [];
      array_push($data, $row);
      // goto here;
    }
  }
  if (count($data) > 1) {
    array_push($dataCount, $data);
  }

  echo json_encode($dataCount);
}

if ($received_data->action == 'fetchallLocation') {

  $location = $received_data->location;
  $checkin = $received_data->checkin;
  $checkout = $received_data->checkout;
  
  $count = 0;
  $roomAcc_temp = '';
  $roomLocation = '';
  $dataCount = [];
  // $query2 = "SELECT * FROM rooms WHERE room_status = 'Not_booked' AND room_location = '$location' ORDER BY room_acc;";

  $query2 = "SELECT * 
  FROM rooms 
  WHERE room_id 
  NOT IN 
    ( SELECT b_roomId
      FROM booked_rooms 
      WHERE '$checkin'
      BETWEEN b_checkin AND b_checkout 
      UNION
      SELECT b_roomId
      FROM booked_rooms
      WHERE '$checkout'
      BETWEEN b_checkin AND b_checkout
      )
  AND room_location = '$location' ORDER BY room_acc";

  $result2 = mysqli_query($connection, $query2);
  confirm($result2);

  while ($row = mysqli_fetch_assoc($result2)) {

    if ($roomAcc_temp == '' || $roomLocation == '') {
      $roomAcc_temp = $row["room_acc"];
      $roomLocation = $row["room_location"];
      array_push($data, $row);
    } else if ($roomAcc_temp == $row["room_acc"] && $roomLocation == $row["room_location"]) {

      array_push($data, $row);
    } else if ($roomAcc_temp !== $row["room_acc"] || $roomLocation !== $row["room_location"]) {
      $roomAcc_temp = $row["room_acc"];
      $roomLocation = $row["room_location"];
      array_push($dataCount, $data);
      $data = [];
      array_push($data, $row);
      // goto here;

    }
  }
  if (count($data) >= 1) {
    array_push($dataCount, $data);
  }


  echo json_encode($dataCount);
}

if ($received_data->action == 'fetchallLocRom') {
  $location = $received_data->location;
  $roomType = $received_data->roomType;

  $count = 0;
  $roomAcc_temp = '';
  $roomLocation = '';
  $dataCount = [];

  if ($location == "bishoftu") {

    if ($roomType == "lakeview") {
      $query = "SELECT * FROM rooms WHERE room_location = '$location' AND room_status = 'Not_booked' AND  (room_acc = 'Deluxe Lake Front king size bed' OR room_acc = 'Deluxe Lake Front Twin Beds' OR room_acc = 'Top View King Size Bed' OR room_acc = 'Top View Twin Beds') ORDER BY room_acc";
    } else if ($roomType == "gardenview") {
      $query = "SELECT * FROM rooms WHERE room_location = '$location' AND room_status = 'Not_booked' AND (room_acc = 'Garden View King Size Bed' OR room_acc = 'Garden View Twin Beds') ORDER BY room_acc";
    } else if ($roomType == "village") {
      $query = "SELECT * FROM rooms WHERE room_location = '$location' AND room_status = 'Not_booked' AND room_acc = 'Loft Family Room' ORDER BY room_acc";
    } else if ($roomType == "Presidential") {
      $query = "SELECT * FROM rooms WHERE room_location = '$location' AND room_status = 'Not_booked' AND (room_acc = 'Presidential Suite Family Room' OR room_acc = 'Presidential Suite King Size Bed') ORDER BY room_acc";
    }
  } else if ($location == 'entoto') {

    if ($roomType == "tent") {
      $query = "SELECT * FROM rooms WHERE room_location = '$location' AND room_status = 'Not_booked' AND (room_acc = 'Forest View Twin Bed' OR room_acc = 'Forest View King Size Bed') ORDER BY room_acc";
    } else if ($roomType == "cabin") {
      $query = "SELECT * FROM rooms WHERE room_location = '$location' AND room_status = 'Not_booked' AND room_acc = 'Presidential Family Room' ORDER BY room_acc";
    }
  } else if ($location == 'awash') {

    if ($roomType == 'premium') {
      $query = "SELECT * FROM rooms WHERE room_location = '$location' AND room_status = 'Not_booked' AND room_acc = 'Premier Room'";
    } else if ($roomType == 'junior') {
      $query = "SELECT * FROM rooms WHERE room_location = '$location' AND room_status = 'Not_booked' AND room_acc = 'Junior Suite' ORDER BY room_acc";
    } else if ($roomType == 'executive') {
      $query = "SELECT * FROM rooms WHERE room_location = '$location' AND room_status = 'Not_booked' AND room_acc = 'Executive' ORDER BY room_acc";
    } else if ($roomType == 'presidential') {
      $query = "SELECT * FROM rooms WHERE room_location = '$location' AND room_status = 'Not_booked' AND room_acc = 'presidential' ORDER BY room_acc";
    }
  } else if ($location == 'Lake tana') {
    if ($roomType == 'lakeview') {
      $query = "SELECT * FROM rooms WHERE room_location = '$location' AND room_status = 'Not_booked' AND (room_acc = 'Deluxe Lake Front king size bed' OR room_acc = 'Deluxe Lake Front Twin Beds' OR room_acc = '	Deluxe Lake View King Size') ORDER BY room_acc";
    } else if ($roomType == "gardenview") {
      $query = "SELECT * FROM rooms WHERE room_location = '$location' AND room_status = 'Not_booked' AND (room_acc = 'Garden View Twin Beds' OR room_acc = 'Garden View King Size') ORDER BY room_acc";
    } else if ($roomType == "presidential") {
      $query = "SELECT * FROM rooms WHERE room_location = '$location' AND room_status = 'Not_booked' AND room_acc = 'Executive Suite Extra King Size' ORDER BY room_acc";
    }
  }

  // echo json_encode($query);

  $result = mysqli_query($connection, $query);

  while ($row = mysqli_fetch_assoc($result)) {

    if ($roomAcc_temp == '' || $roomLocation == '') {
      $roomAcc_temp = $row["room_acc"];
      $roomLocation = $row["room_location"];
      array_push($data, $row);
    } else if ($roomAcc_temp == $row["room_acc"] && $roomLocation == $row["room_location"]) {

      array_push($data, $row);
    } else if ($roomAcc_temp !== $row["room_acc"] || $roomLocation !== $row["room_location"]) {
      $roomAcc_temp = $row["room_acc"];
      $roomLocation = $row["room_location"];
      array_push($dataCount, $data);
      $data = [];
      array_push($data, $row);
      // goto here;

    }
  }

  if (count($data) >= 1) {
    array_push($dataCount, $data);
  }


  echo json_encode($dataCount);
}

if ($received_data->action == 'promoCode') {
  $promo = $received_data->data;
  $price = $received_data->TotalPrice;
  // $price = floatval($recprice);

  global $connection;

  $promo_query = "SELECT * FROM promo WHERE promo_code = '$promo' AND promo_active = 'yes' LIMIT 1";
  $promo_result = mysqli_query($connection, $promo_query);

  confirm($promo_result);
  $row = mysqli_fetch_assoc($promo_result);
  $PromoId = $row['promo_id'];
  $usage = $row['promo_usage'];
  // echo json_encode($price);

  if ($row['promo_time'] == null && $row['promo_usage'] == null) {
    $Discount = $price * ($row['promo_amount'] / 100);
    echo json_encode($price - $Discount);
  } else if ($row['promo_time'] == null && $row['promo_usage'] !== null) {

    if ($row['promo_usage'] == 0) {
      echo json_encode("Expired");
    } else {
      $updated_usage = intval($usage - 1);
      $update_promo = "UPDATE promo SET promo_usage = $updated_usage WHERE promo_id = '$PromoId'";
      $promo_result = mysqli_query($connection, $update_promo);
      confirm($promo_result);

      $Discount = $price * ($row['promo_amount'] / 100);
      echo json_encode($price - $Discount);
    }
  } else if ($row['promo_time'] !== null && $row['promo_usage'] == null) {

    $expireDate = strtotime($row['promo_time']);
    $today = strtotime(date('Y-m-d H:i:s'));

    if ($today >= $expireDate) {
      echo json_encode("expired");
    } else {
      $Discount = $price * ($row['promo_amount'] / 100);
      echo json_encode($price - $Discount);
    }
  } else if ($row['promo_time'] !== null && $row['promo_usage'] !== null) {
    $expireDate = strtotime($row['promo_time']);
    $today = strtotime(date('Y-m-d H:i:s'));
    $usage = $row['promo_usage'];


    if ($today < $expireDate && $usage !== 0) {

      $updated_usage = intval($usage - 1);
      $update_promo = "UPDATE promo SET promo_usage = $updated_usage WHERE promo_id = '$PromoId'";
      $promo_result = mysqli_query($connection, $update_promo);
      confirm($promo_result);

      $Discount = $price * ($row['promo_amount'] / 100);
      echo json_encode($price - $Discount);
    } else {
      // The Promo code is expired
      echo json_encode("promocode expired");
    }
  }
}
if ($received_data->action == 'getData') {
  $location = $received_data->desti;
  $checkin = $received_data->checkIn;
  $checkout = $received_data->checkOut;

  $count = 0;
  $roomAcc_temp = '';
  $roomLocation = '';
  $dataCount = [];
  $A_query = "SELECT * FROM rooms WHERE room_status = 'Not_booked' AND room_location = '$location' ORDER BY room_acc";
  // $A_query = "SELECT *, COUNT(room_acc) AS cnt 
  //   FROM rooms
  //   GROUP BY room_acc
  //   HAVING room_status = 'Not_booked'
  //   AND room_location = '$location'";

  $A_result = mysqli_query($connection, $A_query);
  confirm($A_result);

  $rows = mysqli_num_rows($A_result);

  while ($row = mysqli_fetch_assoc($A_result)) {

    if ($roomAcc_temp == '') {
      $roomAcc_temp = $row["room_acc"];
      $roomLocation = $row["room_location"];
    } else if ($roomAcc_temp == $row["room_acc"]) {

      array_push($data, $row);
    } else if ($roomAcc_temp !== $row["room_acc"]) {
      $roomAcc_temp = $row["room_acc"];
      $roomLocation = $row["room_location"];
      array_push($dataCount, $data);
      $data = [];
      array_push($data, $row);
      // goto here;
    }
  }
  if (count($data) > 1) {
    array_push($dataCount, $data);
  }

  echo json_encode($dataCount);

  if (!empty($rows)) {



    while ($avaliable_rooms = mysqli_fetch_assoc($A_result)) {
      $Not_booked[] = $avaliable_rooms;
    }
    // echo json_encode($Not_booked);
    $BR_query = "SELECT DISTINCT b_roomId
      FROM booked_rooms 
      WHERE b_checkout<= '$checkin' 
      AND b_roomLocation = '$location'
      UNION
      SELECT DISTINCT b_roomId
      FROM booked_rooms
      WHERE b_checkin >= '$checkout'
      AND b_roomLocation = '$location'";
    $result = mysqli_query($connection, $BR_query);
    confirm($result);

    while ($row3 = mysqli_fetch_assoc($result)) {
      $r_query = "SELECT *, COUNT(room_acc) AS cnt 
       FROM rooms
       GROUP BY room_acc
       HAVING room_id = {$row3['b_roomId']}";
      $r_result = mysqli_query($connection, $r_query);
      confirm($r_result);

      while ($row4 = mysqli_fetch_assoc($r_result)) {
        $booked[] = $row4;
      }
    }

    $all = array_merge($Not_booked, $booked);

    echo json_encode($all);
  } else {

    $BR_query = "SELECT DISTINCT b_roomId
      FROM booked_rooms 
      WHERE b_checkout<= '$checkin' 
      AND b_roomLocation = '$location'
      UNION
      SELECT DISTINCT b_roomId
      FROM booked_rooms
      WHERE b_checkin >= '$checkout'
      AND b_roomLocation = '$location'";
    $result = mysqli_query($connection, $BR_query);
    confirm($result);

    $BR_rows = mysqli_num_rows($result);
    if (!empty($BR_rows)) {
      while ($row1 = mysqli_fetch_assoc($result)) {
        $S_query = "SELECT *, COUNT(room_acc) AS cnt 
          FROM rooms
          GROUP BY room_acc
          HAVING room_id = {$row1['b_roomId']}";

        $S_result = mysqli_query($connection, $S_query);

        confirm($S_result);

        while ($row2 = mysqli_fetch_assoc($S_result)) {
          $Not_booked[] = $row2;
        }
      }
      echo json_encode($Not_booked);
    }
  }


  // echo json_encode($filterd_data1);
}


if ($received_data->action == 'insert') {


  $_SESSION['checkIn'] = $checkIn = $received_data->checkIn;
  $_SESSION['checkOut'] = $checkOut = $received_data->checkOut;
  $_SESSION['location'] = $location = $received_data->location;
  $_SESSION['Selectedlocation'] = $location = $received_data->selectedLocation;
  $_SESSION['cart'] = $cart = $received_data->data;
  $_SESSION['total'] = $received_data->total;
  $_SESSION['rooms'] = $received_data->totalroom;
  $_SESSION['promoApp'] = false;

  foreach ($cart as $value) {
    $id = intval($value->room_id);
    $query = "UPDATE rooms SET room_status = 'Hold' WHERE room_id = $id";
    $result = mysqli_query($connection, $query);

    echo json_encode($result);
  }
}

if ($received_data->action == 'hold') {

    date_default_timezone_set('Africa/Addis_Ababa');
  $id = intval($received_data->roomID);

  $query = "UPDATE rooms SET room_status = 'Hold' WHERE room_id = $id";
  $result = mysqli_query($connection, $query);

  confirm($result);

  $name = "Room_NO_". $id;

  $after_15 = date("Y-m-d H:i:s", strtotime("now + 25 seconds"));

  $timer_query = "CREATE EVENT IF NOT EXISTS $name 
                  ON SCHEDULE AT  '$after_15' 
                  DO 
                    UPDATE rooms SET room_status = 'Not_booked' WHERE room_id = $id";
  $timer_result = mysqli_query($connection, $timer_query);

  confirm($timer_result);

  echo json_encode(confirm($timer_result));
}

if ($received_data->action == 'clearHold') {

  $id = intval($received_data->roomID);

  $query = "UPDATE rooms SET room_status = 'Not_booked' WHERE room_id = $id";
  $result = mysqli_query($connection, $query);

  echo json_encode($result);
}


if ($received_data->action == 'ClearHold') {
  $roomID = $received_data->RoomId;



  $query = "UPDATE rooms SET room_status = 'Not_booked' WHERE room_id = $roomID";
  $result = mysqli_query($connection, $query);

  echo json_encode($result);
}


if ($received_data->action == 'calculatePrice') {
  $promo = '';
  $price = 0.00;
  $dbRack    = 0.00;
  $dbWeekend = 0.00;
  $dbWeekdays = 0.00;
  $dbMember  = 0.00;
  $arrayTemp = array();

  // Single occupancy rate
  $sRack     = 0.00;
  $sWeekend  = 0.00;
  $sWeekdays = 0.00;
  $sMember = 0.00;
  $cart = $received_data->data;
  // $Bored = $received_data->dataBin;

  foreach ($cart as $val) {

    $cartRoomType = $val->room_acc;
    $ad = intval($val->adults);
    $kid = intval($val->kids);
    $teen = intval($val->teens);
    $location = $val->room_location;


    $days       = array();
    $start      = new DateTime($val->checkin);
    $end        = new DateTime($val->checkout);

    for ($date = $start; $date < $end; $date->modify('+1 day')) {
      $days[] = $date->format('l');
    }




    if ($location == 'Bishoftu') {
      $query_type = "SELECT * FROM room_type WHERE type_name = '$cartRoomType'";
      $result_type = mysqli_query($connection, $query_type);
      confirm($result_type);


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


      foreach ($days as $day) {
        if ($cartRoomType == "Loft Family Room") {
          $price += calculateLoft($kid, $teen, $dbRack, $dbMember, $promo);
        } else if ($cartRoomType == 'Presidential Suite Family Room') {
          switch ($day) {
            case 'Friday':
              $price += calculatePre($kid, $teen, $dbWeekend, $dbMember, $promo);
              break;
            case 'Saturday':
              $price += calculatePre($kid, $teen, $dbRack, $dbMember, $promo);
              break;
            default:
              // $price += doubleval($row_type['d_weekday_rate']);
              $price += calculatePre($kid, $teen, $dbWeekdays, $dbMember, $promo);
              break;
          }
        } else {
          switch ($day) {
            case 'Friday':
              $price += calculatePrice($ad, $kid, $teen, $sWeekend, $dbWeekend, $dbMember, $sMember, $promo);
              break;
            case 'Saturday':
              $price += calculatePrice($ad, $kid, $teen,  $sRack, $dbRack, $dbMember, $sMember, $promo);
              break;
            default:
              // $price += doubleval($row_type['d_weekday_rate']);
              $price += calculatePrice($ad, $kid, $teen, $sWeekdays, $dbWeekdays, $dbMember, $sMember, $promo);
              break;
          }
        }
      }
    } else if ($location == 'awash') {
      $Bored = $val->reservationBoard;
      $query_type = "SELECT * FROM awash_price WHERE name = '$cartRoomType'";
      $result_type = mysqli_query($connection, $query_type);
      confirm($result_type);

      $row_type = mysqli_fetch_assoc($result_type);
      $price = calculatePriceAwash($ad, $kid, $teen, $Bored, $days, $row_type);
    } else if ($location == 'entoto') {
      $query = "SELECT * FROM entoto_price WHERE name = '$cartRoomType'";


      $result_type = mysqli_query($connection, $query);
      confirm($result_type);


      while ($row_type = mysqli_fetch_assoc($result_type)) {
        $double = $row_type['double_occ'];
        $single = $row_type['single_occ'];
      }

      foreach ($days as $day) {
        if ($cartRoomType == "Presidential Family Room") {
          $price += calculatePreEntoto($kid, $teen, $double, $promo);
        } else {

          $price += calculateEntoto($ad, $kid, $teen, $double, $single, $promo);
        }
      }
    } else if ($location == 'Lake tana') {
      $query = "SELECT * FROM tana_price WHERE name = '$cartRoomType'";


      $result_type = mysqli_query($connection, $query);
      confirm($result_type);


      while ($row_type = mysqli_fetch_assoc($result_type)) {
        $double = $row_type['double_occ'];
        $single = $row_type['single_occ'];
      }

      foreach ($days as $day) {
        $price += calculateEntoto($ad, $kid, $teen, $double, $single, $promo);
      }
    }
    array_push($arrayTemp, $price);
    $price = 0.00;
  }

  echo json_encode($arrayTemp);
}

?>
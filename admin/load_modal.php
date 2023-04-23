<?php session_start(); ?>
<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php
// header("Content-Type: application/json"); 
// header("Access-Control-Allow-Origin: *"); 
// header("Access-Control-Allow-Methods: GET,POST,OPTIONS,DELETE,PUT"); 
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$received_data = json_decode(file_get_contents("php://input"));
date_default_timezone_set('Africa/Addis_Ababa');

$single_app_id = $_ENV['BACK_SINGLE_APP_ID'];
$single_key = $_ENV['BACK_SINGLE_KEY'];
$single_secret = $_ENV['BACK_SINGLE_SECRET'];
$single_cluster = "mt1";

$pusher = new Pusher\Pusher($single_key, $single_secret, $single_app_id, ['cluster' => $single_cluster]);

$location = $_SESSION['user_location'];
$role = $_SESSION['user_role'];
//  $location = "Boston";
//  $role = "SA";
$filterd_data = array();
$Not_booked_array = array();
$allData = array();
$dataReq = array();


if ($received_data->action == 'noRoomsAvailable') {
  $location = $received_data->location;
  $update_query = "SELECT  SUM(CASE WHEN room_status = 'booked' THEN 1 ELSE 0 END) AS booked_rooms, SUM(CASE WHEN room_status = 'Not_booked' THEN 1 ELSE 0 END) AS available_rooms FROM  rooms";
  $update_result = mysqli_query($connection, $update_query);

  // confirm($update_result);

  echo json_encode($update_result);
}

if ($received_data->action == 'fetchReqDaily') {
  $date = date('Y-m-d');
  if ($role == "SA" || ($location == "Boston" && $role == 'RA')) {
    $query = "SELECT * FROM special_request WHERE date = '$date' ORDER BY id DESC";
  } else {
    $query = "SELECT * FROM special_request WHERE location = '$location' AND date = '$date' ORDER BY id DESC";
  }

  $result = mysqli_query($connection, $query);

  $exists = mysqli_num_rows($result);

  if ($exists > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

      $dataReq[] = $row;
    }

    echo json_encode($dataReq);
  } else {
    echo json_encode("empty");
  }
}

if ($received_data->action == 'fetchReq') {
  if ($role == "SA" || ($location == "Boston" && $role == 'RA')) {
    $query = "SELECT * FROM special_request ORDER BY id DESC";
  } else {
    $query = "SELECT * FROM special_request WHERE location = '$location' ORDER BY id DESC";
  }

  $result = mysqli_query($connection, $query);

  $exists = mysqli_num_rows($result);

  if ($exists > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

      $dataReq[] = $row;
    }

    echo json_encode($dataReq);
  } else {
    echo json_encode("empty");
  }
}

if ($received_data->action == 'editSpecialRequest') {
  $id = $received_data->id;
  $guest_name = $received_data->guest;
  $type = $received_data->type;
  $otherType = $received_data->otherType;
  $nop = $received_data->num;
  $date = $received_data->date;
  $remark = $received_data->remark;
  $req_location = $received_data->location;
  $updated_by = $_SESSION['username'];

  $update_query = "UPDATE special_request SET guest_name = '$guest_name', type = '$type', other_type = '$otherType', number_of_people = $nop, location = '$req_location', date = '$date', updated_by = '$updated_by', remark = '$remark' WHERE id = $id";

  $update_result = mysqli_query($connection, $update_query);

  confirm($update_result);

  echo json_encode($update_result);
}
if ($received_data->action == 'addSpecialRequest') {

  $guest_name = $received_data->guest;
  $type = $received_data->type;
  $otherType = $received_data->otherType;
  $number_of_people = $received_data->num;
  $date = $received_data->date;
  $remark = $received_data->remark;
  $req_location = $received_data->location;
  $created_by = $_SESSION['username'];

  $query = "INSERT INTO special_request(guest_name, type, other_type, number_of_people, location, date, created_by, remark) VALUES('$guest_name', '$type', '$otherType', $number_of_people, '$req_location',  '$date', '$created_by', '$remark')";
  $result = mysqli_query($connection, $query);

  confirm($result);

  echo json_encode($result);
}

if ($received_data->action == 'deleteReq') {
  $id = intval($received_data->id);
  $query = "DELETE FROM special_request WHERE id = $id";
  $result = mysqli_query($connection, $query);

  echo json_encode($result);
}

if ($received_data->action == 'visitors') {
  $query = "SELECT 
              SUM(IF(source = 'homepage_banner', 1, 0)) AS banner,
              SUM(IF(source = 'homepage_button', 1, 0)) AS button
              FROM visitors";
  $result = mysqli_query($connection, $query);
  confirm($result);

  while ($row = mysqli_fetch_assoc($result)) {
    $banner = intval($row['banner']);
    $button = intval($row['button']);
  }
  echo json_encode([$banner, $button]);
}
if ($received_data->action == 'filter') {

  $location = $received_data->location;
  $roomType = $received_data->roomType;
  $checkin = $received_data->checkin;
  $checkout = $received_data->checkout;


  if (($checkin && $checkout) && ($location && $roomType)) {


    // $query = "SELECT * 
    // FROM rooms 
    // WHERE room_id 
    // NOT IN 
    //   ( SELECT b_roomId
    //     FROM booked_rooms 
    //     WHERE '$checkin' >= b_checkin AND '$checkin' < b_checkout 
    //     UNION
    //     SELECT b_roomId
    //     FROM booked_rooms
    //     WHERE '$checkout' >= b_checkin AND '$checkout' < b_checkout
    //     )
    // AND room_acc = '$roomType'
    // AND room_location = '$location'
    // AND room_status <> 'Hold'
    // AND room_status <> 'bishoftu_hold'";

    $query = "SELECT rooms.*
    FROM rooms
    LEFT JOIN booked_rooms
    ON rooms.room_id = booked_rooms.b_roomId
    AND (('$checkin' >= b_checkin AND '$checkin' < b_checkout)
        OR ('$checkout' > b_checkin AND '$checkout' <= b_checkout)
        OR ('$checkin' <= b_checkin AND '$checkout' >= b_checkout))
    WHERE booked_rooms.b_roomId IS NULL
    AND room_location = '$location' AND room_acc = '$roomType' AND room_status NOT IN ('Hold', 'bishoftu_hold') ORDER BY room_acc;";
  } else if (($checkin && $checkout) && !$location && !$roomType) {
    // $query = "SELECT * 
    // FROM rooms 
    // WHERE room_id 
    // NOT IN 
    //   ( SELECT b_roomId
    //     FROM booked_rooms 
    //     WHERE '$checkin' >= b_checkin AND '$checkin' < b_checkout 
    //     UNION
    //     SELECT b_roomId
    //     FROM booked_rooms
    //     WHERE '$checkout' >= b_checkin AND '$checkout' < b_checkout
    //     )
    // AND room_status <> 'Hold'
    // AND room_status <> 'bishoftu_hold'";

    $query = "SELECT rooms.*
    FROM rooms
    LEFT JOIN booked_rooms
    ON rooms.room_id = booked_rooms.b_roomId
    AND (('$checkin' >= b_checkin AND '$checkin' < b_checkout)
        OR ('$checkout' > b_checkin AND '$checkout' <= b_checkout)
        OR ('$checkin' <= b_checkin AND '$checkout' >= b_checkout))
    WHERE booked_rooms.b_roomId IS NULL
    AND room_status NOT IN ('Hold', 'bishoftu_hold') ORDER BY room_acc;";
  } else if (($checkin && $checkout) && !$location && $roomType) {
    // $query = "SELECT * 
    // FROM rooms 
    // WHERE room_id 
    // NOT IN 
    //   ( SELECT b_roomId
    //     FROM booked_rooms 
    //     WHERE '$checkin' >= b_checkin AND '$checkin' < b_checkout 
    //     UNION
    //     SELECT b_roomId
    //     FROM booked_rooms
    //     WHERE '$checkout' >= b_checkin AND '$checkout' < b_checkout
    //     )
    // AND room_acc = '$roomType'
    // AND room_status <> 'Hold'
    // AND room_status <> 'bishoftu_hold'";

    $query = "SELECT rooms.*
    FROM rooms
    LEFT JOIN booked_rooms
    ON rooms.room_id = booked_rooms.b_roomId
    AND (('$checkin' >= b_checkin AND '$checkin' < b_checkout)
        OR ('$checkout' > b_checkin AND '$checkout' <= b_checkout)
        OR ('$checkin' <= b_checkin AND '$checkout' >= b_checkout))
    WHERE booked_rooms.b_roomId IS NULL
    AND room_acc = '$roomType' AND room_status NOT IN ('Hold', 'bishoftu_hold') ORDER BY room_acc;";
  } else if (($checkin && $checkout) && $location && !$roomType) {
    // $query = "SELECT * 
    // FROM rooms 
    // WHERE room_id 
    // NOT IN 
    //   ( SELECT b_roomId
    //     FROM booked_rooms 
    //     WHERE '$checkin' >= b_checkin AND '$checkin' < b_checkout 
    //     UNION
    //     SELECT b_roomId
    //     FROM booked_rooms
    //     WHERE '$checkout' >= b_checkin AND '$checkout' < b_checkout
    //     )
    // AND room_location = '$location'
    // AND room_status <> 'Hold'
    // AND room_status <> 'bishoftu_hold'";

    $query = "SELECT rooms.*
    FROM rooms
    LEFT JOIN booked_rooms
    ON rooms.room_id = booked_rooms.b_roomId
    AND (('$checkin' >= b_checkin AND '$checkin' < b_checkout)
        OR ('$checkout' > b_checkin AND '$checkout' <= b_checkout)
        OR ('$checkin' <= b_checkin AND '$checkout' >= b_checkout))
    WHERE booked_rooms.b_roomId IS NULL
    AND room_location = '$location' AND room_status NOT IN ('Hold', 'bishoftu_hold') ORDER BY room_acc;";
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

if ($received_data->action == 'fetchAll') {
  $checkin = $received_data->checkin;
  $checkout = $received_data->checkout;

  if ($role == "SA" || ($location == "Boston" && $role == 'RA')) {
    // $query = "SELECT * FROM rooms WHERE room_status = 'Not_booked'";
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
              AND room_status <> 'Hold' 
              AND room_status <> 'bishoftu_hold' ORDER BY room_acc";
  } else {

    // $query = "SELECT * FROM rooms WHERE room_status = 'Not_booked' AND room_location = '$location'";

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
              AND room_location = '$location' 
              AND room_status <> 'Hold' 
              AND room_status <> 'bishoftu_hold'
              ORDER BY room_acc";
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

if ($received_data->action == 'freeRoom') {

  $cart = $received_data->cart;
  $res_id = $received_data->res_id;
  $roomId = $received_data->roomId;


  $res_cart = json_encode($cart);

  $update_cart_query = "UPDATE reservations SET res_cart = '{$res_cart}' WHERE res_id = $res_id";

  $update_cart_result = mysqli_query($connection, $update_cart_query);

  confirm($update_cart_result);

  $query = "UPDATE rooms SET room_status = 'Not_booked' WHERE room_id = $roomId";

  $result = mysqli_query($connection, $query);
  confirm($result);

  $delete_booked_rooms = "DELETE FROM booked_rooms WHERE b_roomId =  $roomId";
  $delete_booked_rooms_result = mysqli_query($connection, $delete_booked_rooms);

  confirm($delete_booked_rooms_result);
}

if ($received_data->action == 'addReservation') {

  $form_data      = $received_data->Form;

  $checkin        = $received_data->checkin;
  $checkout       = $received_data->checkout;
  $rooms          = $received_data->rooms;
  $price          = 0.00;
  $room_types     = array();
  $room_num       = array();
  $room_numbers   = array();
  $guests         = array();
  $cart           = array();
  $id             = 0;
  $res_location   = '';

  $last_record_query = "SELECT res_id FROM reservations ORDER BY res_id DESC LIMIT 1";

  $last_record_result = mysqli_query($connection, $last_record_query);
  confirm($last_record_result);

  $row = mysqli_fetch_assoc($last_record_result);

  if (empty($row)) {
    $reset_query = "TRUNCATE TABLE reservations";
    $reset_result = mysqli_query($connection, $reset_query);

    confirm($reset_result);
  } else {
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

  // calculate number of days
  $days       = array();
  $start      = new DateTime($checkin);
  $end        = new DateTime($checkout);

  for ($date = $start; $date < $end; $date->modify('+1 day')) {
    $days[] = $date->format('l');
  }

  $index = 0;
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
    $cart[]           = array(
      "adults" => $adults,
      "kids"   => $kids,
      "teens"  => $teens,
      "room_id" => $value->room_id,
      "room_number" => $value->room_number,
      "room_acc"   => $value->room_acc,
      "room_location"   => $value->room_location,
      "room_price"    => $value->room_price
    );

    if ($value->room_location === "awash") {

      $guest_info_query = "INSERT INTO guest_info(info_res_id, info_adults, info_kids, info_teens, info_room_id, info_room_number, info_room_acc, info_board, info_room_location) ";

      $guest_info_query .= "VALUES ($last_id, $adults, $kids, $teens, $value->room_id, '$value->room_number', '$value->room_acc', '$value->board', '$value->room_location')";
    } else {
      $guest_info_query = "INSERT INTO guest_info(info_res_id, info_adults, info_kids, info_teens, info_room_id, info_room_number, info_room_acc, info_room_location) ";

      $guest_info_query .= "VALUES ($last_id, $adults, $kids, $teens, $value->room_id, '$value->room_number', '$value->room_acc', '$value->room_location')";
    }


    $guest_info_result = mysqli_query($connection, $guest_info_query);
    confirm($guest_info_result);



    // Insert into booked table

    $booked_query = "INSERT INTO booked_rooms(b_res_id, b_roomId, b_roomType, b_roomLocation, b_checkin, b_checkout) ";
    $booked_query .= "VALUES ($last_id, $intRooms , '{$value->room_acc}', '{$value->room_location}',  '{$checkin}', '{$checkout}')";

    $booked_result = mysqli_query($connection, $booked_query);

    confirm($booked_result);

    // Update room to booked

    $update_query = "UPDATE rooms SET room_status = 'booked' WHERE room_id = $intRooms";

    $update_result = mysqli_query($connection, $update_query);
    confirm($update_result);

    switch ($value->room_location) {
      case 'Bishoftu':
        $query = "SELECT * FROM room_type WHERE type_name = '$value->room_acc'";

        $result_type = mysqli_query($connection, $query);
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
          if ($value->room_acc == "Loft Family Room") {
            $price += calculateLoft($guests[$index][1], $guests[$index][2], $dbRack, $dbMember, $form_data->res_promo);
          } else if ($value->room_acc == "Presidential Suite Family Room") {
            switch ($day) {
              case 'Friday':
                $price += calculatePre($guests[$index][1], $guests[$index][2], $dbWeekend, $dbMember, $form_data->res_promo);
                break;
              case 'Saturday':
                $price += calculatePre($guests[$index][1], $guests[$index][2], $dbRack, $dbMember, $form_data->res_promo);
                break;
              default:
                // $price += doubleval($row_type['d_weekday_rate']);
                $price += calculatePre($guests[$index][1], $guests[$index][2], $dbWeekdays, $dbMember, $form_data->res_promo);
                break;
            }
          } else {
            switch ($day) {
              case 'Friday':
                $price += calculatePrice($guests[$index][0], $guests[$index][1], $guests[$index][2], $sWeekend, $dbWeekend, $dbMember, $sMember, $form_data->res_promo);
                break;
              case 'Saturday':
                $price += calculatePrice($guests[$index][0], $guests[$index][1], $guests[$index][2], $sRack, $dbRack, $dbMember, $sMember, $form_data->res_promo);
                break;
              default:
                // $price += doubleval($row_type['d_weekday_rate']);
                $price += calculatePrice($guests[$index][0], $guests[$index][1], $guests[$index][2], $sWeekdays, $dbWeekdays, $dbMember, $sMember, $form_data->res_promo);
                break;
            }
          }
        }

        // echo json_encode($guests[$index][0]);
        // echo json_encode($guests[$index][1]);
        // echo json_encode($guests[$index][2]);
        $index++;
        break;


        // Awash pricing
      case 'awash':
        $Bored = $value->board;
        $query = "SELECT * FROM awash_price WHERE name = '$value->room_acc'";
        $result = mysqli_query($connection, $query);

        $row = mysqli_fetch_assoc($result);

        // echo json_encode("adults");
        // echo json_encode($guests[$index][0]);
        // echo json_encode("teens");
        // echo json_encode($guests[$index][1]);
        // echo json_encode("kid");
        // echo json_encode($guests[$index][2]);
        $price += calculatePriceAwash($guests[$index][0], $guests[$index][1], $guests[$index][2], $Bored, $days, $row);

        $index++;
        break;

        // Entoto pricing
      case 'entoto':
        $query = "SELECT * FROM entoto_price WHERE name = '$value->room_acc'";


        $result_type = mysqli_query($connection, $query);
        confirm($result_type);


        while ($row_type = mysqli_fetch_assoc($result_type)) {
          $double = $row_type['double_occ'];
          $single = $row_type['single_occ'];
        }

        foreach ($days as $day) {
          if ($value->room_acc == "Presidential Family Room") {
            $price += calculatePreEntoto($guests[$index][1], $guests[$index][2], $double, $form_data->res_promo);
          } else {

            $price += calculateEntoto($guests[$index][0], $guests[$index][1], $guests[$index][2], $double, $single, $form_data->res_promo);
          }
        }
        $index++;
        break;
      case 'Lake tana':
        $query = "SELECT * FROM tana_price WHERE name = '$value->room_acc'";


        $result_type = mysqli_query($connection, $query);
        confirm($result_type);


        while ($row_type = mysqli_fetch_assoc($result_type)) {
          $double = $row_type['double_occ'];
          $single = $row_type['single_occ'];
        }

        foreach ($days as $day) {
          $price += calculateEntoto($guests[$index][0], $guests[$index][1], $guests[$index][2], $double, $single, $form_data->res_promo);
        }

        $index++;
        break;

      default:
        # code...
        break;
    }
  }




  // echo json_encode($price);

  $res_confirmID   = getName(8);

  $roomIds         = json_encode($room_num);
  $roomNumbers     = json_encode($room_numbers);
  $roomTypes       = json_encode($room_types);
  $res_guests      = json_encode($guests);
  $res_cart        = json_encode($cart);

if($form_data->res_paymentStatus == 'AA Paid'){
  $random_string = bin2hex(random_bytes(5));
  $target_file = "uploads/" . $random_string ;
  $res_agent = $_SESSION['username'];
  $query = "INSERT INTO reservations(res_firstname, res_lastname, res_phone, res_email, res_guestNo, res_cart, res_groupName, res_checkin, res_checkout, res_paymentMethod, res_roomIDs, res_roomNo, res_roomType, res_location, res_specialRequest, res_agent, res_paymentStatus, res_remark, res_promo, res_extraBed, res_confirmID, res_price, upload_AA) ";

  $query .= "VALUES ('{$form_data->res_firstname}', '{$form_data->res_lastname}', '{$form_data->res_phone}', '{$form_data->res_email}', '{$res_guests}', '{$res_cart}', '{$form_data->res_groupName}', '{$checkin}', '{$checkout}', '{$form_data->res_paymentMethod}', '{$roomIds}', '{$roomNumbers}', '{$roomTypes}', '{$res_location}', '{$form_data->res_specialRequest}', '{$res_agent}', '{$form_data->res_paymentStatus}', '{$form_data->res_remark}', '{$form_data->res_promo}', 'Null', '$res_confirmID', $price, '$target_file') ";

  $result = mysqli_query($connection, $query);
  confirm($result);


  echo json_encode($target_file);
}else{
  $res_agent = $_SESSION['username'];
  $query = "INSERT INTO reservations(res_firstname, res_lastname, res_phone, res_email, res_guestNo, res_cart, res_groupName, res_checkin, res_checkout, res_paymentMethod, res_roomIDs, res_roomNo, res_roomType, res_location, res_specialRequest, res_agent, res_paymentStatus, res_remark, res_promo, res_extraBed, res_confirmID, res_price) ";

  $query .= "VALUES ('{$form_data->res_firstname}', '{$form_data->res_lastname}', '{$form_data->res_phone}', '{$form_data->res_email}', '{$res_guests}', '{$res_cart}', '{$form_data->res_groupName}', '{$checkin}', '{$checkout}', '{$form_data->res_paymentMethod}', '{$roomIds}', '{$roomNumbers}', '{$roomTypes}', '{$res_location}', '{$form_data->res_specialRequest}', '{$res_agent}', '{$form_data->res_paymentStatus}', '{$form_data->res_remark}', '{$form_data->res_promo}', 'Null', '$res_confirmID', $price) ";

  $result = mysqli_query($connection, $query);
  confirm($result);


  echo json_encode($result);
}
  
  $data = true;
  $pusher->trigger('back_notifications', 'backend_reservation', $data);
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

if ($received_data->action == 'editReservation') {

  $form_data  = $received_data->Form;
  $checkin    = $received_data->checkin;
  $checkout   = $received_data->checkout;
  $rooms      = $received_data->rooms;
  $id         = $received_data->res_id;
  $price      = 0.00;
  $room_types = array();
  $room_num   = array();
  $room_numbers = array();
  $guests = array();
  $cart   = array();
  $res_location = '';

  // calculate number of days
  $days       = array();
  $start      = new DateTime($checkin);
  $end        = new DateTime($checkout);


  $start_str = $start->format('Y-m-d H:i:s');
  $end_str = $end->format('Y-m-d H:i:s');
  // delete guest info to reenter the record from the scratch
  $guest_info_query = "DELETE FROM guest_info WHERE info_res_id = $id";
  $guest_info_result = mysqli_query($connection, $guest_info_query);
  confirm($guest_info_result);

  // delete booked rooms in that res id to reenter the record from the scratch
  $delete_booked_rooms = "DELETE FROM booked_rooms WHERE b_res_id = $id";
  $delete_booked_rooms_result = mysqli_query($connection, $delete_booked_rooms);

  confirm($delete_booked_rooms_result);


  for ($date = $start; $date < $end; $date->modify('+1 day')) {
    $days[] = $date->format('l');
  }

  $index = 0;
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
    $cart[]           = array(
      "adults" => $adults,
      "kids"   => $kids,
      "teens"  => $teens,
      "room_id" => $value->room_id,
      "room_number" => $value->room_number,
      "room_acc"   => $value->room_acc,
      "room_location"   => $value->room_location,
      "room_price"    => $value->room_price
    );

    if ($value->room_location === "awash") {
      $guest_info_query = "INSERT INTO guest_info(info_res_id, info_adults, info_kids, info_teens, info_room_id, info_room_number, info_room_acc, info_board, info_room_location) ";

      $guest_info_query .= "VALUES ($last_id, $adults, $kids, $teens, $value->room_id, '$value->room_number', '$value->room_acc', '$value->board', '$value->room_location')";
    } else {
      $guest_info_query = "INSERT INTO guest_info(info_res_id, info_adults, info_kids, info_teens, info_room_id, info_room_number, info_room_acc, info_room_location) ";

      $guest_info_query .= "VALUES ($id, $adults, $kids, $teens, $value->room_id, $value->room_number, '$value->room_acc', '$value->room_location')";
    }

    $guest_info_result = mysqli_query($connection, $guest_info_query);
    confirm($guest_info_result);



    // Insert into booked table

    $booked_query = "INSERT INTO booked_rooms(b_res_id, b_roomId, b_roomType, b_roomLocation, b_checkin, b_checkout) ";
    $booked_query .= "VALUES ($id, $intRooms , '{$value->room_acc}', '{$value->room_location}',  '{$checkin}', '{$checkout}')";

    $booked_result = mysqli_query($connection, $booked_query);

    confirm($booked_result);

    // Update room to booked

    $update_query = "UPDATE rooms SET room_status = 'booked' WHERE room_id = $intRooms";

    $update_result = mysqli_query($connection, $update_query);
    confirm($update_result);

    switch ($value->room_location) {
      case 'Bishoftu':
        $query = "SELECT * FROM room_type WHERE type_name = '$value->room_acc'";

        $result_type = mysqli_query($connection, $query);
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
          if ($value->room_acc == "Loft Family Room") {
            $price += calculateLoft($guests[$index][1], $guests[$index][2], $dbRack, $dbMember, $form_data->res_promo);
          } else if ($value->room_acc == "Presidential Suite Family Room") {
            switch ($day) {
              case 'Friday':
                $price += calculatePre($guests[$index][1], $guests[$index][2], $dbWeekend, $dbMember, $form_data->res_promo);
                break;
              case 'Saturday':
                $price += calculatePre($guests[$index][1], $guests[$index][2], $dbRack, $dbMember, $form_data->res_promo);
                break;
              default:
                // $price += doubleval($row_type['d_weekday_rate']);
                $price += calculatePre($guests[$index][1], $guests[$index][2], $dbWeekdays, $dbMember, $form_data->res_promo);
                break;
            }
          } else {
            switch ($day) {
              case 'Friday':
                $price += calculatePrice($guests[$index][0], $guests[$index][1], $guests[$index][2], $sWeekend, $dbWeekend, $dbMember, $sMember, $form_data->res_promo);
                break;
              case 'Saturday':
                $price += calculatePrice($guests[$index][0], $guests[$index][1], $guests[$index][2], $sRack, $dbRack, $dbMember, $sMember, $form_data->res_promo);
                break;
              default:
                // $price += doubleval($row_type['d_weekday_rate']);
                $price += calculatePrice($guests[$index][0], $guests[$index][1], $guests[$index][2], $sWeekdays, $dbWeekdays, $dbMember, $sMember, $form_data->res_promo);
                break;
            }
          }
        }

        // echo json_encode($guests[$index][0]);
        // echo json_encode($guests[$index][1]);
        // echo json_encode($guests[$index][2]);
        $index++;
        break;


        // Awash pricing
      case 'awash':
        $Bored = $value->board;
        $query = "SELECT * FROM awash_price WHERE name = '$value->room_acc'";
        $result = mysqli_query($connection, $query);

        $row = mysqli_fetch_assoc($result);

        // echo json_encode("adults");
        // echo json_encode($guests[$index][0]);
        // echo json_encode("teens");
        // echo json_encode($guests[$index][1]);
        // echo json_encode("kid");
        // echo json_encode($guests[$index][2]);
        $price += calculatePriceAwash($guests[$index][0], $guests[$index][1], $guests[$index][2], $Bored, $days, $row);

        $index++;
        break;

        // Entoto pricing
      case 'entoto':
        $query = "SELECT * FROM entoto_price WHERE name = '$value->room_acc'";


        $result_type = mysqli_query($connection, $query);
        confirm($result_type);


        while ($row_type = mysqli_fetch_assoc($result_type)) {
          $double = $row_type['double_occ'];
          $single = $row_type['single_occ'];
        }

        foreach ($days as $day) {
          if ($value->room_acc == "Presidential Family Room") {
            $price += calculatePreEntoto($guests[$index][1], $guests[$index][2], $double, $form_data->res_promo);
          } else {

            $price += calculateEntoto($guests[$index][0], $guests[$index][1], $guests[$index][2], $double, $single, $form_data->res_promo);
          }
        }
        $index++;
        break;
      case 'Lake tana':
        $query = "SELECT * FROM tana_price WHERE name = '$value->room_acc'";


        $result_type = mysqli_query($connection, $query);
        confirm($result_type);


        while ($row_type = mysqli_fetch_assoc($result_type)) {
          $double = $row_type['double_occ'];
          $single = $row_type['single_occ'];
        }

        foreach ($days as $day) {
          $price += calculateEntoto($guests[$index][0], $guests[$index][1], $guests[$index][2], $double, $single, $form_data->res_promo);
        }

        $index++;
        break;
    }
  }
  // echo json_encode($cart);





  // echo json_encode("Total Price");
  // echo json_encode($price);

  echo json_encode("Discount");
  echo json_encode($price);

  $res_confirmID   = getName(8);

  $roomIds         = json_encode($room_num);
  $roomNumbers     = json_encode($room_numbers);
  $roomTypes       = json_encode($room_types);
  $res_guests      = json_encode($guests);
  $res_cart        = json_encode($cart);


  $res_agent = $_SESSION['username'];
  $query = "UPDATE `reservations` SET `res_firstname` = '{$form_data->res_firstname}', `res_lastname` = '{$form_data->res_lastname}', `res_phone` = '{$form_data->res_phone}', `res_email` = '{$form_data->res_email}', `res_guestNo` = '{$res_guests}', `res_cart` = '{$res_cart}', `res_groupName` = '{$form_data->res_groupName}', `res_checkin` = '{$start_str}', `res_checkout` = '{$end_str}', `res_paymentMethod` = '{$form_data->res_paymentMethod}', `res_roomIDs` = '{$roomIds}', `res_roomNo` = '{$roomNumbers}', `res_roomType` = '{$roomTypes}', `res_location` = '{$res_location}', `res_specialRequest` = '{$form_data->res_specialRequest}', `res_agent` = '{$res_agent}', `res_paymentStatus` = '{$form_data->res_paymentStatus}', `res_remark` = '{$form_data->res_remark}', `res_promo` = '{$form_data->res_promo}', `res_extraBed` = Null, `res_confirmID` = '$res_confirmID', `res_price` = $price WHERE `reservations`.`res_id` = $id";

  $result = mysqli_query($connection, $query);
  confirm($result);
}

if ($received_data->action == 'fetchTypes') {
  $loc = $received_data->location;
  $types = array();
  if ($loc === 'Awash') {
    $query = "SELECT * FROM awash_price";
  } else if ($loc === 'Bishoftu') {
    $query = "SELECT * FROM room_type";
  } else if ($loc === 'Entoto') {
    $query = "SELECT * FROM entoto_price";
  } else if ($loc === 'Lake Tana') {
    $query = "SELECT * FROM tana_price";
  }

  $result = mysqli_query($connection, $query);
  confirm($result);

  while ($row = mysqli_fetch_assoc($result)) {
    $types[] = $row;
  }

  echo json_encode($types);
}

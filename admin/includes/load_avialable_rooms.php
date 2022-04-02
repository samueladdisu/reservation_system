<?php ob_start(); ?>
<?php include  './db.php'; ?>
<?php include  './functions.php'; ?>
<?php session_start(); ?>

<?php

$received_data = json_decode(file_get_contents("php://input"));

$filterd_data = array();
$allData = array();

$user_location = $_SESSION['user_location'];
$user_role = $_SESSION['user_role'];

if($received_data->action == 'amt'){

  $_SESSION['amt'] = $received_data->data;
  echo json_encode($received_data->data);
}

if ($received_data->action == 'filter') {
  $location = $received_data->location;
  $roomType = $received_data->roomType;
  $checkin = $received_data->checkin;
  $checkout = $received_data->checkout;


  if(($checkin && $checkout) && ($location && $roomType) ){

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

  }else if(($checkin && $checkout) && !($location && $roomType)){

    $query = "SELECT DISTINCT b_roomId
    FROM booked_rooms 
    WHERE b_checkout<= '$checkin' 
    UNION
    SELECT DISTINCT b_roomId
    FROM booked_rooms
    WHERE b_checkin >= '$checkout'";

  }else if(($checkin && $checkout) && !$location && $roomType){
    $query = "SELECT DISTINCT b_roomId 
    FROM booked_rooms 
    WHERE b_checkout<= '$checkin' 
    AND b_roomType = '$roomType'
    UNION
    SELECT DISTINCT b_roomId
    FROM booked_rooms
    WHERE b_checkin >= '$checkout'
    AND b_roomType = '$roomType'";
  }else if(($checkin && $checkout) && $location && !$roomType){
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

  if($exists){
    while($row = mysqli_fetch_assoc($result)){
  
      if($location && $roomType){
      $select_room_query = "SELECT * 
      FROM rooms 
      WHERE room_id = {$row['b_roomId']}
      UNION
      SELECT * 
      FROM rooms
      WHERE room_status = 'Not_booked'
      AND room_location = '$location'
      AND room_acc = '$roomType'";
      }else if($location && !$roomType){
        $select_room_query = "SELECT * 
        FROM rooms 
        WHERE room_id = {$row['b_roomId']}
        UNION
        SELECT * 
        FROM rooms
        WHERE room_status = 'Not_booked'
        AND room_location = '$location'";
      }else if(!$location && $roomType){
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
      while($row2 = mysqli_fetch_assoc($select_room_result)){
    
        $filterd_data[] = $row2;
      }
    }
    echo json_encode($filterd_data);

  }else{
      if($location && $roomType){
      $ava_query = "SELECT * 
      FROM rooms 
      WHERE room_status = 'Not_booked' 
      AND room_location = '$location'
      AND room_acc = '$roomType'";
    }else if($location && !$roomType){
      $ava_query = "SELECT * 
      FROM rooms 
      WHERE room_status = 'Not_booked' 
      AND room_location = '$location'";
    }else if(!$location && $roomType){
      $ava_query = "SELECT *
      FROM rooms
      WHERE room_status = 'Not_booked'
      AND room_acc = '$roomType'";
    }
    $ava_result = mysqli_query($connection, $ava_query);
    confirm($ava_result);
    while($row_ava = mysqli_fetch_assoc($ava_result)){
    
      $filterd_data[] = $row_ava;
    }
    echo json_encode($filterd_data);
  }
  

}


if($received_data->action == 'fetchAllRoom'){

  if ($_SESSION['user_role'] == 'SA' || ($_SESSION['user_location'] == 'Boston' && $_SESSION['user_role'] == 'RA')){
    $query = "SELECT * FROM rooms";
  }else{
    $query = "SELECT * FROM rooms WHERE room_location = '$user_location'";
  }
  $result = mysqli_query($connection, $query);
  confirm($result);
  while ($row = mysqli_fetch_assoc($result)) {
    $allData[] = $row;
  }

  echo json_encode($allData);
}

if ($received_data->action  == "delete") {
  $room_id = $received_data->row->room_id;

  $query = "DELETE FROM rooms WHERE room_id = $room_id";
  $result = mysqli_query($connection, $query);

  confirm($result);

 
}
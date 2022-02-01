<?php session_start(); ?>
<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php

$received_data = json_decode(file_get_contents("php://input"));

$filterd_data = array();
$allData = array();
if ($received_data->action == 'update') {

  $_SESSION['checkboxarray'] = $received_data->data;
  foreach ($received_data->data as $checkBoxValue) {


    $query = "UPDATE rooms SET room_status = 'booked' WHERE room_id = $checkBoxValue";
    $result = mysqli_query($connection, $query);
    confirm($result);
  }
}

if ($received_data->action == 'reserve') {

  $_SESSION['checkboxarray'] = $received_data->data;
  foreach ($received_data->data as $checkBoxValue) {


    $query = "UPDATE rooms SET room_status = 'reserved' WHERE room_id = $checkBoxValue";
    $result = mysqli_query($connection, $query);
    confirm($result);
  }
}

if ($received_data->action == 'filter') {
  $location = $received_data->location;
  $roomType = $received_data->roomType;

  if($location && $roomType){
    $query = "SELECT * FROM rooms WHERE room_status = 'Not_booked' AND room_location = '$location' AND room_acc = '$roomType'";
  }else if(!$location && $roomType){
    $query = "SELECT * FROM rooms WHERE room_status = 'Not_booked' AND room_acc = '$roomType'";
  }else if($location && !$roomType){
    $query = "SELECT * FROM rooms WHERE room_status = 'Not_booked' AND room_location = '$location'";
  }
 
  $result = mysqli_query($connection, $query);
  confirm($result);
  while ($row = mysqli_fetch_assoc($result)) {
    $filterd_data[] = $row;
  }

  echo json_encode($filterd_data);
}

if ($received_data->action == 'fetchAll') {
  $query = "SELECT * FROM rooms WHERE room_status = 'Not_booked'";
  $result = mysqli_query($connection, $query);
  confirm($result);
  while ($row = mysqli_fetch_assoc($result)) {
    $allData[] = $row;
  }

  echo json_encode($allData);
}



?>
<?php ob_start(); ?>
<?php include  './db.php'; ?>
<?php include  './functions.php'; ?>
<?php session_start(); ?>
<?php
  
$incoming = json_decode(file_get_contents("php://input"));
$location = $_SESSION['user_location'];
$data = array();
$filterd_data = array();
if($incoming->action == 'fetchRes'){
  if($location == "admin"){
    $query = "SELECT * FROM reservations ORDER BY res_id DESC";
  } else {
    $query = "SELECT * FROM reservations WHERE res_location = '$location' ORDER BY res_id DESC";
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

  if($location && $date){
    $query = "SELECT * FROM reservations WHERE res_location = '$location' AND res_checkin = '$date'";
  }else if(!$location && $date){
    $query = "SELECT * FROM reservations WHERE res_checkin = '$date'";
  }else if($location && !$date){
    $query = "SELECT * FROM reservations WHERE res_location = '$location'";
  }
 
  $result = mysqli_query($connection, $query);
  confirm($result);
  while ($row = mysqli_fetch_assoc($result)) {
    $filterd_data[] = $row;
  }

  echo json_encode($filterd_data);
}

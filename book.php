<?php session_start(); ?>
<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php 

$received_data = json_decode(file_get_contents("php://input"));

$data = array();
$output = array();

if($received_data->action == 'fetchall'){

  $query = "SELECT * FROM rooms WHERE room_status = 'Not_booked' ";
  $result = mysqli_query($connection, $query);

  confirm($result);
  while($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
  }

  echo json_encode($data);
}


if($received_data->action == 'getData'){
  $data = array(
    ':checkIn' => $received_data->checkIn,
    ':checkOut' => $received_data->checkOut,
    ':desti' => $received_data->desti
  );

  $query = "SELECT * FROM rooms WHERE room_status = 'Not_booked' AND room_location = '$received_data->desti' ";
  $result = mysqli_query($connection, $query);
  confirm($result);

  while($row = mysqli_fetch_assoc($result)){
    $output[] = $row;
  }

  
  echo json_encode($output);

}

if($received_data->action == 'insert'){

  $_SESSION['checkIn'] = $checkIn = $received_data->checkIn;
  $_SESSION['checkOut'] = $checkOut = $received_data->checkOut;
  $_SESSION['cart'] = $cart = $received_data->data;


}

?>
<?php session_start(); ?>
<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php 

$received_data = json_decode(file_get_contents("php://input"));

$data = array();
$output = array();

if($received_data->action == 'fetchall'){

  // $query = "SELECT * FROM rooms WHERE room_status = 'Not_booked'";
  // $query = "SELECT * FROM rooms GROUP BY room_acc";
  $query2 = "SELECT *, COUNT(room_acc) AS cnt FROM rooms GROUP BY room_acc HAVING room_status = 'Not_booked';";
  // $result = mysqli_query($connection, $query);
  $result2 = mysqli_query($connection, $query2);

  // confirm($result);
  confirm($result2);
  while($row = mysqli_fetch_assoc($result2)){
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
  $_SESSION['location'] = $location = $received_data->location;
  $_SESSION['cart'] = $cart = $received_data->data;
  $_SESSION['total'] = $received_data->total;
  $_SESSION['rooms'] = $received_data->totalroom;

}

?>
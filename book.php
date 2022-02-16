<?php include  'config.php'; ?>
<?php 

$received_data = json_decode(file_get_contents("php://input"));

$data = array();
$output = array();

if($received_data->action == 'fetchall'){

  // $query2 = "SELECT * FROM rooms WHERE room_status = 'Not_booked'";
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

if($received_data->action == 'promoCode'){
  $code = $received_data->data;
  $promoData = array();
  $promo_query = "SELECT * FROM promo WHERE promo_code = '$code' ";
  $promo_result = mysqli_query($connection, $promo_query);

  confirm($promo_result);

  while($row = mysqli_fetch_assoc($promo_result)){
    foreach ($row as $key => $value) {
      $params[$key] = $value;
    }
  }

  echo json_encode($params['promo_amount']);

}
if($received_data->action == 'getData'){
  
  // $sql = "SELECT * FROM reservations r1 , reservations r2 WHERE r1.res_checkout <= '$received_data->checkIn' AND r2.res_checkin >= '$received_data->checkOut' AND r1.res_id = r2.res_id";
  $sql = "SELECT * FROM reservations r1 , reservations r2 WHERE r1.res_checkout <= '$received_data->checkIn' AND r2.res_checkin >= '$received_data->checkOut'";

  $res_result = mysqli_query($connection, $sql);
  
  confirm($res_result);
 
  while($row = mysqli_fetch_assoc($res_result)){
    $output[] = $row['res_id'];
  }
  echo json_encode($output);

  // echo json_encode(confirm($res_result));

  // $query2 = "SELECT *, COUNT(room_acc) AS cnt FROM rooms GROUP BY room_acc HAVING room_status = 'Not_booked' AND room_location = '$received_data->desti';";

  // // $query = "SELECT * FROM rooms WHERE room_status = 'Not_booked' AND room_location = '$received_data->desti' ";
  // $result = mysqli_query($connection, $query2);
  // confirm($result);

  // while($row = mysqli_fetch_assoc($result)){
  //   $output[] = $row;
  // }

  

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
<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php 

$reseived_data = json_decode(file_get_contents("php://input"));

$data = array();

if($reseived_data->action == 'fetchall'){
  $query = "SELECT * FROM rooms WHERE room_status = 'Not_booked' AND  room_location = '$reseived_data->desti' ";
  $result = mysqli_query($connection,$query);
  confirm($result);

    
  while ($row = mysqli_fetch_array($result)) {
   $data[] = $row;


  }
  echo json_encode($data);
}







?>
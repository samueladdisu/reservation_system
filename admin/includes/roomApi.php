<?php ob_start(); ?>
<?php include  './db.php'; ?>
<?php include  './functions.php'; ?>
<?php session_start(); ?>

<?php



$request = json_decode(file_get_contents("php://input"));


$user_location = $_SESSION['user_location'];
$data = array();
$filtered_data = array();

if($request->action == 'addUser'){
  
}
if($request->action == 'delete'){
  $room_id = $request->row->room_id;

  $query = "DELETE FROM rooms WHERE room_id = $room_id";

  $delete_result = mysqli_query($connection, $query);
  confirm($delete_result);

}

if($request->action == 'date'){
  $date = $request->date;

  $query = "SELECT * 
  FROM rooms 
  WHERE room_checkin = '$date'";

  $result = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_assoc($result)){
    $filtered_data[] = $row;
  }

  echo json_encode($filtered_data);
}
if($request->action == 'filter'){
  $location = $request->location;
  $date = $request->date;
  $roomType= $request->roomType;
  $available = $request->available;

  $query = "SELECT * FROM rooms WHERE room_location = '$location' OR room_acc = '$roomType' OR room_status = '$available'";

  $result = mysqli_query($connection, $query);
  confirm($result);
  while ($row = mysqli_fetch_assoc($result)){
    $filtered_data[] = $row;
  }

  echo json_encode($filtered_data);
}

if($request->action == 'available'){
  $available = $request->available;

  $query = "SELECT * FROM rooms WHERE room_status = '$available'";

  $result = mysqli_query($connection, $query);
  confirm($result);
  while ($row = mysqli_fetch_assoc($result)){
    $filtered_data[] = $row;
  }

  echo json_encode($filtered_data);

}

if($request->action == 'location'){
  $location = $request->location;

  $query = "SELECT * FROM rooms WHERE room_location = '$location'";

  $result = mysqli_query($connection, $query);
  confirm($result);
  while ($row = mysqli_fetch_assoc($result)){
    $filtered_data[] = $row;
  }

  echo json_encode($filtered_data);
}

if($request->action == 'roomType'){
  $roomType = $request->roomType;

  $query = "SELECT * FROM rooms WHERE room_acc = '$roomType'";

  $result = mysqli_query($connection, $query);
  confirm($result);
  while ($row = mysqli_fetch_assoc($result)){
    $filtered_data[] = $row;
  }

  echo json_encode($filtered_data);
}

if($request->action == 'fetchRooms'){

  if($user_location == 'admin'){
    $query = "SELECT * FROM rooms";
  }else{
    $query = "SELECT * FROM rooms WHERE room_location = '$user_location'";

  }
  $result = mysqli_query($connection, $query);

  confirm($result);

  while($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
  }

  echo json_encode($data);
}

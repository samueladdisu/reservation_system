<?php 

include  'config.php';

$roomIDs = array();
$today = date('Y-m-d');
  
$back_query = "SELECT b_roomId FROM booked_rooms WHERE b_checkout < '$today'";

$back_result = mysqli_query($connection, $back_query);

while($row = mysqli_fetch_assoc($back_result)) {
  foreach ($row as $key => $value) {
    # code...
    // echo $key . "=>". $value . "<br>";

    $roomIDs[] = intval($value);
  }
}

// var_dump($roomIDs);
echo "<br>";

foreach ($roomIDs as $val) {
  $front_query = "SELECT * FROM booked_rooms WHERE b_checkout > '$today' AND b_roomID = $val";
  $front_result = mysqli_query($connection, $front_query);
  $num_row = mysqli_num_rows($front_result);


  if($num_row === 0){
    echo "Not_booked".$val . "<br>";

    // $realse_room = "UPDATE rooms SET room_status = 'Not_booked' WHERE room_id = $val";
    // $realse_result = mysqli_query($connection, $realse_room);
    // confirm($realse_result);
  }else {
    echo "booked". $val . "<br>";;
  }
}








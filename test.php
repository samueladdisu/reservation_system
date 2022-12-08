<?php 

require __DIR__ . '/vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
function confirm($result)
{

  global $connection;
  if (!$result) {
    die('QUERY FAILED ' . mysqli_error($connection));
  }
}

$db_username = $_ENV['DB_USERNAME'];
$db_pwd = $_ENV['DB_PASSWORD'];
$db_name = $_ENV['DB_NAME'];

$connection = mysqli_connect('localhost', $db_username, $db_pwd, $db_name);
// $connection = mysqli_connect('localhost', 'root', '', 'lalibela');

if (!$connection) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$free_hold = "UPDATE rooms SET room_status = 'Not_booked' WHERE room_status = 'Hold'";

$free_hold_result = mysqli_query($connection, $free_hold);

confirm($free_hold_result);


$roomIDs = array();
echo "Today ". $today = date('Y-m-d') . "<br>";
  
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
    echo "Must be Not booked".$val . "<br>";

    $realse_room = "UPDATE rooms SET room_status = 'Not_booked' WHERE room_id = $val";
    $realse_result = mysqli_query($connection, $realse_room);
    confirm($realse_result);
  }else {
    echo "booked". $val . "<br>";;
  }
}








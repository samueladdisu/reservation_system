<?php


// require __DIR__ . '/vendor/autoload.php';


// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();
// function confirm($result)
// {

//   global $connection;
//   if (!$result) {
//     die('QUERY FAILED ' . mysqli_error($connection));
//   }
// }

// $db_username = $_ENV['DB_USERNAME'];
// $db_pwd = $_ENV['DB_PASSWORD'];
// $db_name = $_ENV['DB_NAME'];

// $connection = mysqli_connect('localhost', $db_username, $db_pwd, $db_name);
// // $connection = mysqli_connect('localhost', 'root', '', 'lalibela');

// if (!$connection) {
//     echo "Error: Unable to connect to MySQL." . PHP_EOL;
//     echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
//     echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
//     exit;
// }

// $rooms = [106, 107, 121, 122, 125, 126, 548, 549, 552, 532, 535, 536, 537, 538, 547, 550, 554, 555, 558, 217, 218, 224, 225, 232];

// echo count($rooms);

// for ($i = 0; $i < count($rooms); $i++) {
//     echo "$rooms[$i]". "<br>";

//     $query = "UPDATE rooms SET room_status = 'Not_booked' WHERE room_number = $rooms[$i] AND room_location = 'bishoftu'";
//     $result = mysqli_query($connection, $query);
//     confirm($result);

//     // echo $result;
// }

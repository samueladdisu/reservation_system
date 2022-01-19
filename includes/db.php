<?php
$connection = mysqli_connect('localhost','versavvymediacom_res','DlsIV!sw!?Ka','versavvymediacom_res');
// $connection = mysqli_connect('localhost','root','','lalibela');

if (!$connection) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}



?>
<?php session_start(); ?>
<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php 


$cart = array();
$new = array();
$res_query = "SELECT res_cart FROM reservations WHERE res_id = 331";

$res_result = mysqli_query($connection, $res_query);
confirm($res_result);

 while($row = mysqli_fetch_assoc($res_result)){
   $ecoded = unserialize($row['res_cart']);
   
 }

 print_r($ecoded);
// print_r($new);
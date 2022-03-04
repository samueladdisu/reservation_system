<?php include  'config.php'; ?>
<?php 

$received_data = json_decode(file_get_contents("php://input"));

$data = array();
$output = array();
$filterd_data1 = array();
$filterd_data2 = array();
$Not_booked = array();
$booked = array();


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
  $promo_query = "SELECT * FROM promo WHERE promo_code = '$code'";
  $promo_result = mysqli_query($connection, $promo_query);

  confirm($promo_result);

  while($row = mysqli_fetch_assoc($promo_result)){
    foreach ($row as $key => $value) {
      $params[$key] = $value;
    }
    date_default_timezone_set('Africa/Addis_Ababa');
    $current_date = date('m/d/Y h:i:s', time());

    if($params['promo_time'] > $current_date && $params['promo_usage'] > 0){
      $updated_usage = $params['promo_usage'] - 1;
      $update_promo = "UPDATE promo SET promo_usage = $updated_usage WHERE promo_id = {$params['promo_id']}";

      $update_promo_result = mysqli_query($connection, $update_promo);
      confirm($update_promo_result);
      echo json_encode($params['promo_amount']);
    }else{
      echo json_encode(false);
    }
  }

  

}
if($received_data->action == 'getData'){
  $location = $received_data->desti;
  $checkin = $received_data->checkIn;
  $checkout = $received_data->checkOut;

 
  $A_query = "SELECT *, COUNT(room_acc) AS cnt 
    FROM rooms
    GROUP BY room_acc
    HAVING room_status = 'Not_booked'
    AND room_location = '$location'";

    $A_result = mysqli_query($connection, $A_query);
    confirm($A_result);

    $rows = mysqli_num_rows($A_result);

    
    if (!empty($rows)) {

      
    
      while ($avaliable_rooms = mysqli_fetch_assoc($A_result)) {
        $Not_booked[] = $avaliable_rooms;

      }
      // echo json_encode($Not_booked);
      $BR_query = "SELECT DISTINCT b_roomId
      FROM booked_rooms 
      WHERE b_checkout<= '$checkin' 
      AND b_roomLocation = '$location'
      UNION
      SELECT DISTINCT b_roomId
      FROM booked_rooms
      WHERE b_checkin >= '$checkout'
      AND b_roomLocation = '$location'";
      $result = mysqli_query($connection, $BR_query);
      confirm($result);

      while($row3 = mysqli_fetch_assoc($result)){
       $r_query = "SELECT *, COUNT(room_acc) AS cnt 
       FROM rooms
       GROUP BY room_acc
       HAVING room_id = {$row3['b_roomId']}";
       $r_result = mysqli_query($connection, $r_query);
       confirm($r_result);

       while($row4 = mysqli_fetch_assoc($r_result)){
          $booked[] = $row4;
         
        }
      }
      
      $all = array_merge($Not_booked, $booked);

     echo json_encode($all);

    } else {

      $BR_query = "SELECT DISTINCT b_roomId
      FROM booked_rooms 
      WHERE b_checkout<= '$checkin' 
      AND b_roomLocation = '$location'
      UNION
      SELECT DISTINCT b_roomId
      FROM booked_rooms
      WHERE b_checkin >= '$checkout'
      AND b_roomLocation = '$location'";
      $result = mysqli_query($connection, $BR_query);
      confirm($result);

      $BR_rows = mysqli_num_rows($result);
      if(!empty($BR_rows)){
        while($row1 = mysqli_fetch_assoc($result)){
          $S_query = "SELECT *, COUNT(room_acc) AS cnt 
          FROM rooms
          GROUP BY room_acc
          HAVING room_id = {$row1['b_roomId']}";
          
          $S_result = mysqli_query($connection, $S_query);

          confirm($S_result);

          while($row2 = mysqli_fetch_assoc($S_result)){
            $Not_booked[] = $row2;
          }
        }
        echo json_encode($Not_booked);
      }
    }


  // echo json_encode($filterd_data1);
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

<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php

$received_data = json_decode(file_get_contents("php://input"));
date_default_timezone_set('Africa/Addis_Ababa');

// if ($received_data->action == 'filter') {

//   $room_quantity_array = array();
//   $filterd_data = array();
//   $location = $received_data->location;
//   $roomType = $received_data->roomType;
//   $checkin = $received_data->checkin;
//   $checkout = $received_data->checkout;
//   // $roomQuantity = $received_data->roomQuantity;

//   if (($checkin && $checkout) && ($location && $roomType)) {



//     $query = "SELECT * 
//     FROM rooms 
//     WHERE room_id 
//     NOT IN 
//       ( SELECT b_roomId
//         FROM booked_rooms 
//         WHERE '$checkin'
//         BETWEEN b_checkin AND b_checkout 
//         UNION
//         SELECT b_roomId
//         FROM booked_rooms
//         WHERE '$checkout'
//         BETWEEN b_checkin AND b_checkout
//         )
//     AND room_acc = '$roomType'
//     AND room_location = '$location' LIMIT $roomQuantity";

//   } else if (($checkin && $checkout) && !$location && !$roomType) {
//     $query = "SELECT * 
//     FROM rooms 
//     WHERE room_id 
//     NOT IN 
//       ( SELECT b_roomId
//         FROM booked_rooms 
//         WHERE '$checkin'
//         BETWEEN b_checkin AND b_checkout 
//         UNION
//         SELECT b_roomId
//         FROM booked_rooms
//         WHERE '$checkout'
//         BETWEEN b_checkin AND b_checkout
//         )
//     LIMIT $roomQuantity";

//   } else if (($checkin && $checkout) && !$location && $roomType) {
//     $query = "SELECT * 
//     FROM rooms 
//     WHERE room_id 
//     NOT IN 
//       ( SELECT b_roomId
//         FROM booked_rooms 
//         WHERE '$checkin'
//         BETWEEN b_checkin AND b_checkout 
//         UNION
//         SELECT b_roomId
//         FROM booked_rooms
//         WHERE '$checkout'
//         BETWEEN b_checkin AND b_checkout
//         )
//     AND room_acc = '$roomType' LIMIT $roomQuantity";

//   } else if (($checkin && $checkout) && $location && !$roomType) {
//     $query = "SELECT * 
//     FROM rooms 
//     WHERE room_id 
//     NOT IN 
//       ( SELECT b_roomId
//         FROM booked_rooms 
//         WHERE '$checkin'
//         BETWEEN b_checkin AND b_checkout 
//         UNION
//         SELECT b_roomId
//         FROM booked_rooms
//         WHERE '$checkout'
//         BETWEEN b_checkin AND b_checkout
//         )
//     AND room_location = '$location' LIMIT $roomQuantity";
//   }

//   $result = mysqli_query($connection, $query);
//   confirm($result);

//   $exists = mysqli_num_rows($result);

//   if ($exists > 0) {
//     while ($row = mysqli_fetch_assoc($result)) {
//       $filterd_data[] = $row;
//     }
//     echo json_encode($filterd_data);
//   } else {
//     echo json_encode("empty");
//   }
// }

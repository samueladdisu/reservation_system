<?php
    foreach ($_POST as $name => $value) {
      $params[$name] = escape($value);
      $_SESSION[$name] = escape($value);
    }
    if (isset($_POST['res_guestNo'])) {
      if ($_SESSION["promoApp"] == false) {
        $total_price = cutFromPromo($_POST['res_guestNo'], $total_price);
        $_SESSION['total'] = "$total_price";
        $_SESSION["promoApp"] = true;
      }
    }
    if ($params['res_paymentMethod'] == 'arrival') {     
      $firstDate = new DateTime($checkIn);
      $today = new DateTime();
      $diff = $firstDate->diff($today);
      $days = $diff->days;

      if ($days < 5) {
        echo "<script> alert('You can\'t reserve less than 5 days in advance');</script>";
      } else {

        foreach ($id  as $value) {

          //  Select room details from room id 

          $room_query = "SELECT room_acc, room_location FROM rooms WHERE room_id = $value";

          $room_result = mysqli_query($connection, $room_query);
          confirm($room_result);
          $room_row = mysqli_fetch_assoc($room_result);


          // Insert into booked table

          $booked_query = "INSERT INTO booked_rooms(b_roomId, b_roomType, b_roomLocation, b_checkin, b_checkout) ";
          $booked_query .= "VALUES ($value, '{$room_row['room_acc']}', '{$room_row['room_location']}',  '{$checkIn}', '{$checkOut}')";

          $booked_result = mysqli_query($connection, $booked_query);

          confirm($booked_result);
        }
        $query = "INSERT INTO reservations(res_firstname, res_lastname, res_phone, res_email, res_checkin, res_checkout, res_country, res_address, res_city, res_zipcode, res_paymentMethod, res_roomIDs, res_price, res_location, res_confirmID, res_specialRequest, 	res_agent) ";
        $query .= "VALUES('{$params['res_firstname']}', '{$params['res_lastname']}', '{$params['res_phone']}', '{$params['res_email']}', '$checkIn', '$checkOut', '{$params['res_country']}', '{$params['res_address']}', '{$params['res_city']}', '{$params['res_zip']}', '{$params['res_paymentMethod']}', '$id_sql', '{$total_price}', '{$location}', '{$res_confirmID}', '{$params['res_specialRequest']}', 'website') ";

        $result = mysqli_query($connection, $query);
        confirm($result);


        $status_query = "UPDATE `rooms` SET `room_status` = 'booked' WHERE `room_id` IN ($id_int)";
        $result_status = mysqli_query($connection, $status_query);
        confirm($result_status);
        $data = true;

        $pusher->trigger('front_notifications', 'front_reservation', $data);
        header("Location: ./session_destory.php");
      }
    } else {

      foreach ($id  as $value) {

        //  Select room details from room id 


        $room_query = "SELECT room_acc, room_location FROM rooms WHERE room_id = $value";

        $room_result = mysqli_query($connection, $room_query);
        confirm($room_result);
        $room_row = mysqli_fetch_assoc($room_result);
        // Insert into booked table

        $booked_query = "INSERT INTO booked_rooms(b_roomId, b_roomType, b_roomLocation, b_checkin, b_checkout) ";
        $booked_query .= "VALUES ($value, '{$room_row['room_acc']}', '{$room_row['room_location']}',  '{$checkIn}', '{$checkOut}')";

        $booked_result = mysqli_query($connection, $booked_query);

        confirm($booked_result);
      }

      $query = "INSERT INTO reservations(res_firstname, res_lastname, res_phone, res_email, res_checkin, res_checkout, res_country, res_address, res_city, res_zipcode, res_paymentMethod, res_roomIDs, res_price, res_location, res_confirmID, res_specialRequest, res_guestNo, 	res_agent) ";
      $query .= "VALUES('{$params['res_firstname']}', '{$params['res_lastname']}', '{$params['res_phone']}', '{$params['res_email']}', '$checkIn', '$checkOut', '{$params['res_country']}', '{$params['res_address']}', '{$params['res_city']}', '{$params['res_zip']}', '{$params['res_paymentMethod']}', '$id_sql', '{$total_price}', '{$location}', '{$res_confirmID}', '{$params['res_specialRequest']}', '{$params['res_guestNo']}', 'website') ";

      $result = mysqli_query($connection, $query);
      confirm($result);


      $status_query = "UPDATE `rooms` SET `room_status` = 'booked' WHERE `room_id` IN ($id_int)";
      $result_status = mysqli_query($connection, $status_query);
      confirm($result_status);


      switch ($params['res_paymentMethod']) {
        case 'amole':
          header("Location: ./amole.php");
          break;
        case 'paypal':
          header("Location: ./paypal.php");
          break;
        case 'telebirr':
          header("Location: ./telebirr.php");
          break;
      }

      // pusher trigger notification

      $data = array($params, $id);
      $data = true;

      $pusher->trigger('front_notifications', 'front_reservation', $data);

      // end

    }
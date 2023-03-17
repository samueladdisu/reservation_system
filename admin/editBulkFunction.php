<?php

if ($received_data->action === 'EditBulkRes') {

    $checkin = $received_data->checkin;
    $checkout = $received_data->checkout;
    $rooms = $received_data->rooms;
    $form = $received_data->form;
    $reason = $received_data->form->group_reason;
    $location =  $received_data->location;
    $OldId = $received_data->GID;
    $created_at = date('Y-m-d H:i:s');
  
    $placement = [];
    $gustNum = $form->group_GNum;
    $TeaB = $form->group_TeaBreak ? $form->group_TeaBreak : 0;
    $BBQ = $form->group_BBQ;
    $Dineer = $form->group_Dinner;
    $LunchNum  = $form->group_Lunch;
    $status = $form->group_status;
    $group_rooms = json_encode($rooms);
    $Roomquantity = count($rooms);
  
    $WeekDaysrakRate = 0.00;
    $WeekEndsrakRate = 0.00;
    $breakfast = 0.00;
    $extraBed = 0.00;
    $teaBreak = 0.00;
    $LunchBBQ = 0.00;
  
  
    $price = 0.00;
    // calculate number of days
    $days       = array();
    $start      = new DateTime($checkin);
    $end        = new DateTime($checkout);
  
    for ($date = $start; $date < $end; $date->modify('+1 day')) {
      $days[] = $date->format('l');
    }
  
    $last_record_query = "SELECT group_id FROM group_reservation ORDER BY group_id DESC LIMIT 1";
  
    $last_record_result = mysqli_query($connection, $last_record_query);
    confirm($last_record_result);
  
    $row = mysqli_fetch_assoc($last_record_result);
  
    if (empty($row)) {
      $reset_table = "TRUNCATE TABLE group_reservation";
      $reset_result = mysqli_query($connection, $reset_table);
  
      confirm($reset_result);
      $id = 0;
    } else {
      foreach ($row as $value) {
  
        $reset_auto_increment = "ALTER TABLE group_reservation AUTO_INCREMENT = $value";
        $result = mysqli_query($connection, $reset_auto_increment);
        confirm($result);
  
        $last_record_query = "SELECT group_id FROM group_reservation ORDER BY group_id DESC LIMIT 1";
  
        $last_record_result = mysqli_query($connection, $last_record_query);
        confirm($last_record_result);
  
        $row = mysqli_fetch_assoc($last_record_result);
  
        foreach ($row as $val) {
          $id = $val;
        }
      }
    }
  
  
    $last_id = $id + 1;
  
    foreach ($rooms as $value) {
      $int_roomId = intval($value->room_number);
      $room_num   = intval($value->g_room_number );
      $group_location     = $value->room_location;
  
      // Insert into booked table
  
      $booked_query = "INSERT INTO booked_rooms(b_group_res_id, b_roomId, b_roomType, b_roomLocation, b_checkin, b_checkout) ";
      $booked_query .= "VALUES ($last_id, $int_roomId , '{$value->room_acc}', '{$value->room_location}',  '{$checkin}', '{$checkout}')";
  
      $booked_result = mysqli_query($connection, $booked_query);
  
      confirm($booked_result);
  
      // Update room to booked
  
      $update_query = "UPDATE rooms SET room_status = 'booked' WHERE room_id = $int_roomId";
  
      $update_result = mysqli_query($connection, $update_query);
      confirm($update_result);
  
      $group_query = "INSERT INTO group_rooms(g_res_id, g_room_id, g_room_acc, g_room_number, g_room_location) ";
  
      $group_query .= "VALUES ($last_id, $int_roomId, '{$value->room_acc}', $room_num, '{$value->room_location}')";
  
      $group_result = mysqli_query($connection, $group_query);
  
      confirm($group_result);
    }
  
    if ($status == 'def') {
  
  
      if ($Roomquantity == $gustNum) {
  
        for ($sta = 0; $sta < $Roomquantity; $sta++) {
  
          array_push($placement, 1);
        }
      } else if ($Roomquantity < $gustNum) {
        $doubleRooms = $gustNum - $Roomquantity;
  
        for ($sta = 0; $sta < $Roomquantity; $sta++) {
          array_push($placement, 1);
        }
  
        if ($doubleRooms > $Roomquantity) {
          $ThirdRooms = $doubleRooms - $Roomquantity;
  
          for ($i = 0; $i <  $Roomquantity; $i++) {
  
            $group = 2;
          }
  
          for ($i = 0; $i <  $ThirdRooms; $i++) {
  
            $placement[$i] = 3;
          }
        } else if ($doubleRooms <= $Roomquantity) {
  
          for ($i = 0; $i < $doubleRooms; $i++) {
  
            $placement[$i] = 2;
          }
        }
      }
  
      $group_query_price = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_reason = '$reason'";
  
      $record_result = mysqli_query($connection,  $group_query_price);
      confirm($record_result);
  
      $numResult = mysqli_num_rows($record_result);
  
      if ($numResult > 1) {
  
  
        if ($gustNum <= 50) {
  
          $group_query_priceR = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_range = '0-50' AND group_reason = '$reason'";
        } else if ($gustNum > 50 && $gustNum <= 80) {
  
          $group_query_priceR = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_range = '51-80' AND group_reason = '$reason'";
        } else if ($gustNum > 80) {
  
          $group_query_priceR = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_range = '80 above' AND group_reason = '$reason'";
        }
  
        $record_resultR = mysqli_query($connection,  $group_query_priceR);
        confirm($record_resultR);
        $row = mysqli_fetch_assoc($record_resultR);
      } else {
        $row = mysqli_fetch_assoc($record_result);
      }
  
  
      foreach ($days as $dy) {
        if ($dy == 'Friday' || $dy == 'Saturday') {
          $price += weekendsPricing($row, $placement, $gustNum, $TeaB, $BBQ, $Dineer,  $LunchNum);
        } else {
          $price += weekdaysPricing($row, $placement, $gustNum, $TeaB, $BBQ, $Dineer,  $LunchNum);
        }
      }
    } else if ($status == 'cus') {
  
      // Price fetch
      $CustomPrice['WeekendPricing'] = $form->Weekends;
      $CustomPrice['WeekdaysPricing'] = $form->Weekdays;
      $CustomPrice['TeaBreak_price'] = $form->custom_TeaBreak;
      $CustomPrice['BBQ_price'] = $form->custom_BBQ;
      $CustomPrice['Dinner_price'] = $form->custom_Dinner;
      $CustomPrice['Lunch_price'] = $form->custom_Lunch;
      $CustomPrice['breakfast_price'] = $form->custom_BreakFast;
      $CustomPrice['Extrabed_price'] = $form->custom_Extrabed;
  
  
  
  
      if (
        $CustomPrice['WeekendPricing'] || $CustomPrice['WeekdaysPricing'] ||
        $CustomPrice['TeaBreak_price'] || $CustomPrice['BBQ_price'] || $CustomPrice['Dinner_price'] || $CustomPrice['Lunch_price'] || $CustomPrice['breakfast_price']
        || $CustomPrice['Extrabed_price']
      ) {
  
  
        // Choose the default
  
  
        $group_query_price = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_reason = '$reason'";
  
        $record_result = mysqli_query($connection,  $group_query_price);
        confirm($record_result);
  
        $numResult = mysqli_num_rows($record_result);
  
        if ($numResult > 1) {
  
  
          if ($gustNum <= 50) {
  
            $group_query_priceR = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_range = '0-50'";
          } else if ($gustNum > 50 && $gustNum <= 80) {
  
            $group_query_priceR = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_range = '51-80'";
          } else if ($gustNum > 80) {
  
            $group_query_priceR = "SELECT * FROM group_pricing WHERE group_location = '$location' AND group_range = '80 above'";
          }
  
          $record_resultR = mysqli_query($connection,  $group_query_priceR);
          confirm($record_resultR);
          $row = mysqli_fetch_assoc($record_resultR);
  
          $CustomPrice['WeekendPricing'] = $CustomPrice['WeekendPricing'] ? $form->Weekends :  $row['group_weekday'];
          $CustomPrice['WeekdaysPricing'] = $CustomPrice['WeekdaysPricing'] ? $form->Weekdays : $row['group_weeends'];
          $CustomPrice['TeaBreak_price'] = $CustomPrice['TeaBreak_price'] ? $form->custom_TeaBreak : $row['group_tea'];
          $CustomPrice['BBQ_price'] = $CustomPrice['BBQ_price'] ? $form->custom_BBQ : $row['group_BBQ'];
          $CustomPrice['Dinner_price'] = $CustomPrice['Dinner_price'] ? $form->custom_Dinner : $row['group_dinner'];
          $CustomPrice['Lunch_price'] = $CustomPrice['Lunch_price'] ? $form->custom_Lunch :  $row['group_lunch'];
          $CustomPrice['breakfast_price'] = $CustomPrice['breakfast_price'] ? $form->custom_BreakFast : $row['group_breakfast'];
          $CustomPrice['Extrabed_price'] = $CustomPrice['Extrabed_price'] ? $form->custom_Extrabed : $row['group_extrabed'];
        } else {
          $row = mysqli_fetch_assoc($record_result);
          $CustomPrice['WeekendPricing'] = $CustomPrice['WeekendPricing'] ? $form->Weekends :  $row['group_weekday'];
          $CustomPrice['WeekdaysPricing'] = $CustomPrice['WeekdaysPricing'] ? $form->Weekdays : $row['group_weeends'];
          $CustomPrice['TeaBreak_price'] = $CustomPrice['TeaBreak_price'] ? $form->custom_TeaBreak : $row['group_tea'];
          $CustomPrice['BBQ_price'] = $CustomPrice['BBQ_price'] ? $form->custom_BBQ : $row['group_BBQ'];
          $CustomPrice['Dinner_price'] = $CustomPrice['Dinner_price'] ? $form->custom_Dinner : $row['group_dinner'];
          $CustomPrice['Lunch_price'] = $CustomPrice['Lunch_price'] ? $form->custom_Lunch : $row['group_lunch'];
          $CustomPrice['breakfast_price'] = $CustomPrice['breakfast_price'] ? $form->custom_BreakFast : $row['group_breakfast'];
          $CustomPrice['Extrabed_price'] = $CustomPrice['Extrabed_price'] ? $form->custom_Extrabed : $row['group_extrabed'];
        }
      }
  
  
  
  
      if ($Roomquantity >= $gustNum) {
  
        for ($sta = 0; $sta < $Roomquantity; $sta++) {
  
          array_push($placement, 1);
        }
      } else if ($Roomquantity < $gustNum) {
        $doubleRooms = $gustNum - $Roomquantity;
  
        for ($sta = 0; $sta < $Roomquantity; $sta++) {
          array_push($placement, 1);
        }
  
        if ($doubleRooms > $Roomquantity) {
          $ThirdRooms = $doubleRooms - $Roomquantity;
  
          for ($i = 0; $i <  $Roomquantity; $i++) {
  
            $placement[$i] = 2;
          }
  
          for ($i = 0; $i <  $ThirdRooms; $i++) {
  
            $placement[$i] = 3;
          }
        } else if ($doubleRooms <= $Roomquantity) {
  
          for ($i = 0; $i < $doubleRooms; $i++) {
  
            $placement[$i] = 2;
          }
        }
      }
  
      foreach ($days as $dy) {
        if ($dy == 'Friday' || $dy == 'Saturday') {
          $price += weekendsPricingCustom($CustomPrice, $placement, $gustNum, $TeaB, $BBQ, $Dineer,  $LunchNum);
        } else {
          $price += weekdaysPricingCustom($CustomPrice, $placement, $gustNum, $TeaB, $BBQ, $Dineer,  $LunchNum);
        }
      }
    }
  
  
  
    $res_agent = $_SESSION['username'];
    $group_rooms = json_encode($rooms);
    $quantity = count($rooms);
  
    $query = "INSERT INTO group_reservation(group_name, group_guest, group_roomQuantity, group_remainingRooms, group_checkin, group_checkout, group_paymentStatus, group_reason, group_price, group_remark, group_agent, group_location) ";
  
    $query .= "VALUES ('{$form->group_name}', $gustNum, $quantity, $quantity, '{$checkin}', '{$checkout}', '{$form->group_paymentStatus}', '{$form->group_reason}', $price, '{$form->group_remark}', '{$res_agent}', '{$group_location}')";
  
    $result = mysqli_query($connection, $query);
    confirm($result);
  
    echo json_encode($result);
  
    $data = true;
  
    $pusher->trigger('group_notifications', 'group_reservation', $data);
  }

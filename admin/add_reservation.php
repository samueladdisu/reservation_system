<?php
if (isset($_POST['add_res'])) {

  echo $_POST['t-start'];
  echo $_POST['t-end'];
  // $room_ids = $_SESSION['checkboxarray'];


  // foreach ($_POST as $key => $value) {
  //   $params[$key] = escape($value);
  // }

  // foreach ($room_ids as $value) {

  //   $room_query = "SELECT room_acc, room_location FROM rooms WHERE room_id = $value";

  //   $room_result = mysqli_query($connection, $room_query);
  //   confirm($room_result);
  //   $room_row = mysqli_fetch_assoc($room_result);

  //   $booked_query = "INSERT INTO booked_rooms(b_roomId, b_roomType, b_roomLocation, b_checkin, b_checkout) ";
  //   $booked_query .= "VALUES ($value, '{$room_row['room_acc']}', '{$room_row['room_location']}',  '{$params['res_checkin']}', '{$params['res_checkout']}')";

  //   $booked_result = mysqli_query($connection, $booked_query);
  //   confirm($booked_result);
  // }
  // $total_price = $_SESSION['totalPrice'];
  // $room_ids = json_encode($room_ids);
  // function getName($n)
  // {
  //   $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  //   $randomString = '';

  //   for ($i = 0; $i < $n; $i++) {
  //     $index = rand(0, strlen($characters) - 1);
  //     $randomString .= $characters[$index];
  //   }

  //   return $randomString;
  // }

  // $res_confirmID = getName(8);

  // $res_location =  $_SESSION['user_location'];

  // $extraBed = isset($_POST['res_extraBed']) ? 'yes' : 'no';



  // // echo $params['res_extraBed'];

  // $res_agent = $_SESSION['username'];
  // $query = "INSERT INTO reservations(res_firstname, res_lastname, res_phone, res_email, res_guestNo, res_groupName, res_checkin, res_checkout, res_paymentMethod, res_roomIDs, res_location, res_specialRequest, res_agent, res_remark, res_promo, res_extraBed, res_confirmID, res_price) ";

  // $query .= "VALUES ('{$params['res_firstname']}', '{$params['res_lastname']}', '{$params['res_phone']}', '{$params['res_email']}', '{$params['res_guestNo']}', '{$params['res_groupName']}', '{$params['res_checkin']}', '{$params['res_checkout']}', '{$params['res_paymentMethod']}', '{$room_ids}', '{$res_location}', '{$params['res_specialRequest']}', '{$res_agent}', '{$params['res_remark']}', '{$params['res_promo']}', '$extraBed', '$res_confirmID', '$total_price'  ) ";

  // $result = mysqli_query($connection, $query);
  // confirm($result);
}


?>
<div id="app">


  <form action="" @submit.prevent="addReservation" method="POST" id="reservation" class="col-12 row" enctype="multipart/form-data">

    <h1 class="mb-2">Select Room</h1>
    <div class="col-12 row">
      <!------------------------- t-date picker  --------------------->
      <div class="col-12 row mb-2">

        <div class="t-datepicker col-3">
          <div class="t-check-in">
            <div class="t-dates t-date-check-in">
              <label class="t-date-info-title">Check In</label>
            </div>
            <input type="hidden" class="t-input-check-in" name="start">
            <div class="t-datepicker-day">
              <table class="t-table-condensed">
                <!-- Date theme calendar -->
              </table>
            </div>
          </div>
          <div class="t-check-out">
            <div class="t-dates t-date-check-out">
              <label class="t-date-info-title">Check Out</label>
            </div>
            <input type="hidden" class="t-input-check-out" name="end">
          </div>
        </div>



        <?php

        if ($_SESSION['user_location'] == 'admin') {

        ?>
          <div class="form-group col-2">
            <select name="room_location" class="custom-select" v-model="location" id="">
              <option disabled value="">Resort Location</option>
              <?php

              $query = "SELECT * FROM locations";
              $result = mysqli_query($connection, $query);
              confirm($result);

              while ($row = mysqli_fetch_assoc($result)) {
                $location_id = $row['location_id'];
                $location_name = $row['location_name'];

                echo "<option value='$location_name'>{$location_name}</option>";
              }
              ?>
            </select>
          </div>
        <?php } else { ?>
          <input type="hidden" name="room_location" value="<?php echo $_SESSION['user_location']; ?>">


        <?php  }


        ?>

        <div class="form-group col-2">
          <select name="room_location" class="custom-select" v-model="roomType" id="">
            <option disabled value="">Room Type</option>
            <?php

            $query = "SELECT * FROM room_type";
            $result = mysqli_query($connection, $query);
            confirm($result);

            while ($row = mysqli_fetch_assoc($result)) {
              $type_name = $row['type_name'];
              $type_location = $row['type_location'];

              echo "<option value='$type_name'>{$type_name}</option>";
            }
            ?>
          </select>
        </div>


        <div id="bulkContainer" class="col-3">
          <button name="booked" @click.prevent="filterRooms" class="btn btn-success">Filter</button>

          <button name="booked" value="location" id="location" @click.prevent="clearFilter" class="btn btn-danger mx-2">Clear Filters</button>

          <span class="text-muted">
            Total: ${{ totalPrice }}
          </span>



        </div>



      </div>
      
      <div class="input-group mb-3 col-2">
        <input type="text" placeholder="Promo Code" name="res_promo" v-model="formData.res_promo" class="form-control">
        <div class="input-group-append">
          <button :disabled="oneClick" @click="fetchPromo" class="input-group-text">Apply</button>

        </div>
      </div>
      <!------------------------- t-date picker end  ------------------>

      <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">

        <thead>
          <tr>
            <th><input type="checkbox" name="" id="selectAllboxes" v-model="selectAllRoom" @click="selectAll"></th>
            <th>Id</th>
            <th>Occupancy</th>
            <th>Accomodation</th>
            <th>Price</th>
            <th>Room Number</th>
            <th>Room Status</th>
            <th>Hotel Location</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody class="insert-data">


          <tr v-for="row in allData" :key="row.room_id">
            <td><input type="checkbox" name="checkBoxArray[]" :value="row.room_id" v-model="rowId" @change="booked(row)" class="checkBoxes"></td>
            <td>
              {{ row.room_id }}
            </td>
            <td>
              {{ row.room_occupancy }}
            </td>
            <td>
              {{ row.room_acc }}
            </td>
            <td>
              {{ row.room_price }}
            </td>
            <td>
              {{ row.room_number }}
            </td>
            <td>
              {{ row.room_status }}
            </td>
            <td>
              {{ row.room_location }}
            </td>
            <td>
              {{ row.room_desc.substring(0,50)+"..." }}
            </td>
          </tr>
        </tbody>
      </table>

    </div>


    <div class="col-6 row">
      <h2 class="col-12 mb-5">Fill in Guest Information</h2>
      <div class="form-group col-6">
        <input type="text" placeholder="First Name*" class="form-control" v-model="formData.res_firstname" name="res_firstname">
      </div>
      <div class="form-group col-6">
        <input type="text" placeholder="Last Name*" class="form-control" v-model="formData.res_lastname" name="res_lastname">
      </div>

      <div class="form-group col-6">
        <input type="text" placeholder="Phone No.*" class="form-control" v-model="formData.res_phone" name="res_phone">
      </div>

      <div class="form-group col-6">
        <input type="text" placeholder="Email*" class="form-control" v-model="formData.res_email" name="res_email">
      </div>


      <div class="form-group col-6">
        <input type="text" placeholder="No. of Guests*" class="form-control" v-model="formData.res_guestNo" name="res_guestNo">
      </div>

      <div class="form-group col-6">
        <input type="text" placeholder="Group Name*" class="form-control" v-model="formData.res_groupName" name="res_groupName">
      </div>




      <div class="form-group col-6">
        <select name="res_paymentMethod" v-model="formData.res_paymentMethod" class="custom-select" id="">
          <option value="">Payment Method*</option>
          <option value="bank_transfer">Bank Transfer</option>
          <option value="cash">Cash</option>
          <option value="GC1">Gift Card 1</option>
          <option value="GC2">Gift Card 2</option>
          <option value="GC3">Gift Card 3</option>
        </select>

      </div>


      <div class="form-group col-6">
        <select name="res_paymentStatus" v-model="formData.res_paymentStatus" class="custom-select" id="">
          <option value="">Payment Status*</option>
          <option value="payed">Payed</option>
          <option value="pending_payment">pending payment</option>
        </select>
      </div>



      <div class="form-group col-6">
        <input type="text" placeholder="Special Request*" class="form-control" v-model="formData.res_specialRequest" name="res_specialRequest" id="">
        <!-- <textarea name="res_specialRequest" id="" cols="30" rows="10" placeholder="Special Request" class="form-control"></textarea> -->
      </div>

      <div class="form-group col-6">
        <input type="text" placeholder="Member User Name" v-model="formData.res_member"class="form-control">
      </div>

      <div class="form-group col-12">
        <textarea name="res_remark" v-model="formData.res_remark" placeholder="Remark*" id="" cols="30" rows="10" class="form-control"></textarea>
      </div>

      <div class="form-group col-12">

        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="res_extraBed" v-model="formData.res_extraBed" value="Extra_bed" id="flexCheckDefault">
          <label class="form-check-label" for="flexCheckDefault">
            Extra Bed
          </label>
        </div>
      </div>


      <div class="form-group">
        <input type="submit" class="btn btn-primary" name="add_res" value="Add Reservation">
      </div>
    </div>


  </form>



</div>
<div id="app">


  <form action="" @submit.prevent="addReservation" method="POST" id="reservation" class="col-12 row" enctype="multipart/form-data">

    <h1 class="mb-4">Select Room</h1>

    <div class="col-12 row">

      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
        1 room(s) 1 guest(s)
      </button>

      <!-- Modal -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="" class="text-dark">Room 1:</label>
                <div class="row">
                  <input type="number" class="form-control col-3" placeholder="Adults">
                  <input type="number" class="form-control col-3 offset-1" placeholder="Teens(6-11)">
                  <input type="number" class="form-control col-3 offset-1" placeholder="kid(12-17)">

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>


      <!-- <div class="input-group mb-3 col-2">
        <input type="text" placeholder="Promo Code" name="res_promo" v-model="formData.res_promo" class="form-control">
        <div class="input-group-append">
          <button :disabled="oneClick" @click="fetchPromo" class="input-group-text">Apply</button>

        </div>
      </div> -->
    </div>



    <div class="col-12 row">
      <!------------------------- t-date picker  --------------------->
      <!-- <div class="col-12 row mb-2"> -->

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

<!------------------------- t-date picker end  ------------------>

      <?php

      if ($_SESSION['user_role'] == 'SA' || ($_SESSION['user_location'] == 'Boston' && $_SESSION['user_role'] == 'RA')) {

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
        <!--
          <span class="text-muted">
            Total: ${{ totalPrice }}
          </span> -->



      </div>

      

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


      <div class="form-group col-6 row">
        <!-- <input type="text" placeholder="No. of Guests*" class="form-control" v-model="formData.res_guestNo" name="res_guestNo"> -->
        <!-- <input type="number" class="form-control col-4" placeholder="Adults">
        <input type="number" class="form-control col-4" placeholder="Teens(6-11)">
        <input type="number" class="form-control col-4" placeholder="kid(12-17)"> -->
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
        <input type="text" placeholder="Member User Name" v-model="formData.res_member" class="form-control">
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
<div id="app">


  <form action="" @submit.prevent="addReservation" method="POST" id="reservation" class="col-12 row" enctype="multipart/form-data">

    <h1 class="mb-4">Select Room</h1>

    <div class="col-12 row">

      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cart">
        Cart
      </button>




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

      <!-- Modal -->
      <div class="modal fade" id="guest">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Add Guests</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="" class="text-dark">Room 1:</label>
                <div class="row">
                  <select name="adults" @change="checkAdult" v-model="res_adults" class="custom-select col-3">
                    <option value="" disabled>Adults*</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                  </select>

                  <select name="adults" @change="checkTeen" v-model="res_teen" class="custom-select col-3 offset-1" :disabled="teen">
                    <option value="" disabled>Teens(6-11)</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                  </select>

                  <select name="adults" @change="checkKid" v-model="res_kid" class="custom-select col-3 offset-1" :disabled="kid">
                    <option value="" disabled>kid(12-17)</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                  </select>


                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" @click="booked" data-dismiss="modal" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>


      <div class="modal fade" id="cart">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Selected Rooms</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <!-- cart items  -->
              <div class="list-group">

                <div v-if="cart.length">
                  <a href="#" v-for="item in cart" :key="item.room_id" class="list-group-item list-group-item-action flex-column align-items-start ">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1">{{ item.room_acc }} - {{ item.room_number }}</h5>
                      <small> ${{ item.room_price }} / night</small>
                    </div>
                    <p class="mb-1"> Adults: {{ item.adults }} </p>
                    <p class="mb-1"> Teens: {{ item.teens }} </p>
                    <p class="mb-1"> Kids: {{ item.kids }} </p>

                    <div class="d-flex w-100 justify-content-between">
                      <small>{{ item.room_location }} </small>

                      <div class="d-flex">

                        <p class="ml-2">
                          <i style='color: red;' @click="deleteCart(item)" class='far fa-trash-alt'></i>
                        </p>
                      </div>
                    </div>
                  </a>
                </div>

                <div v-else>
                  <h2> No Room Selected </h2>
                </div>


              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <table class="table table-bordered table-hover" id="addReserveTable" width="100%" cellspacing="0">

        <thead>
          <tr>
            <th>Id</th>
            <th>Occupancy</th>
            <th>Accomodation</th>
            <th>Price</th>
            <th>Room Number</th>
            <th>Room Status</th>
            <th>Hotel Location</th>
            <th>Select Room</th>
          </tr>
        </thead>
        <tbody class="insert-data">


          <tr v-for="row in allData" :key="row.room_id">

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
              <input type="button" value="Select" @click="temp(row)" data-toggle="modal" data-target="#guest">
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


      <div class="form-group">
        <input type="submit" class="btn btn-primary" name="add_res" value="Add Reservation">
      </div>
    </div>


  </form>



</div>
<?php




if (isset($_GET['edit_id'])) {
  $edit_id = escape($_GET['edit_id']);

  $query = "SELECT * FROM reservations WHERE res_id = $edit_id";
  $result = mysqli_query($connection, $query);
  confirm($result);

  while ($row = mysqli_fetch_assoc($result)) {

    foreach ($row as $key => $value) {
      $res[$key] = $value;
    }
  }
}


?>
<div id="app">

  <form action="" method="POST" class="col-6 row" enctype="multipart/form-data">

    <div class="form-group col-6">
      <label for="title">First Name</label>
      <input type="text" class="form-control" value="<?php echo $res['res_firstname']; ?>" name="res_firstname">
    </div>
    <div class="form-group col-6">
      <label for="title">Last Name</label>
      <input type="text" class="form-control" value="<?php echo $res['res_lastname']; ?>" name="res_lastname">
    </div>

    <div class="form-group col-6">
      <label for="title">Phone No.</label>
      <input type="text" class="form-control" value="<?php echo $res['res_phone']; ?>" name="res_phone">
    </div>

    <div class="form-group col-6">
      <label for="title">Email</label>
      <input type="text" class="form-control" value="<?php echo $res['res_email']; ?>" name="res_email">
    </div>


    <div class="form-group col-6">
      <label for="title"># of Guests</label>
      <input type="text" class="form-control" value="<?php echo $res['res_guestNo']; ?>" name="res_guestNo">
    </div>

    <div class="form-group col-6">
      <label for="title">Group Name</label>
      <input type="text" class="form-control" value="<?php echo $res['res_groupName']; ?>" name="res_groupName">
    </div>


    <div class="form-group col-6">
      <label for="title">Check In</label>
      <input type="date" class="form-control" value="<?php echo $res['res_checkin']; ?>" name="res_checkin">
    </div>


    <div class="form-group col-6">
      <label for="title">Check Out</label>
      <input type="date" class="form-control" value="<?php echo $res['res_checkout']; ?>" name="res_checkout">
    </div>




    <div class="form-group col-6">
      <label for="title">Payment Method</label>
      <select name="res_paymentMethod" class="custom-select" id="">
        <option value="<?php echo $res['res_paymentMethod']; ?>"><?php echo $res['res_paymentMethod']; ?></option>
        <option value="bank_transfer">Bank Transfer</option>
        <option value="cash">Cash</option>
        <option value="GC1">Gift Card 1</option>
        <option value="GC2">Gift Card 2</option>
        <option value="GC3">Gift Card 3</option>
      </select>

    </div>

    <div class="form-group col-6">
      <label for="title">Select Room</label> <br>
      <!-- Button trigger modal -->

      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
        Select Room
      </button>
    </div>



    <div class="form-group col-6">
      <label for="title">Payment Status</label>
      <select name="res_paymentStatus" class="custom-select" id="">
        <option value="<?php echo $res['res_paymentStatus']; ?>"><?php echo $res['res_paymentStatus']; ?></option>
        <option value="payed">Payed</option>
        <option value="pending_payment">pending payment</option>
      </select>
    </div>

    <div class="form-group col-6">
      <label for="">Apply Promo Code</label>
      <input type="text" class="form-control" value="<?php echo $res['res_promo']; ?>" name="res_promo" id="">
    </div>

    <div class="form-group col-6 mt-3">
      <label for="post_content">Special Request</label>
      <textarea name="res_specialRequest" id="" cols="30" rows="10" class="form-control">
      <?php echo $res['res_specialRequest']; ?>
      </textarea>
    </div>


    <div class="form-group col-6 mt-3">
      <label for="post_content">Remark</label>
      <textarea name="res_remark" id="" cols="30" rows="10" class="form-control">
      <?php echo $res['res_remark']; ?>
      </textarea>
    </div>

    <div class="form-group col-12">

      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
        <label class="form-check-label" for="flexCheckDefault">
          Extra Bed
        </label>
      </div>
    </div>


    <div class="form-group">
      <input type="submit" class="btn btn-primary" name="edit_res" value="Edit Reservation">
    </div>

  </form>



  <!-- Modal -->

  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Select Room

          </h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">

              <form action="" class="row" method="post">



                <table class="table table-bordered table-hover col-12" width="100%" cellspacing="0">
                  <?php

                  if ($_SESSION['user_location'] == 'admin') {

                  ?>
                    <div class="form-group col-4">
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

                  <div class="form-group col-4">
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
                  <div id="bulkContainer" class="col-4">
                    <button name="booked" value="location" id="location" @click.prevent="filterRooms" class="btn btn-success">Filter</button>

                    <button name="booked" value="location" id="location" @click.prevent="clearFilter" class="btn btn-danger mx-2">Clear Filters</button>


                    <span class="text-muted">
                      Total: ${{ totalPrice }}
                    </span>


                  </div>
                  <thead>
                    <tr>
                      <th><input type="checkbox" name="" id="selectAllboxes" v-model="selectAllRoom" @change="bookAll"></th>
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

                    <?php

                    $room = json_decode($res['res_roomIDs']);
                    $room_ids = array();

                    foreach ($room  as $value) {
                      array_push($room_ids, json_decode($value));
                    }
                    // var_dump($room_ids);
                    $query = 'SELECT * FROM rooms WHERE room_id IN (' . implode(',', array_map('intval', $room_ids)) . ')';
                    $result = mysqli_query($connection, $query);

                    confirm($result);

                    while ($row = mysqli_fetch_assoc($result)) {
                      foreach ($row as $key => $value) {
                        $params[$key] = $value;
                      }
                      ?>
                 


                    <tr>
                      <td><input type="checkbox" 
                      value="<?php echo $params['room_id']; ?>" class="checkBoxes"></td>
                      <td>
                        <!-- {{ row.room_id }} -->
                        <?php echo $params['room_id']; ?>
                      
                      </td>
                      <td>
                        <!-- {{ row.room_occupancy }} -->
                        <?php echo $params['room_occupancy']; ?>
                      </td>
                      <td>
                        <!-- {{ row.room_acc }} -->
                        <?php echo $params['room_acc']; ?>
                      </td>
                      <td>
                        <!-- {{ row.room_price }} -->
                        <?php echo $params['room_price']; ?>
                      </td>
                      <td>
                        <!-- {{ row.room_number }} -->
                        <?php echo $params['room_number']; ?>
                      </td>
                      <td>
                        <!-- {{ row.room_status }} -->
                        <?php echo $params['room_status']; ?>
                      </td>
                      <td>
                        <!-- {{ row.room_location }} -->
                        <?php echo $params['room_location']; ?>
                      </td>
                      <td>
                        <!-- {{ row.room_desc.substring(0,50)+"..." }} -->
                        <?php echo substr($params['room_desc'], 0, 50); ?>
                      </td>
                    </tr>

                    <?php  }


?>
                  </tbody>
                </table>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
          <button name="booked" value="booked" id="book" @click.prevent="reserveRooms" data-dismiss="modal" class="btn btn-secondary">Reserve Room</button>
          <button name="booked" value="booked" id="book" @click.prevent="bookRooms" data-dismiss="modal" class="btn btn-primary">Book Room</button>
        </div>
        </form>
      </div>
    </div>
  </div>

</div>

<?php 


if(isset($_POST['edit_res'])){

  foreach ($_POST as $key => $value) {
    echo $form[$key] = escape($value) . "<br>";
  }


}
?>
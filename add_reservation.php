<?php

$room_ids = $_SESSION['checkboxarray'];
$room_ids = json_encode($room_ids);

print_r($room_ids);


if (isset($_POST['add_res'])) {
  
  $res_location =  $_SESSION['user_location'];
 

  foreach ($_POST as $key => $value) {
    echo $params[$key] = $value;
  }

  $res_agent = $_SESSION['username'];
  $query = "INSERT INTO reservations(res_firstname, res_lastname, res_phone, res_email, res_guestNo, res_groupName, res_checkin, res_checkout, res_paymentMethod, res_roomIDs, res_location, res_specialRequest, res_agent) ";

  $query .= "VALUES ('{$params['res_firstname']}', '{$params['res_lastname']}', '{$params['res_phone']}', '{$params['res_email']}', '{$params['res_guestNo']}', '{$params['res_groupName']}', '{$params['res_checkin']}', '{$params['res_checkout']}', '{$params['res_paymentMethod']}', '{$room_ids}', '{$res_location}', '{$params['res_specialRequest']}', '{$res_agent}'  ) ";

  $result = mysqli_query($connection, $query);
  confirm($result);
}


?>
<div id="app">

  <form action="" method="POST" class="col-6 row" enctype="multipart/form-data">

    <div class="form-group col-6">
      <label for="title">First Name</label>
      <input type="text" class="form-control" name="res_firstname">
    </div>
    <div class="form-group col-6">
      <label for="title">Last Name</label>
      <input type="text" class="form-control" name="res_lastname">
    </div>

    <div class="form-group col-6">
      <label for="title">Phone No.</label>
      <input type="text" class="form-control" name="res_phone">
    </div>

    <div class="form-group col-6">
      <label for="title">Email</label>
      <input type="text" class="form-control" name="res_email">
    </div>


    <div class="form-group col-6">
      <label for="title"># of Guests</label>
      <input type="text" class="form-control" name="res_guestNo">
    </div>

    <div class="form-group col-6">
      <label for="title">Group Name</label>
      <input type="text" class="form-control" name="res_groupName">
    </div>


    <div class="form-group col-6">
      <label for="title">Check In</label>
      <input type="date" class="form-control" value="<?php echo date('Y-m-d') ?>" name="res_checkin">
    </div>


    <div class="form-group col-6">
      <label for="title">Check Out</label>
      <input type="date" class="form-control" value="<?php echo date('Y-m-d', strtotime(' +1 day')) ?>" name="res_checkout">
    </div>




    <div class="form-group col-6">
      <label for="title">Payment Method</label>
      <select name="res_paymentMethod" class="custom-select" id="">
        <option value="cash">Select option</option>
        <option value="cash">cash</option>
      </select>

    </div>

    <div class="form-group col-6">
      <label for="title">Select Room</label> <br>
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
        Select Room
      </button>

    </div>

    <div class="form-group col-12">
      <label for="post_content">Special Request</label>
      <textarea name="res_specialRequest" id="" cols="30" rows="10" class="form-control"></textarea>
    </div>





    <div class="form-group">
      <input type="submit" class="btn btn-primary" name="add_res" @click="reservation" value="Add Reservation">
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



                <table class="table table-bordered table-hover col-12" id="dataTable" width="100%" cellspacing="0">
                  <?php

                  if ($_SESSION['user_location'] == 'admin') {

                  ?>
                    <div class="form-group col-4">
                      <select name="room_location" class="custom-select" v-model="location" id="">
                        <option value="">Resort Location</option>
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
                  <div id="bulkContainer" class="col-4">
                    <button name="booked" value="location" id="location" @click.prevent="filterRooms" class="btn btn-success">Filter</button>

                    <button name="booked" value="booked" id="book" @click.prevent="bookRooms" class="btn btn-primary">Book Room</button>


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


                    <tr v-for="row in allData" :key="row.room_id">
                      <td><input type="checkbox" name="checkBoxArray[]" :value="row.room_id" @change="booked(row)" class="checkBoxes"></td>
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
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>

</div>
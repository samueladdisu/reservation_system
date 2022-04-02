<?php

if ($_SESSION['user_role'] == 'RA') {
  header("Location: ./rooms.php");
}
?>

<?php
  $incoming = json_decode(file_get_contents("php://input"));
if (isset($_POST['add_room'])) {
  $room_acc         =  escape($_POST['room_acc']);
  $room_number      =  escape($_POST['room_number']);
  $room_location    =  escape($_POST['room_location']);
  $room_amenities   =  $_SESSION['amt'];
  $room_desc        =  escape($_POST['room_desc']);

  $room_amenities = json_encode($room_amenities);

  $acc_query  = "SELECT * FROM room_type WHERE type_name = '$room_acc'";
  $acc_result = mysqli_query($connection,$acc_query);

  confirm($acc_result);
  
  while ($row = mysqli_fetch_assoc($acc_result)){
    $occ = $row['occupancy'];
    $price = $row['rack_rate'];
    $img = $row['room_image'];
  }


  $query = "INSERT INTO `rooms` (`room_occupancy`, `room_acc`, `room_price`, `room_image`, `room_number`, `room_status`, `room_location`, `room_amenities`, `room_desc`) VALUES ('$occ', '$room_acc', '$price', '$img', '$room_number', 'Not_booked', '$room_location', '$room_amenities', '$room_desc');";


  $result = mysqli_query($connection, $query);

  confirm($result);
  header("Location: ./rooms.php");
}
?>


<form action="" id="addRoom" method="POST" class="col-6" enctype="multipart/form-data">
  <div class="form-group">
    <label for="room_acc"> Room Type</label>

    <select name="room_acc" class="custom-select" id="">
      <option value="">Select option</option>
      <?php
      $location = $_SESSION['user_location'];
      if ($location == 'Boston') {
        $query = "SELECT * FROM room_type";
      } else {
        $query = "SELECT * FROM room_type WHERE type_location = '$location'";
      }
      $result = mysqli_query($connection, $query);

      confirm($result);
      while ($row = mysqli_fetch_assoc($result)) {
        $type_name         = $row['type_name'];
      ?>

          <option value='<?php echo $type_name ?>'><?php echo $type_name ?></option>
      <?php
        }
      ?>
    </select>
  </div>
  
  <div class="form-group">
    <label for="post_tags"> Room Number </label>
    <input type="text" class="form-control" name="room_number">
  </div>
  <!-- <div class="form-group">
    <label for="room_status"> Room Status</label>
    <select name="room_status" class="custom-select" id="">
      <option value="Not_booked">Select Options</option>
      <option value="booked">Booked</option>
      <option value="Not_booked">Not Booked</option>
    </select>
  </div> -->
  <?php

  if ($_SESSION['user_location'] == 'Boston' && $_SESSION['user_role'] == 'SA') {

  ?>
    <div class="form-group">
      <label for="location">Resort Location</label>
      <select name="room_location" class="custom-select" id="">
        <option value="">Select Option</option>
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
  <?php  } ?>

  <div class="form-group">
    <label for="amt">Room Amenities</label>
    <input type="text" name="room_amenities" @keyup.alt="addAmt" v-model="tempAmt" id="amt" class="form-control">
  </div>
  <div class="my-1">
    <span v-for="am in amt" :key="am" class="badge-pill px-3 mx-1 py-1 badge-dark">

      <span @click="deleteAmt(am)"> {{ am }}<i class="fal fa-times pl-2"></i></span>
    </span>
  </div>

  <div class="form-group">
    <label for="post_content"> Room Description</label>
    <textarea name="room_desc" id="" cols="30" rows="10" class="form-control"></textarea>
  </div>


  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="add_room" value="Add Room">
  </div>

</form>
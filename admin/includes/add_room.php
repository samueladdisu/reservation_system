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
  // $room_amenities   =  $_SESSION['amt'];
  $room_desc        =  escape($_POST['room_desc']);

  // $room_amenities = json_encode($room_amenities);

  $acc_query  = "SELECT * FROM room_type WHERE type_name = '$room_acc'";
  $acc_result = mysqli_query($connection,$acc_query);

  confirm($acc_result);
  
  while ($row = mysqli_fetch_assoc($acc_result)){
    $occ = $row['occupancy'];
    $price = $row['d_rack_rate'];
    $img = $row['room_image'];
    $loc = $row['type_location'];
  }


  $query = "INSERT INTO `rooms` (`room_occupancy`, `room_acc`, `room_price`, `room_image`, `room_number`, `room_status`, `room_location`, `room_desc`) VALUES ('$occ', '$room_acc', '$price', '$img', '$room_number', 'Not_booked', '$loc', '$room_desc');";


  $result = mysqli_query($connection, $query);

  confirm($result);
  // header("Location: ./rooms.php");
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
    <label for="amt">Room Amenities</label>
    <input type="text" name="room_amenities" @keyup.alt="addAmt" v-model="tempAmt" id="amt" class="form-control">
  </div>
  <div class="my-1">
    <span v-for="am in amt" :key="am" class="badge-pill px-3 mx-1 py-1 badge-dark">

      <span @click="deleteAmt(am)"> {{ am }}<i class="fal fa-times pl-2"></i></span>
    </span>
  </div> -->

  <div class="form-group">
    <label for="post_content"> Room Description</label>
    <textarea name="room_desc" id="" cols="30" rows="10" class="form-control"></textarea>
  </div>


  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="add_room" value="Add Room">
  </div>

</form>
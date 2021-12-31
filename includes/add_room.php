<?php
if (isset($_POST['add_room'])) {
  $room_occupancy   =  escape($_POST['room_occupancy']);
  $room_acc         =  escape($_POST['room_acc']);
  $room_bed         =  escape($_POST['room_bed']);
  $room_price       =  escape($_POST['room_price']);
  $room_number      =  escape($_POST['room_number']);
  $room_status      =  escape($_POST['room_status']);
  $room_location    =  escape($_POST['room_location']);



  $room_image = $_FILES['room_image']['name'];
  $room_image_temp = $_FILES['room_image']['tmp_name'];

  move_uploaded_file($room_image_temp, "./room_img/$room_image");


  $query = "INSERT INTO `rooms` (`room_occupancy`, `room_acc`, `room_bed`, `room_price`, `room_image`, `room_number`, `room_status`, `room_location`) VALUES ('$room_occupancy', '$room_acc', '$room_bed', '$room_price', '$room_image', '$room_number', '$room_status', '$room_location');";


  $result = mysqli_query($connection, $query);

  confirm($result);
  header("Location: ./rooms.php");
}
?>
<form action="" method="POST" class="col-6" enctype="multipart/form-data">

  <div class="form-group">
    <label for="title">Room Occupancy</label>
    <input type="text" class="form-control" name="room_occupancy">
  </div>

  <div class="form-group">
    <label for="room_acc"> Room Type</label>

    <select name="room_acc" class="custom-select" id="">
      <option value="">Select option</option>
      <?php

      $query = "SELECT * FROM room_type";
      $result = mysqli_query($connection, $query);

      confirm($result);

      while ($row = mysqli_fetch_assoc($result)) {
        $type_id = $row['type_id'];
        $type_name = $row['type_name'];
      ?>
        <option value='<?php echo $type_id ?>'><?php echo $type_name ?></option>
      <?php  }

      ?>
    </select>
  </div>


  <div class="form-group">
    <label for="post_image"> Room Image</label>
    <input type="file" name="room_image">
  </div>

  <div class="form-group">
    <label for="post_image"> Bed Type </label>
    <input type="text" class="form-control" name="room_bed">
  </div>

  <div class="form-group">
    <label for="post_tags"> Price </label>
    <input type="text" class="form-control" name="room_price">
  </div>

  <div class="form-group">
    <label for="post_tags"> Room Number </label>
    <input type="text" class="form-control" name="room_number">
  </div>

  <div class="form-group">
    <label for="room_status"> Room Status</label>
    <select name="room_status" class="custom-select" id="">
      <option value="Not_booked">Select Options</option>
      <option value="booked">Booked</option>
      <option value="Not_booked">Not Booked</option>
    </select>
  </div>
 
  <div class="form-group">
    <label for="location">Resort Location</label>
    <select name="room_location" class="custom-select" id="">
      <option value="">Select Option</option>
      <?php 

        $query = "SELECT * FROM locations";
        $result = mysqli_query($connection, $query);
        confirm($result);

        while($row = mysqli_fetch_assoc($result)){
            $location_id = $row['location_id'];
            $location_name = $row['location_name'];

            echo "<option value='$location_id'>{$location_name}</option>";
         }
      ?>
    </select>
  </div>



  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="add_room" value="Add Room">
  </div>

</form>
<?php
if (isset($_GET['p_id'])) {
  $p_id = escape($_GET['p_id']);


  $query = "SELECT * FROM rooms WHERE room_id = $p_id";

  $result = mysqli_query($connection, $query);

  confirm($result);

  while ($row = mysqli_fetch_assoc($result)) {
    $room_id = $row['room_id'];
    $room_occupancy = $row['room_occupancy'];
    $room_acc = $row['room_acc'];
    $room_bed = $row['room_bed'];
    $room_price = $row['room_price'];
    $room_image = $row['room_image'];
    $room_number = $row['room_number'];
    $room_status = $row['room_status'];
  }
}
if (isset($_POST['edit_room'])) {
  $room_occupancy   =  escape($_POST['room_occupancy']);
  $room_acc         =  escape($_POST['room_acc']);
  $room_bed         =  escape($_POST['room_bed']);
  $room_price       =  escape($_POST['room_price']);
  $room_number      =  escape($_POST['room_number']);
  $room_status      =  escape($_POST['room_status']);

  $room_image = $_FILES['room_image']['name'];
  $room_image_temp = $_FILES['room_image']['tmp_name'];

  move_uploaded_file($room_image_temp, "./room_img/$room_image");


  if (empty($room_image)) {
    $image_query = "SELECT * FROM rooms WHERE room_id = $p_id ";
    $selected_image = mysqli_query($connection, $image_query);

    while ($row = mysqli_fetch_assoc($selected_image)) {
      $room_image = $row['room_image'];
    }
  }

  $query = "UPDATE `rooms` SET `room_occupancy` = '$room_occupancy', `room_acc` = '$room_acc', `room_bed` = '$room_bed', `room_price` = '$room_price', `room_image` = '$room_image', `room_status` = '$room_status' WHERE `rooms`.`room_id` = $p_id;";



  $update_proclamation = mysqli_query($connection, $query);

  confirm($update_proclamation);
  header("Location: ./rooms.php");
}
?>


<form action="" method="POST" class="col-6" enctype="multipart/form-data">

  <div class="form-group">
    <label for="title"> Room Occupancy</label>
    <input type="text" class="form-control" value="<?php echo $room_occupancy; ?>" name="room_occupancy">
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
        <option value='<?php echo $type_name ?>'><?php echo $type_name ?></option>
      <?php  }

      ?>
    </select>
  </div>


  <div class="form-group">
    <label for="post_image"> Image</label>

    <img width='100' src='./room_img/<?php echo $room_image; ?>' style="display: block; margin-bottom: 1rem;" alt="">

    <input type="file" name="room_image">
  </div>
  <div class="form-group">
    <label for="post_image"> Bed Type </label>
    <input type="text" class="form-control" value="<?php echo $room_bed; ?>" name="room_bed">
  </div>
  <div class="form-group">
    <label for="post_tags"> Price </label>
    <input type="text" class="form-control" value="<?php echo $room_price; ?>" name="room_price">
  </div>

  <div class="form-group">
    <label for="post_tags"> Room Number </label>
    <input type="text" class="form-control" value="<?php echo $room_number; ?>" name="room_number">
  </div>


  <div class="form-group">
    <label for="room_status">Room Status</label> <br>
    <select name="room_status" class="custom-select" id="">
      <option value="<?php echo $room_status; ?>"><?php echo $room_status; ?></option>
      <?php

      if($room_status == 'booked') {
        echo '<option value="not_booked">Not booked</option>';
      }else {
        echo '<option value="booked">Booked</option>';
      }



      ?>
    </select>
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="edit_room" value="Edit Room">
  </div>

</form>
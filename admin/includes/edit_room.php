<?php

if ($_SESSION['user_role'] == 'RA') {
  header("Location: ./rooms.php");
}
?>
<?php
if (isset($_GET['p_id'])) {
  $p_id = escape($_GET['p_id']);



  $query = "SELECT * FROM rooms WHERE room_id = $p_id";


  $result = mysqli_query($connection, $query);

  confirm($result);

  while ($row = mysqli_fetch_assoc($result)) {
    $room_id = $row['room_id'];
    $room_acc = $row['room_acc'];
    $room_number = $row['room_number'];
    // $room_amt = json_decode($row['room_amenities']);
    $room_location = $row['room_location'];
    $room_desc = $row['room_desc'];
  }

  if ($_SESSION['user_role'] == 'PA' && $_SESSION['user_location'] != $room_location) {
    header("Location: ./rooms.php");
  }
}
if (isset($_POST['edit_room'])) {
  $room_acc         =  escape($_POST['room_acc']);
  $room_number      =  escape($_POST['room_number']);
  $room_desc        =  escape($_POST['room_desc']);

  
  $acc_query  = "SELECT * FROM room_type WHERE type_name = '$room_acc'";
  $acc_result = mysqli_query($connection,$acc_query);

  confirm($acc_result);
  
  while ($row = mysqli_fetch_assoc($acc_result)){
    $occ = $row['occupancy'];
    $price = $row['d_rack_rate'];
    $img = $row['room_image'];
  }

  $query = "UPDATE `rooms` SET `room_occupancy` = '$occ', `room_acc` = '$room_acc', `room_price` = '$price', `room_image` = '$img', `room_number` = '$room_number', `room_location` = '{$row['type_location']}', `room_desc` = '$room_desc' WHERE `rooms`.`room_id` = $p_id; ";



  $update_room = mysqli_query($connection, $query);

  confirm($update_room);
  // header("Location: ./rooms.php");
}
?>


<form action="" method="POST" class="col-6" enctype="multipart/form-data">

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
        $type_id           = $row['type_id'];
        $type_name         = $row['type_name'];
        $type_room_price   = $row['room_price'];
        $occupancy         = $row['occupancy'];
        $room_image         = $row['room_image'];
        $temp_type         = "";
        if (strcmp($type_name, $temp_type) == 0) {
          continue;
        } else {
      ?>

          <option value='<?php echo $type_name ?>'><?php echo $type_name ?></option>
      <?php
        }
      }

      ?>
    </select>
  </div>

  <div class="form-group">
    <label for="post_tags"> Room Number </label>
    <input type="text" class="form-control" value="<?php echo $room_number; ?>" name="room_number">
  </div>


  <div class="form-group">
    <label for="post_content"> Room Description</label>
    <textarea name="room_desc" id="" cols="30" rows="10" class="form-control">
    <?php echo $room_desc; ?>
    </textarea>
  </div>

  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="edit_room" value="Edit Room">
  </div>

</form>
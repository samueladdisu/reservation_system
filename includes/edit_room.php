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
    $room_price = $row['room_price'];
    $room_image = $row['room_image'];
    $room_number = $row['room_number'];
    $room_status = $row['room_status'];
    $room_location = $row['room_location'];
    $room_desc = $row['room_desc'];
  }
}
if (isset($_POST['edit_room'])) {
  $room_occupancy   =  escape($_POST['room_occupancy']);
  $room_acc         =  escape($_POST['room_acc']);
  $room_price       =  escape($_POST['room_price']);
  $room_number      =  escape($_POST['room_number']);
  $room_status      =  escape($_POST['room_status']);
  $room_location      =  escape($_POST['room_location']);
  $room_desc = escape($_POST['room_desc']);

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

  $query = "UPDATE `rooms` SET `room_occupancy` = '$room_occupancy', `room_acc` = '$room_acc', `room_price` = '$room_price', `room_image` = '$room_image', `room_number` = '$room_number', `room_status` = '$room_status', `room_location` = '$room_location', `room_desc` = '$room_desc' WHERE `rooms`.`room_id` = $p_id; ";



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
      echo $location = $_SESSION['user_role'];
      
      $query = "SELECT * FROM room_type WHERE type_location = '$location' ";
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
    <label for="post_tags"> Price </label>
    <input type="text" class="form-control" value="<?php echo $room_price; ?>" name="room_price">
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
    <label for="room_status">Room Status</label> <br>
    <select name="room_status" class="custom-select" id="">
      <option value="<?php echo $room_status; ?>"><?php echo $room_status; ?></option>
      <?php

      if($room_status == 'booked') {
        echo '<option value="Not_booked">Not booked</option>';
      }else {
        echo '<option value="booked">Booked</option>';
      }



      ?>
    </select>
  </div>
  <?php 
 
 if ($_SESSION['user_role'] == 'admin') {
 
 ?>
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

            echo "<option value='$location_name'>{$location_name}</option>";
         }
      ?>
    </select>
  </div>
  <?php }else {?>
    <input type="hidden" name="room_location" value="<?php echo $_SESSION['user_role']; ?>">
 <?php  }?>

  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="edit_room" value="Edit Room">
  </div>

</form>
<?php

if ($_SESSION['user_role'] == 'RA') {
  header("Location: acc.php");
}


?>
<h2>Edit Accomodation</h2>
<form action="" method="post" class="row" enctype="multipart/form-data">
  


  <?php
  if (isset($_GET['edit'])) {
    $type_id = escape($_GET['edit']);
    $query = "SELECT * FROM room_type WHERE type_id = {$type_id}";
    $result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($result)) {
  ?>
      <div class="form-group col-4">
        <label for="title">Room Occupancy</label>
        <input type="text" class="form-control" value="<?php echo $row['occupancy']; ?>" name="room_occupancy">
      </div>

      <div class="form-group col-4">
        <label for="type_name">Room Type</label>
        <input type="text" class="form-control" value="<?php echo $row['type_name']; ?>" name="type_name">
      </div>

      <div class="form-group col-4">
        <label for="user_role"> Double Occupancy(rack rate)</label>
        <input type="text" class="form-control" value="<?php echo $row['d_rack_rate']; ?>" name="d_rack_rate">
      </div>
      <div class="form-group col-4">
        <label for="user_role"> Single Occupancy(rack rate) </label>
        <input type="text" class="form-control" value="<?php echo $row['s_rack_rate']; ?>" name="s_rack_rate">
      </div>



      <?php

      if ($_SESSION['user_role'] != 'PA') {
      ?>
        <div class="form-group col-4">
          <label for="user_role"> Hotel Location </label> <br>
          <select name="type_location" class="custom-select">

            <option value="<?php echo $row['type_location']; ?>"><?php echo $row['type_location']; ?></option>
            <?php

            $query = "SELECT * FROM locations";
            $result = mysqli_query($connection, $query);
            confirm($result);

            while ($row1 = mysqli_fetch_assoc($result)) {
              $location_id = $row1['location_id'];
              $location_name = $row1['location_name'];

              echo "<option value='$location_name'>{$location_name}</option>";
            }
            ?>
          </select>
        </div>

      <?php
      } else {
      ?>
        <input type="hidden" name="type_location" value="<?php echo $_SESSION['user_location']; ?>">

      <?php
      }

      ?>

      <div class="form-group col-4">
        <label for="type_name">Room Image</label> <br>
        <img width='100' src='./room_img/<?php echo $row['room_image']; ?>' style="display: block; margin-bottom: 1rem;" alt="">
        <input type="file" name="room_image">

      </div>



  <?php }
  }
  ?>



  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="update_category" value="Update Accomodation">
  </div>
</form>
<?php
// Update category

if (isset($_POST['update_category'])) {
  $type_name          = escape($_POST['type_name']);
  $type_location      = escape($_POST['type_location']);
  $double             = escape($_POST['d_rack_rate']);
  $single             = escape($_POST['s_rack_rate']);
  $room_occupancy     = escape($_POST['room_occupancy']);


  $room_image         = $_FILES['room_image']['name'];
  $room_image_temp    = $_FILES['room_image']['tmp_name'];

  move_uploaded_file($room_image_temp, "./room_img/$room_image");


  if (empty($room_image)) {
    $image_query = "SELECT * FROM room_type WHERE type_id = $type_id ";
    $selected_image = mysqli_query($connection, $image_query);

    while ($row = mysqli_fetch_assoc($selected_image)) {
      $room_image = $row['room_image'];
    }
  }

  $d_weekdays = number_format($double - ($double * 0.15), 2, '.', '');
  $s_weekdays = number_format($single - ($single * 0.15), 2, '.', '');


 


  if ($type_location === "Bishoftu") {

    $s_weekend   = number_format($single - ($single * 0.1), 2, '.', '');
    $d_weekend   = number_format($double - ($double * 0.1), 2, '.', '');
    $s_member    = number_format($single - ($single * 0.25), 2, '.', '');
    $d_member    = number_format($double - ($double * 0.25), 2, '.', '');

    $update_bishoftu = "UPDATE `room_type` SET `type_name` = '$type_name', `type_location` = '$type_location', `occupancy` = '$room_occupancy', `room_image` = '$room_image', `d_rack_rate` = $double, `d_weekend_rate` = $d_weekend, `d_member_rate` = $d_member, `d_weekday_rate` = $d_weekdays, `s_rack_rate` = $single, `s_weekend_rate` = $s_weekend, `s_member_rate` = $s_member, `s_weekday_rate` = $s_weekdays  WHERE `room_type`.`type_id` = $type_id";

    
    $result_bishoftu = mysqli_query($connection, $update_bishoftu);

    confirm($result_bishoftu);
  } else if ($type_location === "Awash") {

    $update_awash = "UPDATE `room_type` 
    SET `type_name` = '$type_name', 
    `type_location` = '$type_location', 
    `occupancy` = '$room_occupancy', `room_image` = '$room_image', `d_rack_rate` = $double, `d_weekend_rate` = $d_weekend, `d_member_rate` = $d_member, `d_weekday_rate` = $d_weekdays, `s_rack_rate` = $single, `s_weekend_rate` = $s_weekend, `s_member_rate` = $s_member, `s_weekday_rate` = $s_weekdays WHERE `room_type`.`type_id` = $type_id";

    
    $result_awash = mysqli_query($connection, $update_awash);

    confirm($result_awash);
  }
  
  header("Location: acc.php");
  
}
?>
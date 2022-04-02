<?php

if ($_SESSION['user_role'] == 'RA') {
  header("Location: acc.php");
}


?>

<form action="" method="post" enctype="multipart/form-data">
  <h2>Edit Accomodation</h2>


  <?php
  if (isset($_GET['edit'])) {
    $type_id = escape($_GET['edit']);
    $query = "SELECT * FROM room_type WHERE type_id = {$type_id}";
    $result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($result)) {
      $type_id = $row['type_id'];
      $type_name = $row['type_name'];
      $type_location = $row['type_location'];
      $room_price = $row['room_price'];
  ?>
      <div class="form-group">
        <label for="user_role"> Room Occupancy </label>
        <input type="text" value="<?php echo $row['occupancy']; ?>" class="form-control" name="occupancy" id="">
      </div>
      <div class="form-group">
        <label for="cat_title">Room Type</label>
        <input type="text" value="<?php if (isset($type_name)) {
                                    echo $type_name;
                                  } ?>" class="form-control" name="type_name" id="">
      </div>

      <div class="form-group">
        <label for="post_image"> Room Image</label>

        <img width='100' src='./room_img/<?php echo $row['room_image']; ?>' style="display: block; margin-bottom: 1rem;" alt="">

        <input type="file" name="room_image">
      </div>

      <div class="form-group">
        <label for="user_role"> Full Amount </label>
        <input type="text" value="<?php echo $row['rack_rate']; ?>" class="form-control" name="rack_rate" id="">
      </div>


      <?php
      if ($_SESSION['user_role'] == 'SA') {
      ?>

        <div class="form-group">
          <label for="user_role"> Hotel Location </label> <br>
          <select name="type_location" class="custom-select">
            <option value="<?php echo $type_location; ?>"><?php echo $type_location; ?></option>
            <?php

            $query = "SELECT * FROM locations";
            $result = mysqli_query($connection, $query);
            confirm($result);

            while ($row = mysqli_fetch_assoc($result)) {
              $location_id = $row['location_id'];
              $location_name = $row['location_name'];

              if ($type_location != $location_name) {

                echo "<option value='$location_name'>{$location_name}</option>";
              }
            }
            ?>
          </select>
        </div>

      <?php  } else { ?>

        <input type="hidden" name="type_location" value="<?php echo $_SESSION['user_location']; ?>">

      <?php } ?>
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
  $the_type_name = escape($_POST['type_name']);
  $type_location = escape($_POST['type_location']);
  $rack_rate = escape($_POST['rack_rate']);
  $type_location = escape($_POST['type_location']);
  $occupancy = escape($_POST['occupancy']);
  
  $room_image = $_FILES['room_image']['name'];
  $room_image_temp = $_FILES['room_image']['tmp_name'];

  move_uploaded_file($room_image_temp, "./room_img/$room_image");


  if (empty($room_image)) {
    $image_query = "SELECT * FROM room_type WHERE type_id = $type_id ";
    $selected_image = mysqli_query($connection, $image_query);

    while ($row = mysqli_fetch_assoc($selected_image)) {
      $room_image = $row['room_image'];
    }
  }


  $query = "UPDATE `room_type` SET `type_name` = '$the_type_name', `type_location` = '$type_location', `occupancy` = '$occupancy', `room_image` = '$room_image', `rack_rate` = '$rack_rate' WHERE `room_type`.`type_id` = $type_id;";
  $update = mysqli_query($connection, $query);

  if (!$update) {
    die('query falied' . mysqli_error($connection));
  } else {
    header("Location: acc.php");
  }
}
?>
<?php 

  if($_SESSION['user_role'] == 'RA'){
    header("Location: acc.php");
  }


?>

<form action="" method="post">
  <div class="form-group">
    <label for="cat_title">Edit Category</label>
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

        <input type="text" value="<?php if (isset($type_name)) {
                                    echo $type_name;
                                  } ?>" class="form-control" name="type_name" id="">

<div class="form-group">
            <label for="user_role"> Room price </label>
            <input type="text" value="<?php echo $room_price; ?>" class="form-control" name="room_price" id="">
          </div>
        <?php
        if ($_SESSION['user_location'] == 'admin') {
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

  </div>


  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="update_category" value="Update Accomodation">
  </div>
</form>
<?php
// Update category

if (isset($_POST['update_category'])) {
  $the_type_name = escape($_POST['type_name']);
  $type_location = escape($_POST['type_location']);
  $query = "UPDATE `room_type` SET `type_name` = '$the_type_name', `type_location` = '$type_location', `room_price` = '$room_price' WHERE `room_type`.`type_id` = $type_id;";
  $update = mysqli_query($connection, $query);

  if (!$update) {
    die('query falied' . mysqli_error($connection));
  } else {
    header("Location: acc.php");
  }
}
?>
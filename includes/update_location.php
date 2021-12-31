<form action="" method="post">
  <div class="form-group">
    <label for="cat_title">Edit location</label>
    <?php
    if (isset($_GET['edit'])) {
      $type_id = escape($_GET['edit']);
      $query = "SELECT * FROM locations WHERE location_id = {$type_id}";
      $result = mysqli_query($connection, $query);

      while ($row = mysqli_fetch_assoc($result)) {
        $location_id = $row['location_id'];
        $location_name = $row['location_name'];
    ?>

        <input type="text" value="<?php if (isset($location_name)) {
                                    echo  $location_name;
                                  } ?>" class="form-control" name="location_name" id="">


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
  $the_location_name = escape($_POST['location_name']);
  $query = "UPDATE `locations` SET `location_name` = '$the_location_name' WHERE `locations`.`location_id` = $type_id;";
  $update = mysqli_query($connection, $query);

  if (!$update) {
    die('query falied' . mysqli_error($connection));
  } else {
    header("Location: locations.php");
  }
}
?>
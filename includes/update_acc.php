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
    ?>

        <input type="text" value="<?php if (isset($type_name)) {
                                    echo $type_name;
                                  } ?>" class="form-control" name="type_name" id="">


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
  $query = "UPDATE `room_type` SET `type_name` = '$the_type_name' WHERE `room_type`.`type_id` = $type_id;";
  $update = mysqli_query($connection, $query);

  if (!$update) {
    die('query falied' . mysqli_error($connection));
  } else {
    header("Location: acc.php");
  }
}
?>
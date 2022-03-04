<?php
if (isset($_GET['edit'])) {
  $user_id = escape($_GET['edit']);


  $query = "SELECT * FROM users WHERE user_id = $user_id";

  $result = mysqli_query($connection, $query);

  confirm($result);

  while ($row = mysqli_fetch_assoc($result)) {
    $user_id = $row['user_id'];
    $user_name = $row['user_name'];
    $user_password = $row['user_pwd'];
    $user_firstname = $row['user_firstName'];
    $user_lastname =  $row['user_lastName'];
    $user_role = $row['user_role'];
    $user_location = $row['user_location'];
  }
}
if (isset($_POST['update_user'])) {
  $user_name = escape($_POST['user_name']);
  $user_password = escape($_POST['user_password']);
  $user_firstname = escape($_POST['user_firstname']);
  $user_lastname = escape($_POST['user_lastname']);
  $user_role = escape($_POST['user_role']);

  $query = "UPDATE `users` SET `user_name` = '$user_name', `user_pwd` = '$user_password', `user_firstName` = '$user_firstname', `user_lastName` = '$user_lastname', `user_role` = '$user_role' WHERE `users`.`user_id` = $user_id;";

  $update_post = mysqli_query($connection, $query);

  confirm($update_post);
  header("Location: ./users.php");
}
?>




<form action="" method="POST" class="col-6">

  <div class="form-group">
    <label for="user_firstname"> First Name</label>
    <input type="text" class="form-control" value="<?php echo $user_firstname; ?>" name="user_firstname">
  </div>

  <div class="form-group">
    <label for="user_lastname"> Last Name</label>
    <input type="text" class="form-control" value="<?php echo $user_lastname; ?>" name="user_lastname">
  </div>

  <?php 
    if($_SESSION['user_role'] == 'SA'){
      ?>

  <div class="form-group">
  <label for="user_lastname"> User Location</label>
    <select name="user_location" class="custom-select">
      <option value="<?php echo $user_location; ?>"><?php echo $user_location; ?></option>
      <?php

      $query = "SELECT * FROM locations";
      $result = mysqli_query($connection, $query);
      confirm($result);

      while ($row = mysqli_fetch_assoc($result)) {
        $location_id = $row['location_id'];
        $location_name = $row['location_name'];

        if($user_location != $location_name){
          echo "<option value='$location_name'>{$location_name}</option>";

        }

      }
      ?>
    </select>
  </div>

  <?php
    } else {
      ?> 
      <input type="hidden" name="user_location" value="<?php echo $_SESSION['user_location'] ?>">
      <?php 
    }
  ?>
  <div class="form-group">
    <label for="post_status"> User Role</label>
    <select name="user_role" class="custom-select" id="">
      <option value="RA">Reservation Agent</option>
      <option value="PA">Property Admin</option>
      <option value="SA">Super Admin</option>
    </select>
  </div>

  <div class="form-group">
    <label for="post_status"> User Name</label>
    <input type="text" class="form-control" name="user_name" value="<?php echo $user_name; ?>">
  </div>


  <div class="form-group">
    <label for="post_tags"> Password</label>
    <input type="password" class="form-control" value="<?php echo $user_password; ?>" name="user_password">
  </div>

  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="update_user" value="Update User">
  </div>
</form>
<?php
if (isset($_POST['create_user'])) {
  $user_name = escape($_POST['user_name']);
  $user_pwd = escape($_POST['user_password']);
  $user_firstname = escape($_POST['user_firstname']);
  $user_lastname = escape($_POST['user_lastname']);
  $user_email = escape($_POST['user_email']);
  $user_role = escape($_POST['user_role']);
  $user_location = escape($_POST['user_location']);
  $query = "INSERT INTO users(user_name, user_pwd, user_firstname, user_lastname, user_email, user_role, user_location ) ";
  $query .= "VALUES('$user_name','$user_pwd','$user_firstname','$user_lastname','$user_email','$user_role','$user_location' ) ";

  $user_result = mysqli_query($connection, $query);

  confirm($user_result);
  header("Location: ./users.php");
}



?>





<form action="" method="POST" class="col-6" enctype="multipart/form-data">

  <div class="form-group">
    <label for="user_firstname"> First Name</label>
    <input type="text" class="form-control" name="user_firstname">
  </div>

  <div class="form-group">
    <label for="user_lastname"> Last Name</label>
    <input type="text" class="form-control" name="user_lastname">
  </div>
  <div class="form-group ">
  <label for="user_lastname"> User Location</label>
    <select name="user_location" class="custom-select">
      <option value="">Select Option</option>
      <?php

      $query = "SELECT * FROM locations";
      $result = mysqli_query($connection, $query);
      confirm($result);

      while ($row = mysqli_fetch_assoc($result)) {
        $location_id = $row['location_id'];
        $location_name = $row['location_name'];

        echo "<option value='$location_name'>{$location_name}</option>";
      }
      ?>
    </select>
  </div>
  <div class="form-group">
    <label for="post_status"> User Role</label>
    <select name="user_role" class="custom-select" id="">
      <option value="agent">Agent</option>
    </select>
  </div>
  <div class="form-group">
    <label for="post_status"> User Name</label>
    <input type="text" class="form-control" name="user_name">
  </div>
  <div class="form-group">
    <label for="post_status"> Email</label>
    <input type="email" class="form-control" name="user_email">
  </div>


  <div class="form-group">
    <label for="post_tags"> Password</label>
    <input type="password" class="form-control" name="user_password">
  </div>

  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="create_user" value="Add User">
  </div>
</form>
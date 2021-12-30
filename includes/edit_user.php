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
    $user_email = $row['user_email'];
    $user_role = $row['user_role'];
  }
}
if (isset($_POST['update_user'])) {
  $user_name = escape($_POST['user_name']);
  $user_password = escape($_POST['user_password']);
  $user_firstname = escape($_POST['user_firstname']);
  $user_lastname = escape($_POST['user_lastname']);
  $user_email = escape($_POST['user_email']);
  $user_role = escape($_POST['user_role']);

  $query = "UPDATE `users` SET `user_name` = '$user_name', `user_pwd` = '$user_password', `user_firstName` = '$user_firstname', `user_lastName` = '$user_lastname', `user_email` = '$user_email', `user_role` = '$user_role' WHERE `users`.`user_id` = $user_id;";

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

  <div class="form-group">
    <label for="user_role"> Property </label> <br>
    <select name="user_role" class="custom-select" id="">
      <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
      <option value="Bishoftu">Bishoftu</option>
       <option value="Adama">Adama</option>
       <option value="Entoto">Entoto</option>
       <option value="Lake_Tana">Lake Tana</option>
       <option value="Awash">Awash</option>
       <option value="Boston">Boston</option>
    </select>
  </div>

  <div class="form-group">
    <label for="post_status"> User Name</label>
    <input type="text" class="form-control" name="user_name" value="<?php echo $user_name; ?>">
  </div>
  <div class="form-group">
    <label for="post_status"> Email</label>
    <input type="email" class="form-control" value="<?php echo $user_email; ?>" name="user_email">
  </div>


  <div class="form-group">
    <label for="post_tags"> Password</label>
    <input type="password" class="form-control" value="<?php echo $user_password; ?>" name="user_password">
  </div>

  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="update_user" value="Update User">
  </div>
</form>
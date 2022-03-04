<?php
if (isset($_POST['create_user'])) {
  $user_name = escape($_POST['user_name']);
  $user_pwd = escape($_POST['user_password']);
  // $user_Cpwd = escape($_POST['user_Cpassword']);
  $user_firstname = escape($_POST['user_firstname']);
  $user_lastname = escape($_POST['user_lastname']);
  // $user_email = escape($_POST['user_email']);
  $user_role = escape($_POST['user_role']);
  $user_location = escape($_POST['user_location']);


  $encryptePwd = password_hash($user_pwd, PASSWORD_BCRYPT, ['cost' => 10]);

  $query = "INSERT INTO users(user_name, user_pwd, user_firstname, user_lastname, user_role, user_location ) ";
  $query .= "VALUES('$user_name','$encryptePwd','$user_firstname','$user_lastname','$user_role','$user_location' ) ";

  $user_result = mysqli_query($connection, $query);

  confirm($user_result);
  header("Location: ./users.php");
}



?>





<form action="" id="userForm" method="POST" class="col-6" enctype="multipart/form-data">


  <div class="form-group">
    <label for="user_firstname"> First Name*</label>
    <input type="text" class="form-control" v-model="fname" name="user_firstname">
    <div v-if="msg.fname" class="mt-1 text-danger">{{ msg.fname }} </div>
  </div>

  <div class="form-group">
    <label for="user_lastname"> Last Name*</label>
    <input type="text" class="form-control" v-model="lname" name="user_lastname">
    <div v-if="msg.lname" class="mt-1 text-danger">{{ msg.lname }} </div>
  </div>
  <?php 
    if($_SESSION['user_role'] == 'SA'){
      ?>
      <div class="form-group ">
          <label for="user_lastname"> User Location*</label>
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
  <?php
    } else {
      ?> 
      <input type="hidden" name="user_location" value="<?php echo $_SESSION['user_location'] ?>">
      <?php 
    }
  ?>
 
  <div class="form-group">
    <label for="post_status"> User Role*</label>
    <select name="user_role" class="custom-select" id="">
      <option value="RA">Reservation Agent</option>
      <option value="PA">Property Admin</option>
      <option value="SA">Super Admin</option>

    </select>
  </div>
  <div class="form-group">
    <label for="post_status"> User Name*</label>
    <input type="text" v-model="uname" class="form-control" name="user_name">
    <div v-if="msg.uname || msg.Luname" class="mt-1 text-danger">{{ msg.uname }} {{ msg.Luname }} </div>
  </div>

  <div class="form-group">
    <label for="post_tags"> Password*</label>
    <input type="password" v-model="upwd" class="form-control" name="user_password">
    <div v-if="msg.password" class="mt-1">
      <span v-if="msg.password == 'Strong'" class="text-success">
        {{ msg.password }}
      </span>

      <span v-if="msg.password == 'Medium'" class="text-warning">
        {{ msg.password }}
      </span>
      <span v-if="msg.password == 'Weak'" class="text-danger">
        {{ msg.password }}
      </span>
    </div>
  </div>

  <div class="form-group">
    <label for="post_tags">Confirm Password*</label>
    <input type="password" v-model="ucpwd" class="form-control" name="user_Cpassword">
    <div v-if="msg.cperr" class="mt-1 text-danger">{{ msg.cperr }} </div>
  </div>
  <div class="form-group">
    <input type="submit" :disabled="button" class="btn btn-primary" name="create_user" value="Add User">
  </div>
</form>
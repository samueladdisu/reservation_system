<?php
if (isset($_GET['edit'])) {
  $user_id = escape($_GET['edit']);


  $query = "SELECT * FROM users WHERE user_id = $user_id";

  $result = mysqli_query($connection, $query);

  confirm($result);

  while ($row = mysqli_fetch_assoc($result)) {
    $user_id          = $row['user_id'];
    $user_name        = $row['user_name'];
    $user_password    = $row['user_pwd'];
    $user_firstname   = $row['user_firstName'];
    $user_lastname    =  $row['user_lastName'];
    $user_role        = $row['user_role'];
    $user_email       = $row['user_email'];
    $user_location    = $row['user_location'];
  }
}
if (isset($_POST['update_user'])) {

  $form_fname     = escape($_POST['user_firstname']);
  $form_lname     = escape($_POST['user_lastname']);
  $form_location  = escape($_POST['user_location']);
  $form_role      = escape($_POST['user_role']);
  $form_uname     = escape($_POST['user_name']);
  $form_uemail    = escape($_POST['user_email']);

  $pattern_fn = "/^[a-zA-Z ]{3,12}$/";

  // first name validation
  if (!preg_match($pattern_fn, $form_fname)) {
    $errFn = "Must be atleast 3 character long, letter and space allowed";
  }

  //last name validation

  if (!preg_match($pattern_fn, $form_lname)) {
    $errLn = "Must be atleast 3 character long, letter and space allowed";
  }

  //user name validation
  //at least 3 character, letter, number and underscore allowed

  $pattern_un = "/^[a-zA-Z0-9_]{3,16}$/";
  if (!preg_match($pattern_un, $form_uname)) {
    $errUn = "Must be atleast 3 character long, letter, number and underscore allowed";
  }

  //email validation
  // $pattern_ue = "/^([a-z0-9\+_\-]+)(\.[a-z0-9]\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/";

  if (!filter_var($form_uemail, FILTER_VALIDATE_EMAIL)) {
    $errUe = "Invalid Email";
  }

  if (!isset($errFn) && !isset($errLn) && !isset($errUn) && !isset($errUe)) {

    $update_query = "UPDATE users SET user_firstName = '$form_fname', user_lastName = '$form_lname', user_name = '$form_uname', user_email = '$form_uemail', user_location = '$form_location', user_role = '$form_role' WHERE user_id = $user_id";

    $update_result = mysqli_query($connection, $update_query);
    confirm($update_result);
    header("Location: ./users.php");
    echo "Successful";
  } else {
    echo "an error occured";
  }
}
?>




<form action="" method="POST" class="col-6">



  <div class="form-group">
    <label for="user_firstname"> First Name*</label>
    <input type="text" class="form-control" value="<?php echo isset($user_firstname) ? $user_firstname : ""; ?>" name="user_firstname">
    <!-- <div v-if="msg.fname" class="mt-1 text-danger">{{ msg.fname }} </div> -->
    <?php echo isset($errFn) ? "<div class='mt-1 text-danger'>{$errFn} </div>" : ""; ?>
  </div>

  <div class="form-group">
    <label for="user_lastname"> Last Name*</label>
    <input type="text" class="form-control" value="<?php echo isset($user_lastname) ? $user_lastname : ""; ?>" name="user_lastname">
    <!-- <div v-if="msg.lname" class="mt-1 text-danger">{{ msg.lname }} </div> -->
    <?php echo isset($errLn) ? "<div class='mt-1 text-danger'>{$errLn} </div>" : ""; ?>

  </div>
  <?php
  if ($_SESSION['user_role'] == 'SA') {
  ?>
    <div class="form-group ">
      <label> User Location*</label>
      <select name="user_location" value="<?php echo isset($user_location) ? $user_location : ""; ?>" class="custom-select">
        <option value="<?php echo isset($user_location) ? $user_location : ""; ?>"><?php echo isset($user_location) ? $user_location : ""; ?></option>
        <?php

        $query = "SELECT * FROM locations";
        $result = mysqli_query($connection, $query);
        confirm($result);

        while ($row = mysqli_fetch_assoc($result)) {
          $location_id = $row['location_id'];
          $location_name = $row['location_name'];
          if ($location_name != $user_location) {

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
    <label for="post_status"> User Role*</label>
    <select name="user_role" class="custom-select" id="">
      <option value="<?php echo isset($user_role) ? $user_role : ""; ?>">
        <?php
        if (isset($user_role)) {
          if ($user_role == 'RA') {
            echo "Reservation Agent";
          } else if ($user_role == 'PA') {
            echo "Property Admin";
          } else if ($user_role == 'SA') {
            echo "Super Admin";
          }
        } else {
          echo "-Select-";
        }
        ?>
      </option>
      <?php

      // if(empty($user_role)){

      // }

      if ($user_role == 'RA') {
        echo '<option value="PA">Property Admin</option>';
        echo '<option value="SA">Super Admin</option>';
      } else if ($user_role == 'PA') {
        echo '<option value="RA">Reservation Agent</option>';
        echo '<option value="SA">Super Admin</option>';
      } else if ($user_role == 'SA') {
        echo '<option value="RA">Reservation Agent</option>';
        echo '<option value="PA">Property Admin</option>';
      } else {
        echo '<option value="RA">Reservation Agent</option>';
        echo '<option value="PA">Property Admin</option>';
        echo '<option value="SA">Super Admin</option>';
      }

      ?>




    </select>
  </div>
  <div class="form-group">
    <label for="post_status"> User Name*</label>
    <input type="text" value="<?php echo isset($user_name) ? $user_name : ""; ?>" class="form-control" name="user_name">
    <!-- <div v-if="msg.uname || msg.Luname" class="mt-1 text-danger">{{ msg.uname }} {{ msg.Luname }} </div> -->
    <?php echo isset($errUn) ? "<div class='mt-1 text-danger'>{$errUn} </div>" : ""; ?>
  </div>

  <div class="form-group">
    <label for="post_status"> User Email*</label>
    <input type="text" value="<?php echo isset($user_email) ? $user_email : ""; ?>" class="form-control" name="user_email">

    <?php echo isset($errUe) ? "<div class='mt-1 text-danger'>{$errUe} </div>" : ""; ?>

  </div>

  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="update_user" value="Update User">
  </div>
</form>
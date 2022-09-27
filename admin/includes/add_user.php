<?php
if (isset($_POST['create_user'])) {
  $user_name = escape($_POST['user_name']);
  $user_pwd = escape($_POST['user_password']);
  $user_Cpwd = escape($_POST['user_Cpassword']);
  $user_firstname = escape($_POST['user_firstname']);
  $user_lastname = escape($_POST['user_lastname']);
  $user_email = escape($_POST['user_email']);
  $user_role = escape($_POST['user_role']);
  $user_location = escape($_POST['user_location']);

  $pattern_fn = "/^[a-zA-Z ]{3,12}$/";

  if($user_location != "Boston" && $user_role == "SA"){
    echo "<script> alert('To be a superadmin, Location must be Boston.') </script>";
  } else {

    // first name validation
    if(!preg_match($pattern_fn, $user_firstname)){
      $errFn = "Must be atleast 3 character long, letter and space allowed";
    }
  
    //last name validation
  
    if(!preg_match($pattern_fn, $user_lastname)){
      $errLn = "Must be atleast 3 character long, letter and space allowed";
    }
  
    //user name validation
    //at least 3 character, letter, number and underscore allowed
  
    $pattern_un = "/^[a-zA-Z0-9_]{3,16}$/";
    if (!preg_match($pattern_un, $user_name)) {
      $errUn = "Must be atleast 3 character long, letter, number and underscore allowed";
    }
  
    //email validation
  
    
  
    // $pattern_ue = "/^([a-z0-9\+_\-]+)(\.[a-z0-9]\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/";
  
    if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
      $errUe = "Invalid Email";
    }
  
  
    if($user_pwd == $user_Cpwd){
      $pattern_up = "/^.*(?=.{4,56})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/";
  
      if(!preg_match($pattern_up, $user_pwd)){
        $errPass = "Must be atleast 4 character long, 1 upper case, 1 lower case letter and 1 number";
  
      }
    }
    
  
    if(!isset($errFn) && !isset($errLn) && !isset($errUn) && !isset($errUe) && !isset($errPass)) {
      $email_query = "SELECT * FROM users WHERE user_email = '$user_email'";
      $email_result = mysqli_query($connection, $email_query);
      confirm($email_result);
  
      $email_count = mysqli_num_rows($email_result);
  
      if(!empty($email_count)){
        echo '<script> alert("Email already exist") </script>';
      }
  
      $userName_query = "SELECT * FROM users WHERE user_name = '$user_name'";
      $userName_result= mysqli_query($connection, $userName_query);
  
      confirm($userName_result);
  
      $username_count = mysqli_num_rows($userName_result);
  
      if(!empty($username_count)){
        echo '<script> alert("User Name already exist") </script>';
      }
  
    
      if(empty($email_count) && empty($username_count)){
  
        $encryptePwd = password_hash($user_pwd, PASSWORD_BCRYPT, ['cost' => 10]);
      
        $query = "INSERT INTO users(user_firstName,user_lastName, user_name, user_email, user_pwd,user_location, user_role, user_date) ";
        $query .= "VALUES('$user_firstname', '$user_lastname', '$user_name', '$user_email', '$encryptePwd','$user_location','$user_role', now()) ";
      
        $user_result = mysqli_query($connection, $query);
      
        confirm($user_result);
        header("Location: ./users.php");
      }
    }
  }
}



?>





<form action="" id="userForm" method="POST" class="col-6" enctype="multipart/form-data">


  <div class="form-group">
    <label for="user_firstname"> First Name*</label>
    <input type="text" class="form-control" value="<?php echo isset($user_firstname) ? $user_firstname: ""; ?>" name="user_firstname">
    <!-- <div v-if="msg.fname" class="mt-1 text-danger">{{ msg.fname }} </div> -->
    <?php echo isset($errFn) ? "<div class='mt-1 text-danger'>{$errFn} </div>": ""; ?>
  </div>

  <div class="form-group">
    <label for="user_lastname"> Last Name*</label>
    <input type="text" class="form-control" value="<?php echo isset($user_lastname) ? $user_lastname: ""; ?>" name="user_lastname">
    <!-- <div v-if="msg.lname" class="mt-1 text-danger">{{ msg.lname }} </div> -->
    <?php echo isset($errLn) ? "<div class='mt-1 text-danger'>{$errLn} </div>": ""; ?>
    
  </div>
  <?php 
    if($_SESSION['user_role'] == 'SA'){
      ?>
      <div class="form-group ">
          <label for="user_lastname"> User Location*</label>
          <select name="user_location" class="custom-select">
          <option value="<?php echo isset($user_location) ? $user_location: ""; ?>"><?php echo isset($user_location) ? $user_location: "-Select-"; ?></option>
            <?php

            $query = "SELECT * FROM locations";
            $result = mysqli_query($connection, $query);
            confirm($result);

            while ($row = mysqli_fetch_assoc($result)) {
              $location_id = $row['location_id'];
              $location_name = $row['location_name'];
              if($location_name != $user_location){

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
      <option value="<?php echo isset($user_role) ? $user_role: ""; ?>">
      <?php 
      if(isset($user_role)){
        if($user_role == 'RA'){
          echo "Reservation Agent";
        }else if($user_role == 'PA'){
          echo "Property Admin";
        }else if($user_role == 'SA'){
          echo "Super Admin";
        }
      }else{
          echo "-Select-";
        }
      ?>
      </option>
      <?php 

        // if(empty($user_role)){
          
        // }

        if ($_SESSION['user_role'] == 'SA' && $_SESSION['user_location'] == 'Boston') { 

          if($user_role == 'RA'){
            echo '<option value="PA">Property Admin</option>';
            echo '<option value="SA">Super Admin</option>';
          }else if($user_role == 'PA'){
            echo '<option value="RA">Reservation Agent</option>';
            echo '<option value="SA">Super Admin</option>';
          }else if($user_role == 'SA'){
            echo '<option value="RA">Reservation Agent</option>';
            echo '<option value="PA">Property Admin</option>';
          }else{
            echo '<option value="RA">Reservation Agent</option>';
            echo '<option value="PA">Property Admin</option>';
            echo '<option value="SA">Super Admin</option>';
          }

        } else {
          if($user_role == 'RA'){
            echo '<option value="PA">Property Admin</option>';
          }else if($user_role == 'PA'){
            echo '<option value="RA">Reservation Agent</option>';
          }else{
            echo '<option value="RA">Reservation Agent</option>';
            echo '<option value="PA">Property Admin</option>';
          }
        }

      
      ?>
      
      
      

    </select>
  </div>
  <div class="form-group">
    <label for="post_status"> User Name*</label>
    <input type="text" value="<?php echo isset($user_name) ? $user_name: ""; ?>" class="form-control" name="user_name">
    <!-- <div v-if="msg.uname || msg.Luname" class="mt-1 text-danger">{{ msg.uname }} {{ msg.Luname }} </div> -->
    <?php echo isset($errUn) ? "<div class='mt-1 text-danger'>{$errUn} </div>": ""; ?>
  </div>

  <div class="form-group">
    <label for="post_status"> User Email*</label>
    <input type="text" value="<?php echo isset($user_email) ? $user_email: ""; ?>" class="form-control" name="user_email">
    <!-- <div v-if="msg.email" class="mt-1 text-danger">
      {{ msg.email }}
    </div> -->
    <?php echo isset($errUe) ? "<div class='mt-1 text-danger'>{$errUe} </div>": ""; ?>

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

    <?php echo isset($errPass) ? "<div class='mt-1 text-danger'>{$errPass} </div>": ""; ?>
  </div>

  <div class="form-group">
    <label for="post_tags">Confirm Password*</label>
    <input type="password" v-model="ucpwd" class="form-control" name="user_Cpassword">
    <div v-if="msg.cperr" class="mt-1 text-danger">{{ msg.cperr }} </div>
  </div>
  <div class="form-group">
    <input type="submit" :disabled="button" class="btn btn-primary" name="create_user" value="Add User">

    <!-- <input type="submit" class="btn btn-primary" name="create_user" value="Add User"> -->
  </div>
</form>
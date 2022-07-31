<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php session_start(); ?>


<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>New Password - Kuriftu Reservation System</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

  <?php 
  date_default_timezone_set("Africa/Addis_Ababa");

    if(isset($_GET['eid']) && isset($_GET['token']) && isset($_GET['exd'])) {

      $user_email = urldecode(base64_decode($_GET['eid']));
      $validation_key = urldecode(base64_decode($_GET['token']));
      $expire_date = urldecode(base64_decode($_GET['exd']));

      $current_date = date("Y-m-d H:i:s");

      if($expire_date <= $current_date) {
        echo "<script> Sorry This link is expired! </script>";
      } else {

        if( isset($_POST['new_pasword'])){
          $user_pwd = escape($_POST['pwd']);
          $user_Cpwd= escape($_POST['confirm_pwd']);

          if($user_pwd == $user_Cpwd){
            $pattern_up = "/^.*(?=.{4,56})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/";
        
            if(!preg_match($pattern_up, $user_pwd)){
              $errPass = "Must be atleast 4 character long, 1 upper case, 1 lower case letter and 1 number";
        
            }

            if(!isset($errPass)){

              $encrypted_pwd = password_hash($user_pwd, PASSWORD_BCRYPT, ['cost' => 10]);
  
              $update_password_query = "UPDATE users SET user_pwd = '$encrypted_pwd' WHERE user_validation = '$validation_key' AND user_email = '$user_email'";
  
              $update_password_result = mysqli_query($connection, $update_password_query);
              confirm($update_password_result);

              // UPDATE VALIDATION KEY SO THE LINK WILL WORK ONCE

              $update_validation = "UPDATE users SET user_validation = 0 WHERE user_email = '$user_email' AND user_validation = '$validation_key'";

              $validation_result = mysqli_query($connection, $update_validation);
              confirm($validation_result);
              echo "<script> alert('Password successfully updated') </script>";
              header("Refresh: 2; url=index.php");
            }


          } else {
            $errPass = "Password dosen't matched";
          }

        }
      }

    } else {
      echo "<script> alert(Something went wrong) </script>";
    }


?>
    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-6 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row justify-content-center">

              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">New password</h1>
                  </div>
                  <form class="user" action="" method="POST">
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="pwd" placeholder="New Password" required>
                      <?php echo isset($errPass) ? "<div class='mt-1 text-danger'>{$errPass} </div>": ""; ?>
                    </div>
                    <div class="form-group">
                      <input type="password" name="confirm_pwd" class="form-control form-control-user" id="exampleInputPassword" placeholder="Confirm Password" required>
                    </div>
                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Login" name="new_pasword">

                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
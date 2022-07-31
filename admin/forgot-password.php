<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php session_start(); ?>

<?php require '../admin_config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Forgot password- Kuriftu Reservation System</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-6 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                    <p class="mb-4">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</p>
                  </div>

                  <?php
                  date_default_timezone_set("Africa/Addis_Ababa");
                  if (isset($_POST['reset_password'])) {
                    $recover_email = escape($_POST['email']);

                    $query = "SELECT * FROM users WHERE user_email = '$recover_email'";
                    $result = mysqli_query($connection, $query);

                    confirm($result);

                    if (mysqli_num_rows($result) == 1) {
                      echo "<script> alert('User Found')</script>";
                      if (!isset($_COOKIE['_unp_'])) {

                        $token =  getToken(32);
                        $encode_token = base64_encode(urlencode($token));
                        $expire_date = date("Y-m-d H:i:s", time() + 60 * 20);
                        $expire_date = base64_encode(urlencode($expire_date));
                        $email = base64_encode(urlencode($recover_email));

                        // RECIPIENT 
                        // $mail->addAddress($recover_email);

                        $query = "UPDATE users SET user_validation = '$token' WHERE user_email = '$recover_email'";

                        $query_con = mysqli_query($connection, $query);
                        confirm($query_con);


                        $mg->messages()->send($_ENV['MAILGUN_DOMAIN'], [
                          'from'    => 'no-reply@kurifturesorts.com',
                          'to'      => $recover_email,
                          'subject' => 'Password reset request',
                          'html'    =>  "<h2> Follow the link to reset password</h2>
                          <a href='http://localhost/reservation_system/admin/new_password.php?eid={$email}&token={$encode_token}&exd={$expire_date}'> Click here to create new password</a>
                          <p> This link is valid for 20 minutes </p>"


                        ]);

                        setcookie('_unp_', getToken(16), time() + 60 * 20, '', '', '', true);
                      } else {
                        echo json_encode("20");
                      }
                    } else {
                      echo "<script> alert('User Not Found')</script>";
                    }
                  }

                  ?>
                  <form class="user" action="" method="POST">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" name="email" placeholder="Enter Email Address...">
                    </div>

                    <div class="form-group">
                      <input type="submit" name="reset_password" class="btn btn-primary btn-user btn-block" value="Reset Password">
                    </div>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="./">Already have an account? Login!</a>
                  </div>
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
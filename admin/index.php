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

  <title>Login - Kuriftu Reservation System</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">


  <?php

  if (isset($_POST['login'])) {
    $user_email =  escape($_POST['user_email']);
    $user_password = escape($_POST['user_password']);

    $query = "SELECT * FROM users WHERE user_email = '$user_email' ";
    $select_user = mysqli_query($connection, $query);

    confirm($select_user);

    $row = mysqli_num_rows($select_user);

    if (!empty($row)) {
      while ($data = mysqli_fetch_assoc($select_user)) {
        //  if (password_verify($user_password, $data['user_pwd']))
        // if ($user_password == $data['user_pwd'])
        if (password_verify($user_password, $data['user_pwd'])) {

          $_SESSION['user_id']  = $data['user_id'];
          $_SESSION['username'] = $data['user_name'];
          $_SESSION['firstname'] = $data['user_firstName'];
          $_SESSION['lastname'] = $data['user_lastName'];
          $_SESSION['user_role'] = $data['user_role'];
          $_SESSION['user_location'] = $data['user_location'];
          $_SESSION['ticket_token'] = $data['ticket_token'];

          header("Location: ./dashboard.php");
        } else {
          echo "<script> alert('Incorrect password') </script>";
        }
      }
    } else {
      echo "<script> alert('Incorrect Email or password') </script>";
    }
  }






  ?>

  <div class="container">

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
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form class="user" action="" method="POST">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="exampleInputEmail" name="user_email" value="<?php echo isset($user_email) ? $user_email : ""; ?>" aria-describedby="emailHelp" placeholder="Enter Email..." required>
                    </div>
                    <div class="form-group">
                      <input type="password" name="user_password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember
                          Me</label>
                      </div>
                    </div>
                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Login" name="login">

                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.php">Forgot Password?</a>
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
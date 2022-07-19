<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php session_start(); ?>

<?php

if (isset($_GET['change'])) {
  $id = escape($_GET['change']);

  $query = "SELECT * FROM users WHERE user_id = $id";
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

if(isset($_POST['check_password'])){
  $form_pwd = escape($_POST['password']);

  if(password_verify($form_pwd, $user_password)){
    header("Location: change_pwd.php?id=$id");
  }else {
    echo "<script> alert('Incorrect password') </script>";
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Change password- Kuriftu Reservation System</title>

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
                    <h1 class="h4 text-gray-900 mb-2">Change Your Password</h1>
                  </div>
                  <form class="user" action="" method="POST">
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="password" placeholder="Enter Old Password">
                    </div>

                    <div class="form-group">
                      <input type="submit" name="check_password" class="btn btn-primary btn-user btn-block" value="Submit">
                    </div>
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
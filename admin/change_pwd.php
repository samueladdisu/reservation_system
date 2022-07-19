<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php session_start(); ?>

<?php

$id = $_GET['id'];

if (isset($_POST['change_password'])) {
  $form_pwd = escape($_POST['pwd']);
  $form_cpwd = escape($_POST['Cpwd']);

  if ($form_pwd == $form_cpwd) {
    $pattern_up = "/^.*(?=.{4,56})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/";

    if (!preg_match($pattern_up, $form_pwd)) {
      $errPass = "Must be atleast 4 character long, 1 upper case, 1 lower case letter and 1 number";
    }
    echo "outer";
    if(!isset($errPass)){
      $encryptePwd = password_hash($form_pwd, PASSWORD_BCRYPT, ['cost' => 10]);
      $update_password_query = "UPDATE users SET user_pwd = '$encryptePwd' WHERE user_id = $id";
      $update_password_result = mysqli_query($connection, $update_password_query);

      confirm($update_password_result);

      header("Location: dashboard.php");
    }
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
                  <form class="user" id="change_password" action="" method="POST">
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" v-model="upwd" name="pwd" placeholder="Enter New Password">

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
                      <?php echo isset($errPass) ? "<div class='mt-1 text-danger'>{$errPass} </div>" : ""; ?>
                    </div>

                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" v-model="ucpwd" name="Cpwd" placeholder="Re-enter New Password">
                      <div v-if="msg.cperr" class="mt-1 text-danger">{{ msg.cperr }} </div>
                    </div>

                    <div class="form-group">
                      <input type="submit" name="change_password" class="btn btn-primary btn-user btn-block" 
                      :disabled="button" value="Change Password">
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
  <script src="https://unpkg.com/vue@3.0.2"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <script>
    let strongPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})')
    let mediumPassword = new RegExp('((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))')
    const changePassword = Vue.createApp({
      data() {
        return {
          upwd: '',
          ucpwd: '',
          msg: [],
          button: true
        }
      },
      watch: {
        upwd(value) {
          this.upwd = value
          this.validatePassword(value)
        },
        ucpwd(value) {
          this.ucpwd = value
          this.checkPassword(value)
        },
      },
      methods: {
        validatePassword(value) {
          if (strongPassword.test(value)) {
            this.msg['password'] = 'Strong'
          } else if (mediumPassword.test(value)) {
            this.msg['password'] = 'Medium'
          } else {
            this.msg['password'] = 'Weak'
          }
        },
        checkPassword(value) {
          if (this.ucpwd !== this.upwd) {
            this.msg['cperr'] = 'Password doesn\'t match'
          } else {
            this.msg['cperr'] = ''
            if (this.msg.length == 0) {
              this.button = !this.button
            }
          }

        },
      }

    }).mount('#change_password')
  </script>

</body>

</html>
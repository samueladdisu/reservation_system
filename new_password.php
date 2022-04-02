<?php include  'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Password - Kuriftu Resorts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
  <section class="signup-header">

    <div class="container">
      <nav class="nav-center">
        <div class="signup-menu">
          <div class="line1"></div>
          <div class="line2"></div>
        </div>
        <div class="logo">
          <img src="./img/black_logo.svg" alt="">
        </div>

        <div class="book-now">
          <a href="#" class="btn btn-outline-black ">Book Now</a>
        </div>
      </nav>
    </div>
  </section>

  <section class="main-body">
    <h1 class="caps text-center">New Password </h1>
    <div class="container" id="signin-wiget">

      <?php

      if (isset($_GET['eid']) && isset($_GET['token']) && isset($_GET['exd'])) {

        date_default_timezone_set("Africa/Addis_Ababa");

        $email =  urldecode(base64_decode($_GET['eid']));
        $validation_key =  urldecode(base64_decode($_GET['token']));
        $expire =  urldecode(base64_decode($_GET['exd']));

        $current_date = date("Y-m-d H:i:s");

        if($expire <= $current_date) {
          echo "<script> alert('link expired')</script>";
        } else {

          if(isset($_POST['submit'])) {
            $pwd  = escape($_POST['nPwd']);
            $cpwd = escape($_POST['cnPwd']);

            if($pwd == $cpwd){
              $pattern_up = "/^.*(?=.{4,56})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/";
  
              if(!preg_match($pattern_up, $pwd)){
                $errPwd = "Must be at least 4 character long, 1 upper case, 1 lower case letter and 1 number exist";
                echo "<script> alert('$errPwd')</script>";
              }
  
            } else {
              $errPwd = 'password does not match';

              echo "<script> alert('$errPwd')</script>";
            }

            if(!isset($errPwd)){
              $query = "SELECT * FROM members WHERE m_email = '$email' AND m_validationKey = '$validation_key' AND is_active = 1";
              $result = mysqli_query($connection, $query);
  
              confirm($result);
  
              if(mysqli_num_rows($result) == 1){
  
                $password = password_hash($pwd, PASSWORD_BCRYPT, ['cost' => 10]);
                $query1 = "UPDATE members SET m_pwd = '$password' WHERE m_validationKey = '$validation_key' AND is_active = 1";
  
                $result1 = mysqli_query($connection, $query1);
  
                confirm($result1);

                echo "<script> alert('New password successfully created')</script>";
                header("Location: signIn.php");
              }

            }
          }
        }

      } else {

        echo "<script> alert('Something went wrong')</script>";
      }

      
        
   

      ?>

      <form action="" method="POST" class="signup-form signin-form">


        <div class="form-group">
          <div class="inner-form">
            <div class="input-container">
              <img src="./img/view.svg" @click="showPwd" alt="">
              <input type="password" name="nPwd" v-model="password" ref="pwd" placeholder="New Password" required>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="inner-form">
            <div class="input-container">

              <input type="password" ref="cpwd" name="cnPwd" placeholder="Confirm New Password" required>
            </div>
          </div>
        </div>

        <button type="submit" name="submit" class="btn btn-secondary">
          Change Password
        </button>


      </form>

      <div class="kuriftu-modal" v-if="success">
        <div class="kuriftu-modal-content">
          <div class="success-circle">
            <img src="./img/check.svg" alt="">
          </div>

          <div class="kmodal-body">
            <h5 class="k-modalHeader">
              Success
            </h5>
            <p class="k-modalBody" ref="data">
            <div v-html="succ"></div>
            </p>

            <button @click="closeSuccess" style="background: #45b75c;" class="btn">
              OK
            </button>
          </div>
        </div>
      </div>


      <div class="kuriftu-modal" v-if="modal">
        <div class="kuriftu-modal-content">
          <div class="close-circle" @click="closeModal">
            <img src="./img/X.svg" alt="">
          </div>

          <div class="kmodal-body">
            <h5 class="k-modalHeader">
              Sorry!
            </h5>
            <p class="k-modalBody" ref="data">
            <div v-html="msg"></div>
            <div @click='verify' style="color: #6945a8; text-decoration: underline; cursor: pointer; margin-top: 0.5rem;" class="ver" v-if="ver">
              {{ ver }}
            </div>
            </p>

            <button @click="closeModal" class="btn btn-secondary">
              OK
            </button>
          </div>
        </div>
      </div>

    </div>
  </section>



  <?php include_once './includes/footer.php' ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const app = Vue.createApp({
      data() {
        return {}
      },
      methods: {
        showPwd() {
          if (this.$refs.pwd.type == "password") {
            this.$refs.pwd.type = "text"
          } else {
            this.$refs.pwd.type = "password"
          }
        },
        showcPwd() {
          if (this.$refs.cpwd.type == "password") {
            this.$refs.cpwd.type = "text"
          } else {
            this.$refs.cpwd.type = "password"
          }
        }
      }
    })

    app.mount('#signin-wiget')
  </script>
</body>

</html>
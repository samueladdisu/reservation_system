<?php include  'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In - Kuriftu Resorts</title>
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
    <h1 class="caps text-center">Sign In </h1>
    <div class="container" id="signin-wiget">

      <?php

      if (isset($_POST['login'])) {
        $email = escape($_POST['email']);
        $pwd = escape($_POST['pwd']);

        $query = "SELECT * FROM members WHERE m_email = '$email' AND is_active = 1";
        $result = mysqli_query($connection, $query);

        confirm($result);

        $row = mysqli_fetch_assoc($result);
        //  echo $row['m_email'];
        if (!empty($row['m_email'])) {
          if (password_verify($pwd, $row['m_pwd'])) {
            $login = $_SESSION['login'] = "success";
            $_SESSION['m_username'] = $row['m_username'];
            header("Location: ./reserve.php");
          } else {
      ?>

           {{ showModal() }}
             
             
           
      <?php
          }
        }
      }


      ?>

      <form action="" method="post" class="signup-form signin-form">


        <div class="form-group ">
          <div class="inner-form">
            <input type="email" placeholder="Email" name="email" required>
          </div>
        </div>
        <div class="form-group">
          <div class="inner-form">
            <div class="input-container">
              <img src="./img/view.svg" @click="showPwd" alt="">
              <input type="password" ref="pwd" placeholder="Password" name="pwd" required>
            </div>
          </div>
        </div>

        <button type="submit" name="login" class="btn btn-secondary">
          Sign Up
        </button>
        <p class="bottom-form">
          Don't have an account? <a href="http://localhost/reservation_system/signUp.php">Sign up</a>
        </p>

      </form>


    </div>
  </section>

  <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
       
        <div class="modal-body text-center text-danger">
         Incorrect Email or Password.
        </div>

      </div>
    </div>
  </div>

  <?php include_once './includes/footer.php' ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
     var myModal = new bootstrap.Modal(document.getElementById('successModal'), {
                keyboard: false
              })
    const app = Vue.createApp({
      data() {
        return {
          email: '',
          pwd: ''
        }
      },
      methods: {
        showModal(){
          myModal.show()
        },
        showPwd() {
          if (this.$refs.pwd.type == "password") {
            this.$refs.pwd.type = "text"
          } else {
            this.$refs.pwd.type = "password"
          }
        }
      }
    })

    app.mount('#signin-wiget')
  </script>
</body>

</html>
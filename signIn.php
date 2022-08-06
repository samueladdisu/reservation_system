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
  <header class="header reserve-header">
    <div class="container">
      <nav class="nav-center">

        <div class="logo">
          <img src="./img/black_logo.svg" alt="">
        </div>
        <div class="line">
          <div class="container1">
            <hr class="line1">
            <ul class="justify-list">

              <li>
                <a class="link-text" href="./">Back to Resorts</a>
              </li>
              <li>
                <a class="link-text" href="./signUp.php">Sign Up</a>
              </li>
              <li>
                <a class="link-text" href="./signIn.php">Login</a>
              </li>
            </ul>


            <hr class="line2">
          </div>
        </div>


        <?php

        if (isset($_SESSION['m_username'])) {
          $user_name =  $_SESSION['m_username'];
        ?>
          <div class="profile">
            <div @click="showDropdown" class="profile-icon">
              <h1 class="profile-name">
                SA
              </h1>

            </div>

            <div v-if="dropdown" class="drop-down">
              <ul>
                <li><a href="./profile.php"> <i class="fa-solid fa-user"></i> Profile</a></li>
                <li> <a href="./logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log out</a></li>
              </ul>
            </div>
          </div>

        <?php
        } else {
          $user_name = null;
        ?>



        <?php
        }

        ?>


      </nav>



    </div>
  </header>

  <section class="main-body" style="height: 60vh">
    <h1 class="caps text-center">Sign In </h1>
    <div class="container" id="signin-wiget">

      <form @submit.prevent="submitForm" class="signup-form signin-form">


        <div class="form-group ">
          <div class="inner-form">
            <input type="email" v-model="email" placeholder="Email" ref="eml" required>
          </div>
        </div>
        <div class="form-group">
          <div class="inner-form">
            <div class="input-container">
              <img src="./img/view.svg" @click="showPwd" alt="">
              <input type="password" v-model="password" ref="pwd" placeholder="Password" required>
            </div>
          </div>
        </div>

        <button type="submit" name="login" class="btn btn-secondary">
          Sign In
        </button>
        <p class="bottom-form">
          Don't have an account? <a href="https://reservations.kurifturesorts.com/signUp.php">Sign up</a>
          <br> <br>
          Or <a href="https://reservations.kurifturesorts.com/forgot_password.php">Forgot password</a>

        </p>


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

  <footer>
    <div class="container">
      <img src="./img/black_logo.svg" alt="">
      <p>All Copyright &copy; 2022 Kuriftu Resort and Spa. Powered by <a href="https://versavvymedia.com/" target="_blank">Versavvy</a></p>
    </div>

  </footer>

  <?php include_once './includes/footer.php' ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const app = Vue.createApp({
      data() {
        return {
          email: '',
          password: '',
          msg: '',
          succ: '',
          modal: false,
          success: false,
          ver: ''
        }
      },
      methods: {
        async submitForm() {
          await axios.post('member.php', {
            action: 'submit',
            email: this.email,
            password: this.password
          }).then(res => {
            console.log(res.data);
            if (res.data == "P") {
              this.msg = "Incorrect Password. Please try again"
              this.modal = true
            } else if (res.data == "E") {
              this.msg = "Email Not Found. Please try again"
              this.modal = true
            } else if (res.data == "V") {
              this.msg = "You are not verified member."
              this.ver = "Click here to verify"
              this.modal = true
            } else if (res.data == "In") {
              window.location.href = "profile.php"
            }
          })
        },
        async verify() {
          await axios.post('member.php', {
            action: 'verify',
            email: this.email,
            pwd: this.password
          }).then(res => {
            console.log(res.data);
            console.log("hellow");

            if (res.data == "check_email") {
              this.modal = false
              this.success = true
              this.succ = "Check your email for activation link"
            }
          })
        },
        closeSuccess() {
          this.success = false
        },
        closeModal() {
          this.modal = false
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
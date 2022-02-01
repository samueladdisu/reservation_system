<?php include  'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up - Kuriftu Resorts</title>
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
    <h1 class="caps text-center">Become a member </h1>
    <div class="container" id="form-wiget">

      <form @submit.prevent="submitForm" class="signup-form">
        <div class="form-group">

          <div class="inner-form">
            <input type="text" placeholder="First Name" v-model="form.fName" required>
            <!-- <p>{{ fNError }}</p> -->

          </div>

          <div class="inner-form">
            <input type="text" placeholder="Last Name" v-model="form.lName" required>
            <p></p>
          </div>



        </div>

        <div class="form-group">
          <div class="inner-form">
            <input type="email" placeholder="Email" v-model="form.email" required>
            <!-- <p>{{ emailError }}</p> -->
          </div>
          <div class="inner-form">
            <input type="text" placeholder="Phone" v-model="form.phone" required>

          </div>


        </div>

        <div class="form-group">
          <div class="inner-form">
            <input type="date" v-model="form.dob" required>
            <!-- <p>Last Name is required!</p> -->
          </div>
          <div class="inner-form">
            <select v-model="form.mType" required>
              <option disabled value="">Choose Membership Type</option>
              <option value="vip">VIP</option>
              <option value="normal"> Normal</option>
            </select>
          </div>

        </div>

        <div class="form-group">
          <div class="inner-form">
            <input type="text" placeholder="User Name" v-model="form.uName" required>
            <!-- <p>User name is required!</p> -->
          </div>
          <div class="inner-form">
            <input type="text" placeholder="Company Name" v-model="form.cName">
            <p></p>
          </div>


        </div>


        <div class="form-group">
          <div class="inner-form">
            <div class="input-container">
              <img src="./img/view.svg" @click="showPwd" alt="">
              <input type="password" ref="pwd" placeholder="Password" v-model="form.pwd" @blur="checkPwd">
            </div>
            <p v-if="pwdError">{{ pwdError }}</p>
          </div>
          <div class="inner-form">
            <div class="input-container">
            <img src="./img/view.svg" alt="">
              <input type="password" placeholder="Confirm Password"  ref="cPwd" v-model="cPwd" @blur="confirmPwd" required>
            </div>
            <p>{{ cPwdError }}</p>
          </div>

        </div>

        <button class="btn btn-secondary">
          Sign Up
        </button>
        <p class="bottom-form">
          Already have an account? <a href="#">Sign up</a>
        </p>

      </form>


    </div>
  </section>

  <?php include_once './includes/footer.php' ?>
  <script src="./js/signup.js" type="module"></script>
</body>

</html>
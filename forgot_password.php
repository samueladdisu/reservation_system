<?php include  'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recover Password - Kuriftu Resorts</title>
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
    <h1 class="caps text-center">Recover Password</h1>
    <div class="container" id="recover-wiget">

      <!-- Modals  -->
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

      <!-- End of Modals -->
      <form action="" @submit.prevent="recoverSubmit" method="post" class="signup-form signin-form">



        <div class="form-group ">
          <div class="inner-form">
            <input type="email" placeholder="Email" v-model="email" required>
          </div>
        </div>


        <button type="submit" name="pwd_recovery" class="btn btn-secondary">
          Recover Password
        </button>
      </form>


    </div>
  </section>

  <?php include_once './includes/footer.php' ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const app = Vue.createApp({
      data() {
        return {
          email: '',
          succ: '',
          modal: false,
          success: false,
          ver: '',
          msg: ''
        }
      },
      methods: {
        async recoverSubmit() {
          await axios.post('member.php', {
            action: 'recover',
            email: this.email
          }).then(res => {
            console.log(res.data);
            if(res.data == 'new_pwd'){
              this.succ = "Check your email for password reset"
              this.success = true
            }else if(res.data == '20'){
              this.msg = "You Should wait atleast 20 minutes for another request"
              this.modal = true
            } else{
              this.msg = "User not found"
              this.modal = true
            }
          })
        },
        closeSuccess() {
          this.success = false
        },
        closeModal() {
          this.modal = false
        },
      }
    })

    app.mount('#recover-wiget')
  </script>
</body>

</html>
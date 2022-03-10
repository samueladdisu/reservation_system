<?php include  'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

  <link rel="stylesheet" href="css/t-datepicker.min.css">
  <link rel="stylesheet" href="css/themes/t-datepicker-green.css">
  <link rel="stylesheet" href="./css/style.css">

  <title>Reservation</title>
</head>

<body>
  <div id="app">
  <header class="header">
    <div class="container">
      <nav class="nav-center">
        <div class="menu">
          <div class="line1"></div>
          <div class="line2"></div>
        </div>
        <div class="logo">
          <img src="./img/Kuriftu_logo.svg" alt="">
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
          <div class="login">
            <a href="./signIn.php" class="btn-primary1 mx-2">Log In</a>
            <a href="./signUp.php" class="btn-secondary2">Sign Up</a>
          </div>


        <?php
        }

        ?>


      </nav>

      <div class="side-socials">
        <img src="./img/facebook.svg" alt="">
        <img src="./img/instagram.svg" alt="">
        <img src="./img/youtube.svg" alt="">
      </div>

    </div>
  </header>

  <div class="container">
    <form class="myform" @submit.prevent="submitData">
      <div class="t-datepicker col-6">
        <div class="t-check-in">
          <div class="t-dates t-date-check-in">
            <label class="t-date-info-title">Check In</label>
          </div>
          <input type="hidden" class="t-input-check-in" name="start">
          <div class="t-datepicker-day">
            <table class="t-table-condensed">
              <!-- Date theme calendar -->
            </table>
          </div>
        </div>
        <div class="t-check-out">
          <div class="t-dates t-date-check-out">
            <label class="t-date-info-title">Check Out</label>
          </div>
          <input type="hidden" class="t-input-check-out" name="end">
        </div>
      </div>

      <div class="">
        <select class="mySelect" v-model="desti">
          <option disabled value="">Choose Destination</option>
          <?php

          $query = "SELECT * FROM locations";
          $result = mysqli_query($connection, $query);

          confirm($result);

          while ($row = mysqli_fetch_assoc($result)) {
            $location_id = $row['location_id'];
            $location_name = $row['location_name'];
          ?>
            <option value='<?php echo $location_name ?>'><?php echo $location_name ?></option>
          <?php  }

          ?>
        </select>

      </div>

      <button type="submit" class="btn btn-primary1">
        Check Availability
      </button>
    </form>


    <div class="row">


      <!-- available rooms -->

      <div class="col-lg-8 mt-5">
        <div class="mycard mt-5" v-for="row in allData" :key="row.room_id">


          <img :src="'./admin/room_img/' + row.room_image" class="mycard-img-top" alt="...">
          <div class="mycard-body">
            <h5 class="mycard-title">
              {{ row.room_acc }}
            </h5>
            <p class="mycard-price">
              <small class="text-muted">
                ${{ row.room_price }} Per Night

                {{ row.room_id }}
              </small>

              <small class="text-red">
                only {{ row.cnt }} left
              </small>
            </p>
            <p class="mycard-text">
              {{ row.room_desc.substring(0,238)+".."}}
            </p>
            <div class="btn-container1">
              <a href="" @click.prevent="addRoom(row)" class="btn btn-primary1">Select Room</a>

            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mt-5">
        <div v-if="cart.length != 0" class="cart-container mt-5">
          <h2 class="cart-title">Your Stay At Kuriftu</h2>

          

          <div class="cart" v-for="items of cart" :key="items.id">
            <div class="upper">
              <h3>{{ items.room_acc }} - {{ items.room_location}}</h3>
              <div class="close" @click.prevent="deleteRoom(items)">
                <i class="bi bi-trash"></i>
              </div>
            </div>

            <div class="lower">
              <p class="text-muted">
              </p>

              <p class="text-muted">
                ${{ items.room_price }} Per Night
              </p>
            </div>

          </div>

          <hr>
          <div class="footer-btn promo mb-3">

            <div class="input-group">
              <input type="text" placeholder="Apply Promo Code" name="res_promo" v-model="promoCode" class="form-control">
              <div class="input-group-append">
                <button :disabled="oneClick" @click="fetchPromo" class="input-group-text">Apply</button>

              </div>
            </div>
          </div>
          <div class="cart-footer-lg" v-if="cart.length != 0">

            <div class="footer-btn">
              <a @click.prevent="completeCart" class="btn btn-primary1"> BOOK NOW</a>
            </div>

            <div class="price">
              Total: ${{ totalprice }} <br>
              Rooms: {{ cart.length }}
            </div>
          </div>

        </div>
      </div>

    </div>
    <div class="bottom-cart" v-if="cart.length != 0">

      <div class="bottom-cart-modal" v-if="toggleModal">
        <div class="cart-header">
          <h3 class="summary-title">Booking Summary</h3>
          <div class="close" @click="openModal">
            <i class="bi bi-x"></i>
          </div>

        </div>
        <hr>


        <hr>

        <div class="cart-content" v-for="items in cart" :key="items.id">
          <div class="upper">
            <h3>{{ items.room_acc }} - {{ items.room_location}}</h3>
            <div class="close" @click.prevent="deleteRoom(items)">
              <i class="bi bi-trash"></i>
            </div>
          </div>

          <div class="lower">
            <p class="text-muted">
            </p>

            <p class="text-muted">
              ${{ items.room_price }}
            </p>
          </div>

          <hr>


        </div>

      </div>
      <div class="cart-footer">
        <div class="price">
          <div>
            Total: ${{ totalprice }} <br>
            Rooms: {{ cart.length }}
          </div>

          <div @click="openModal">
            <i class="bi bi-chevron-up"></i>
          </div>
        </div>

        <div class="footer-btn">

          <a @click.prevent="completeCart" class="btn btn-primary1"> BOOK NOW</a>
        </div>
      </div>

    </div>
  </div>
  </div>

  <?php include_once './includes/footer.php' ?>
  <script>
    var start, end
    $(document).ready(function() {

      const tdate = $('.t-datepicker')
      tdate.tDatePicker({
        show: true,
        iconDate: '<i class="fa fa-calendar"></i>'
      });
      tdate.tDatePicker('show')


      tdate.on('eventClickDay', function(e, dataDate) {

        var getDateInput = tdate.tDatePicker('getDateInputs')

        start = getDateInput[0];
        end = getDateInput[1];

        console.log("start", start);
        console.log("end", end);

      })
    });

    const user = '<?php echo $user_name ?>'
    const app = Vue.createApp({
      mounted() {

      },
      data() {
        return {
          checkIn: '',
          checkOut: '',
          desti: '',
          allData: '',
          cart: [],
          totalprice: '',
          promoCode: '',
          toggleModal: false,
          oneClick: false,
          isPromoApplied: '',
          dropdown: false
        }
      },

      methods: {
        showDropdown(){
          this.dropdown = !this.dropdown
        },
        openModal() {
          this.toggleModal = !this.toggleModal

        },
        fetchPromo() {
          this.oneClick = true

          console.log("top promo", this.isPromoApplied);
          if (!localStorage.promo) {
            console.log("excuted");
            axios.post('book.php', {
              action: 'promoCode',
              data: this.promoCode
            }).then(res => {
              let discount = this.totalprice - ((res.data / 100) * this.totalprice)

              this.totalprice = discount
              localStorage.total = JSON.stringify(this.totalprice)
              console.log(res.data);

            })
            this.isPromoApplied = true
            localStorage.promo = this.isPromoApplied
          }

          this.isPromoApplied = JSON.parse(localStorage.promo || false)

          // console.log("bottom promo", this.isPromoApplied);


          // console.log("total price", this.totalprice);
        },
        completeCart() {

          if (start && end) {
            
            console.log(start);
            console.log(end);
            axios.post('book.php', {
              action: 'insert',
              checkIn: start,
              checkOut: end,
              location: this.desti,
              data: this.cart,
              total: this.totalprice,
              totalroom: this.cart.length
            }).then(() => {
              window.location.href = "register.php"
              console.log(this.totalprice);
            })
          } else {
            alert("Please Select Check in and Check out date")
          }

        },
        addRoom(row) {
          let rooms = 0;
          let total = 0;
          
          if(start && end){
            
            if (user) {
              if (row.cnt > 0) {
  
                this.cart.push(row)
                this.cart.forEach(val => {
                  total += (parseInt(val.room_price) - (0.15 * parseInt(val.room_price))) * this.nights
  
                  console.log(total);
                })
                this.totalprice = total
                localStorage.total = JSON.stringify(this.totalprice)
                localStorage.cart = JSON.stringify(this.cart)
                console.log(this.cart);
                row.cnt--
              }
            } else {
  
              if (row.cnt > 0) {
  
                this.cart.push(row)
                this.cart.forEach(val => {
                  total += parseInt(val.room_price) * this.nights
  
                })
                this.totalprice = total
                localStorage.total = JSON.stringify(this.totalprice)
                localStorage.cart = JSON.stringify(this.cart)
                console.log(this.cart);
                row.cnt--
              }
            }
          }else{
            alert("Please Select Dates")
          }


          console.log(this.cart);
        },
        deleteRoom(row) {

          let deleteTotal = 0;
          if (user) {
            let cartIndex = this.cart.indexOf(row)
            this.cart.splice(cartIndex, 1)
            this.cart.forEach(val => {
              deleteTotal += (parseInt(val.room_price) - (0.15 * parseInt(val.room_price))) * this.nights

            })
            this.totalprice = deleteTotal
            localStorage.cart = JSON.stringify(this.cart)
            console.log(this.cart);

            row.cnt++
          } else {

            let cartIndex = this.cart.indexOf(row)
            this.cart.splice(cartIndex, 1)
            this.cart.forEach(val => {
              deleteTotal += parseInt(val.room_price) * this.nights

            })
            this.totalprice = deleteTotal
            localStorage.cart = JSON.stringify(this.cart)
            console.log(this.cart);

            row.cnt++
          }
        },
        fetchAllData() {
          axios.post('book.php', {
            action: 'fetchall'
          }).then(res => {
            this.allData = res.data

            console.log(this.allData);
          })
        },
        async submitData() {
          console.log(start);
          console.log(end);
          if (start && end) {
            await axios.post('book.php', {
              action: 'getData',
              checkIn: start,
              checkOut: end,
              desti: this.desti
            }).then(res => {
              this.allData = res.data
              console.log(res.data);
              console.log(this.allData);
            }).catch(err => {
              console.log(err);
            })
          } else {
            alert('Please fill all fields')
          }
        }


      },
      computed: {
        nights() {
          var checkin = new Date(start);
          var checkout = new Date(end);


          var Difference_In_Time = checkout.getTime() - checkin.getTime();

          var stayedNights = Difference_In_Time / (1000 * 3600 * 24);

          return stayedNights
        }
      },
      created() {
        this.fetchAllData()
        this.cart = JSON.parse(localStorage.cart || '[]')
        this.totalprice = JSON.parse(localStorage.total || '[]')




      }

    })

    app.mount('#app')
  </script>
</body>

</html>
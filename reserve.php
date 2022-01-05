<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/reserve.css">
  <script src="https://unpkg.com/vue@3.0.2"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <title>Reservation</title>
</head>

<body>

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
      </nav>

      <div class="side-socials">
        <img src="./img/facebook.svg" alt="">
        <img src="./img/instagram.svg" alt="">
        <img src="./img/youtube.svg" alt="">
      </div>

    </div>
  </header>

  <div class="container" id="app">
    <form class="myform" @submit.prevent="submitData">
  

    <div class="mb-3">
      <select class="form-select mySelect" v-model="desti">
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
 

    <div class="mb-3">
      <input type="text" class="form-control" v-model="checkIn" placeholder="Check in" onfocus="this.type='date'" onblur="(this.type='text')" id="check-in">
    </div>
      <div class="mb-3">
        <input type="text" class="form-control" v-model="checkOut" placeholder="Check in" onfocus="this.type='date'" id="check-out">
      </div>


      <button type="submit" class="btn btn-primary1">Check Availability</button>
    </form>
<!-- 
    <p>{{ checkIn }}</p>
    <p>{{ checkOut }}</p> -->

    <div class="row">



      <div class="col-lg-8 mt-5">
        <div class="mycard mt-5" v-for="row in allData" :key="row.room_id">
          <img :src="'./room_img/' + row.room_image" class="mycard-img-top" alt="...">
          <div class="mycard-body">
            <h5 class="mycard-title">
              {{ row.room_bed }}
            </h5>
            <p class="mycard-price">
              <small class="text-muted">
                ${{ row.room_price }} Per Night
              </small>

              <small class="text-muted">
                {{ row.room_location }}
              </small>
            </p>
            <p class="mycard-text">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Facilisis tincidunt nisl elementum ultrices luctus habitasse. Ut orci nam lectus at massa enim elementum varius dictumst. Nulla a, sed enim turpis non lacinia fusce. Quis volutpat sit ullamcorper vitae magna vel sit pharetra scelerisque.
            </p>
            <div class="btn-container1">
              <a href="" @click.prevent="addRoom(row)" class="btn btn-primary1">Select Room</a>
              
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mt-5 cart-container">
        <div class="cart mt-5" v-for="(cart, index) of cart" :key="cart.id">
          <div class="cart-body">
            <div>
            <h5 class="cart-title">{{ cart.room_location }} - {{ cart.room_bed }}</h5>
            <h5 class="cart-title">{{ cart.room_price }}</h5>
            </div>
            <a href="#" @click.prevent="deleteRoom(row)" class="card-link">Remove </a>
           
          </div>

        </div>
        <div v-if="cart.length != 0">

          <a @click.prevent="completeCart" class="btn btn-primary1"> BOOK NOW</a>
        </div>
      </div>

    </div>
    <div class="bottom-cart" v-if="cart.length != 0">
      <p>
        Total: ${{ totalprice }} <br>
        Rooms: {{ cart.length }}
      </p>
      
      <div>

          <a @click.prevent="completeCart" class="btn btn-primary1"> BOOK NOW</a>
        </div>
    </div>
   
    <div class="footer"></div>
    <script>
      const app = Vue.createApp({
        data() {
          return {
            checkIn: '',
            checkOut: '',
            desti: '',
            allData: '',
            cart: [],
            totalprice: ''
          }
        },
        methods: {
        
          completeCart() {
            console.log(this.cart);

            if(this.checkOut != '' && this.checkin != ''){

              axios.post('book.php', {
                action: 'insert',
                checkIn: this.checkIn,
                checkOut: this.checkOut,
                location: this.desti,
                data: this.cart
              }).then(res => {
                window.location.href = "register.php"
              })
            }else{
              alert("Please Select Check in and Check out date")
            }
            
          },
          addRoom(row) {
            let total = 0;
            let rooms = 0;
            if (!this.cart.includes(row)) {

              this.cart.push(row)
              this.cart.forEach(val=>{
              total += parseInt(val.room_price)
             
            })
            this.totalprice = total
            }
            console.log(this.cart);
          },
          deleteRoom(row) {
            this.cart.pop(row)
            console.log(this.cart);
          },
          fetchAllData() {
            axios.post('book.php', {
              action: 'fetchall'
            }).then(res => {
              this.allData = res.data
              console.log(res.data);
            })
          },
          async submitData() {
            if (this.checkIn != '' && this.checkOut != '' && this.desti != '') {
              await axios.post('book.php', {
                action: 'getData',
                checkIn: this.checkIn,
                checkOut: this.checkOut,
                desti: this.desti
              }).then(res => {
                this.allData = res.data
                console.log(res.data);
                console.log(this.allData);
              })
            } else {
              alert('Please fill all fields')
            }
          }


        },
        created() {
          this.fetchAllData()
        }

      })

      app.mount('#app')
    </script>
</body>

</html>
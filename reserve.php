<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/vue@3.0.2"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

  <title>Reservation</title>
</head>

<body>

  <div class="container" id="app">
    <form class="col-6 offset-4 mt-5" @submit.prevent="submitData">
      <div class="mb-3 col-4">
        <label for="check-in" class="form-label">Check in</label>
        <input type="date" class="form-control" v-model="checkIn" id="check-in">
      </div>
      <div class="mb-3 col-4">
        <label for="check-out" class="form-label">Check out</label>
        <input type="date" class="form-control" v-model="checkOut" id="check-out">
      </div>

      <div class="mb-3 col-4">
        <label for="dest" class="form-label"></label>
        <select class="form-select" v-model="desti">
          <option disabled value="">Select Destination</option>
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
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <p>{{ checkIn }}</p>
    <p>{{ checkOut }}</p>
    <p>{{ desti }}</p>

    <div class="row container">



      <div class="row col-6 mt-5" style="max-width: 50vw;">
        <div class="card my-2" style="max-width: 18rem;" v-for="row in allData" :key="row.room_id">
          <img :src="'./room_img/' + row.room_image" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">{{ row.room_location }}</h5>
            <p class="card-text">{{ row.room_bed }}</p>

            <a href="" @click.prevent="addRoom(row)" class="btn btn-secondary">Select Room</a>
            <p class="card-text"><small class="text-muted">${{ row.room_price }}</small></p>
          </div>
        </div>
      </div>
      <div class="col-6 mt-5">

        <div class="card" style="width: 18rem;" v-for="(cart, index) of cart" :key="cart.id">
          <div class="card-body">
            <h5 class="card-title">{{ cart.room_location }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ cart.room_bed }}</h6>
            <p class="card-text">

            </p>
            <a href="#" @click.prevent="deleteRoom(row)" class="card-link">Remove </a>
            <!-- <a href="#" class="card-link">Another link</a> -->
          </div>

        </div>
        {{ url }}
        <div v-if="cart.length != 0">

          <a @click.prevent="completeCart" class="btn btn-primary"> Book</a>
        </div>
      </div>

    </div>
    <script>
      const app = Vue.createApp({
        data() {
          return {
            checkIn: '',
            checkOut: '',
            desti: '',
            allData: '',
            cart: [],
            // url: ""
          }
        },
        methods: {
          completeCart() {
            console.log(this.cart);
            axios.post('book.php', {
              action: 'insert',
              checkIn: this.checkIn,
              checkOut: this.checkOut,
              data: this.cart
            }).then(res => {
              window.location.href = "res_form.php"
            })
          },
          addRoom(row) {
            if (!this.cart.includes(row)) {

              this.cart.push(row)
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
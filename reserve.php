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
    <form class="col-6 offset-4 mt-5">
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
            <option value='<?php echo $location_id ?>'><?php echo $location_name ?></option>
          <?php  }

          ?>
        </select>

      </div>
      <button type="submit" @click="submitData" class="btn btn-primary">Submit</button>
    </form>

    <div class="card-group mt-5" >
      <div class="card" style="max-width: 18rem;" v-for="row in allData" :key="row">
        <img :src="'./room_img/' + row.room_image" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">{{ row.room_location }}</h5>
          <p class="card-text">{{ row.room_bed }}</p>
          <p class="card-text"><small class="text-muted">${{ row.room_price }}</small></p>
        </div>
      </div>
    </div>


    <script>
      const app = Vue.createApp({
        data() {
          return {
            allData: '',
            checkIn: '',
            checkOut: '',
            desti: '',
          }
        },
        methods: {
          submitData() {
            axios.post('book.php', {
              action: 'fetchall',
              checkIn: this.checkIn,
              checkOut: this.checkOut,
              desti: this.desti

            }).then(response => {
              this.allData = response.data
            })
          }
        },
        created() {
          this.submitData()
        }
      })

      app.mount('#app')
    </script>
</body>

</html>
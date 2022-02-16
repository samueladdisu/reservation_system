<form action="" id="roomApp" method="post">
  <table class="table table-bordered table-hover col-12" id="dataTable" width="100%" cellspacing="0">
    <div id="bulkContainer" class="col-12 row mb-3">
      <select name="bulkOption" class="custom-select col-2" id="">
        <option value="">Select option</option>
        <option value="booked">Book</option>
        <option value="Not_booked">Not Book</option>
        <option value="delete">Delete</option>
      </select>
      <select name="room_location" class="custom-select col-2 mx-3" v-model="roomType" id="">
        <option disabled value="">Room Type</option>
        <?php

        $query = "SELECT * FROM room_type";
        $result = mysqli_query($connection, $query);
        confirm($result);

        while ($row = mysqli_fetch_assoc($result)) {
          $type_name = $row['type_name'];
          $type_location = $row['type_location'];

          echo "<option value='$type_name'>{$type_name}</option>";
        }
        ?>
      </select>
      <?php

      if ($_SESSION['user_location'] == 'admin') {

      ?>
        <div class="form-group col-2">
          <select name="room_location" class="custom-select" v-model="location" id="">
            <option disabled value="">Resort Location</option>
            <?php

            $query = "SELECT * FROM locations";
            $result = mysqli_query($connection, $query);
            confirm($result);

            while ($row = mysqli_fetch_assoc($result)) {
              $location_id = $row['location_id'];
              $location_name = $row['location_name'];

              echo "<option value='$location_name'>{$location_name}</option>";
            }
            ?>
          </select>
        </div>
      <?php } else { ?>
        <input type="hidden" name="room_location" value="<?php echo $_SESSION['user_location']; ?>">


      <?php  }


      ?>
      <div class="form-group col-2">
        <input type="date" v-model="date" class="form-control" id="">
      </div>

      <div class="col-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply">

        <button name="booked" value="location" id="location" @click.prevent="filterRooms" class="btn btn-success">Filter</button>

        <button name="booked" value="location" id="location" @click.prevent="clearFilter" class="btn btn-danger mx-2">Clear Filters</button>
      </div>

    </div>
    <thead>
      <tr>
        <th><input type="checkbox" name="" id="selectAllboxes"></th>
        <th>Id</th>
        <th>Occupancy</th>
        <th>Image</th>
        <th>Accomodation</th>
        <th>Price</th>
        <th>Room Number</th>
        <th>Room Status</th>
        <th>Hotel Location</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>

      <tr v-for="row in Rooms" :key="row">

      </tr>


    </tbody>
  </table>

</form>


<script src="./vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.5.1/vue-resource.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
  // Enable pusher logging - don't include this in production




  new Vue({
    el: "#resApp",
    data() {
      return {
        posts: [''],
        tempRow: {},
        page: 1,
        perPage: 9,
        pages: [],
        location: '',
        date: '',
        modal: "",
        tempcheckin: '',
        tempcheckout: '',
        firstName: '',
        lastName: '',
        email: '',
        phone: '',
        dob: '',
        remark: '',
        tempDelete: {}
      }
    },
    methods: {
      filterRes() {
        console.log(this.location);
        axios.post('./includes/backEndreservation.php', {
          action: 'filter',
          location: this.location,
          date: this.date
        }).then(res => {
          console.log(res.data);
          this.posts = res.data
        }).catch(err => console.log(err.message))
      },
      setTemp(row) {
        this.tempDelete = row
      },
      async deleteRes() {

        await axios.post('./includes/backEndreservation.php', {
          action: 'delete',
          row: this.tempDelete
        }).then(res => {
          console.log(res.data);
          this.fetchData()
        })
      },
      async singleRes() {
        console.log(this.tempRow);
        await axios.post('./includes/backEndreservation.php', {
          action: 'addSingleRes',
          row: this.tempRow,
          firstName: this.firstName,
          lastName: this.lastName,
          email: this.email,
          phone: this.phone,
          dob: this.dob,
          remark: this.remark
        }).then(res => {
          console.log(res.data);
          this.tempRow = {}
          this.firstName = ''
          this.lastName = ''
          this.email = ''
          this.phone = ''
          this.dob = ''
          this.remark = ''
          this.fetchData()
        })

      },
      editRes(row) {
        let array_rooms = JSON.parse(row.res_roomIDs)
        if (array_rooms.length > 1) {
          console.log("more than one");
          this.modal = "#exampleModal"
          this.tempcheckin = row.res_checkin
          this.tempcheckout = row.res_checkout
          this.tempRow = row
        } else {
          this.modal = ""

        }
      },
      fetchData() {
        axios.post('./includes/backEndreservation.php', {
          action: 'fetchRes'
        }).then(res => {
          this.posts = res.data
          // console.log(this.posts);
        })
      },
      setPages() {
        let numberOfPages = Math.ceil(this.posts.length / this.perPage);
        for (let index = 1; index <= numberOfPages; index++) {
          this.pages.push(index);
        }
      },
      paginate(posts) {
        let page = this.page;
        let perPage = this.perPage;
        let from = (page * perPage) - perPage;
        let to = (page * perPage);
        return posts.slice(from, to);
      }
    },
    computed: {
      displayedPosts() {
        return this.paginate(this.posts);
      }
    },
    watch: {
      posts() {
        this.setPages();
      }
    },
    created() {
      this.fetchData()
      Pusher.logToConsole = true;

      const pusher = new Pusher('341b77d990ca9f10d6d9', {
        cluster: 'mt1',
        encrypted: true
      });

      const channel = pusher.subscribe('notifications');
      channel.bind('new_reservation', (data) => {
        if (data) {
          this.fetchData()
        }
      })
    },
    filters: {
      trimWords(value) {
        return value.split(" ").splice(0, 20).join(" ") + '...';
      }
    }
  })
</script>
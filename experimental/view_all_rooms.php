<?php 
// $query = "SELECT reservations.res_roomIDs, rooms.room_id 
// FROM reservations 
// INNER JOIN rooms ON reservations.res_checkin=rooms.room_checkin;";

$query = "SELECT * FROM rooms";


date_default_timezone_set('Africa/Addis_Ababa');
$monday = date('m/d/Y', strtotime('monday'));
$friday = date('m/d/Y', strtotime('friday'));
$sunday = date('m/d/Y', strtotime('sunday'));
$saturday = date('m/d/Y', strtotime('saturday'));
// echo $weekdays;

$today =  date('m/d/Y', strtotime('today'));







?>


<form id="roomApp" method="post">
  <table class="table table-bordered table-hover col-12" id="dataTable" width="100%" cellspacing="0">
    <div id="bulkContainer" class="col-12 row mb-3">
      <!-- <select name="bulkOption" class="custom-select col-2" id="">
        <option value="">Select option</option>
        <option value="booked">Book</option>
        <option value="Not_booked">Not Book</option>
        <option value="delete">Delete</option>
      </select> -->
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

      <select class="custom-select col-2 mx-3" v-model="available">
        <option disabled value="">Select Availability</option>

        <option value="Not_booked">Available</option>
        <option value="booked">Unavailable</option>
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
        <!-- <input type="submit" name="submit" class="btn btn-success" value="Apply"> -->

        <button name="booked" value="location" id="location" @click.prevent="filterRooms" class="btn btn-success">Filter</button>

        <button name="booked" value="location" id="location" @click.prevent="fetchData" class="btn btn-danger mx-2">Clear Filters</button>
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

      <tr v-for="row in displayedPosts" :key="row">
        <td>
          <input type="checkbox" name="checkBoxArray[]" :value="row.room_id" @change="booked(row)" class="checkBoxes">
        </td>
        <td>
          {{ row.room_id }}
        </td>

        <td>
          {{ row.room_occupancy }}
        </td>

        <td>
          <img width="100" :src="'./room_img/' + row.room_image" alt="">
        </td>

        <td>
          {{ row.room_acc }}
        </td>

        <td>
          {{ row.room_price }}
        </td>

        <td>
          {{ row.room_number }}
        </td>

        <td>
          {{ row.room_status }}
        </td>

        <td>
          {{ row.room_checkin }}
        </td>

        <td>
          {{ row.room_checkout }}
        </td>

        <td>
          {{ row.room_location }}
        </td>

        <td>
          {{ row.room_desc.substr(0, 50) }}
        </td>

        <td>
          <a :href="'rooms.php?source=edit_room&p_id=' + row.room_id">
          <i style="color: turquoise;" class="far fa-edit"></i>
          </a>
        </td>

        <td data-toggle="modal" data-target="#deleteModal" @click="setTemp(row)">
          
          <i style="color: red;" class="far fa-trash-alt"></i>
        </td>
      </tr>
    </tbody>
  </table>

  <nav class="pag" aria-label="Page navigation example">
    <ul class="pagination">
      <li class="page-item">
        <button type="button" class="page-link" v-if="page != 1" @click="page--"> Previous </button>
      </li>
      <li class="page-item">
        <button type="button" class="page-link" v-for="pageNumber in pages.slice(page-1, page+5)" @click="page = pageNumber"> {{pageNumber}} </button>
      </li>
      <li class="page-item">
        <button type="button" @click="page++" v-if="page < pages.length" class="page-link"> Next </button>
      </li>
    </ul>
  </nav>

   <!-- Delete Modal  -->
   <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Are you sure You want to Delete?</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">Select "Delete" to confirm deletion.</div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" @click="deleteRes" data-dismiss="modal">Delete</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End of Delete Modal  -->
 

</form>


<script src="./vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.5.1/vue-resource.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
  // Enable pusher logging - don't include this in production




  new Vue({
    el: "#roomApp",
    data() {
      return {
        posts: [''],
        tempRow: {},
        page: 1,
        perPage: 9,
        pages: [],
        roomType: '',
        location: '',
        date: "",
        available: "",
        tempDelete: {}
      }
    },
    methods: {
      filterRooms() {
        console.log(this.location);
        axios.post('./includes/roomApi.php', {
          action: 'filter',
          location: this.location,
          date: this.date,
          roomType: this.roomType,
          available: this.available
        }).then(res => {
          console.log(res.data);
          this.posts = res.data
        }).catch(err => console.log(err.message))
      },
      setTemp(row) {
        this.tempDelete = row
      },
      async deleteRes() {

        await axios.post('./includes/roomApi.php', {
          action: 'delete',
          row: this.tempDelete
        }).then(res => {
          console.log(res.data);
          this.fetchData()
        })
      },
      fetchData() {
        axios.post('./includes/roomApi.php', {
          action: 'fetchRooms'
        }).then(res => {
          this.posts = res.data
          console.log(res.data);
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
      },
      date(){
        axios.post('./includes/roomApi.php', {
          action: 'date',
          date: this.date
        }).then(res => {
          this.posts = res.data
          console.log(res.data);
        })
      },
      available() {
        axios.post('./includes/roomApi.php', {
          action: 'available',
          available: this.available
        }).then(res => {
          this.posts = res.data
          console.log(res.data);
        })
      },
      location() {
        axios.post('./includes/roomApi.php', {
          action: 'location',
          location: this.location
        }).then(res => {
          this.posts = res.data
          console.log(res.data);
        })
      },
      roomType() {
        axios.post('./includes/roomApi.php', {
          action: 'roomType',
          roomType: this.roomType
        }).then(res => {
          this.posts = res.data
          console.log(res.data);
        })
      }
    },
    created() {
      this.fetchData()
      // Pusher.logToConsole = true;

      // const pusher = new Pusher('341b77d990ca9f10d6d9', {
      //   cluster: 'mt1',
      //   encrypted: true
      // });

      // const channel = pusher.subscribe('notifications');
      // channel.bind('new_reservation', (data) => {
      //   if (data) {
      //     this.fetchData()
      //   }
      // })
    },
    filters: {
      trimWords(value) {
        return value.split(" ").splice(0, 20).join(" ") + '...';
      }
    }
  })
</script>
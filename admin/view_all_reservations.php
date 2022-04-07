<?php ob_start(); ?>
<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php session_start(); ?>

<?php

if (!isset($_SESSION['user_role'])) {
  header("Location: ./index.php");
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Kuriftu Resort - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
  <style>
    .pag {
      width: 50%;
      margin: 0 auto;
      margin-top: 2rem;
    }

    button.page-link {
      display: inline-block;
    }

    button.page-link {
      font-size: 20px;
      color: #29b3ed;
      font-weight: 500;
    }

    .offset {
      width: 500px !important;
      margin: 20px auto;
    }
  </style>
  <!-- Custom styles for this template-->
  <link href="./css/sb-admin-2.min.css" rel="stylesheet">

</head>




<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include './includes/sidebar.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="resApp" style="width: 100vw;" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include './includes/topbar.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Reservations</h1>




          </div>
          <!-- Content Row -->
          <div class="row">
            <div>

              <table class="table table-bordered table-hover col-12"  width="100%" cellspacing="0">

                <!-- filter  -->

                <div class="filter d-flex">

                  <?php

                  if ($_SESSION['user_role'] == 'SA' || ($_SESSION['user_location'] == 'Boston' && $_SESSION['user_role'] == 'RA')) {

                  ?>
                    <div class="form-group col-4">
                      <select name="room_location" v-model="location" class="custom-select" id="">
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

                  <div class="form-group col-4">
                    <input type="date" v-model="date" class="form-control" id="">
                  </div>
                  <div id="bulkContainer" class="col-4">
                    <button name="booked" value="location" id="location" @click.prevent="filterRes" class="btn btn-success">Filter</button>

                    <button name="booked" value="location" id="location" @click.prevent="fetchData" class="btn btn-danger mx-2">Clear Filters</button>


                    <span class="text-muted">

                    </span>


                  </div>
                </div>


                <!-- end of filter  -->
                <thead>
                  <tr>
                    <!-- <th><input type="checkbox" name="" id="selectAllboxes" v-model="selectAllRoom" @change="bookAll"></th> -->
                    <th>Id</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th># of Guest</th>
                    <th>Arrival</th>
                    <th>Departure</th>
                    <th>Payment Platform</th>
                    <th>Room IDs</th>
                    <th>Total Price</th>
                    <th>Confirm Id</th>
                  </tr>
                </thead>
                <tbody>

                  <tr v-for="row in displayedPosts" :key="row">
                    <td>
                      {{ row.res_id}}
                    </td>
                    <td>
                      {{ row.res_firstname }}
                    </td>
                    <td>
                      {{ row.res_lastname}}
                    </td>
                    <td>
                      {{ row.res_phone}}
                    </td>
                    <td>
                      {{ row.res_guestNo}}
                    </td>
                    <td>
                      {{ row.res_checkin }}
                    </td>
                    <td>
                      {{ row.res_checkout }}
                    </td>
                    <td>
                      {{ row.res_paymentMethod }}
                    </td>
                    <td>
                      {{ row.res_roomIDs }}
                    </td>
                    <td>
                      {{ row.res_price}}
                    </td>
                    <td>
                      {{ row.res_confirmID }}
                    </td>
                    <td>
                      <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-600"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                          <!-- <div class="dropdown-header">Options</div> -->

                          <a data-toggle="modal" @click="editRes(row)" :data-target="modal" class="dropdown-item" href="#">
                            Add
                          </a>
                          <a class="dropdown-item" 
                          href="#"
                          data-toggle="modal" data-target="#exampleModalLong" @click="setTemp(row)">
                            View
                          </a>
                          <div class="dropdown-divider"></div>
                          <a data-toggle="modal" href="#" class="dropdown-item text-danger" data-target="#deleteModal" @click="setTemp(row)">
                            Delete
                          </a>

                        </div>
                      </div>
                    </td>

                  </tr>


                </tbody>

              </table>


            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
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


      <!-- Edit bulk reservation Modal -->


      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Guest</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form class="row">

                <div class="form-group col-6">
                  <label for="recipient-name" class="col-form-label">First Name:</label>
                  <input type="text" v-model="firstName" class="form-control" id="recipient-name">
                </div>
                <div class="form-group col-6">
                  <label for="recipient-name" class="col-form-label">Last Name:</label>
                  <input type="text" v-model="lastName" class="form-control" id="recipient-name">
                </div>
                <div class="form-group col-12">
                  <label for="recipient-name" class="col-form-label">Email:</label>
                  <input type="text" v-model="email" class="form-control" id="recipient-name">
                </div>
                <div class="form-group col-6">
                  <label for="recipient-name" class="col-form-label">Phone:</label>
                  <input type="text" v-model="phone" class="form-control" id="recipient-name">
                </div>

                <div class="form-group col-6">
                  <label for="recipient-name" class="col-form-label">Date of Birth:</label>
                  <input type="date" v-model="dob" class="form-control" id="recipient-name">
                </div>

                <div class="form-group col-6">
                  <label for="recipient-name" class="col-form-label">Check in:</label>
                  <input type="date" class="form-control" :value="tempcheckin" readonly>
                </div>

                <div class="form-group col-6">
                  <label for="recipient-name" class="col-form-label">Check Out:</label>
                  <input type="date" class="form-control" :value="tempcheckout" readonly>
                </div>




                <div class="form-group col-12">
                  <label for="message-text" class="col-form-label">Remark:</label>
                  <textarea v-model="remark" class="form-control" id="message-text"></textarea>
                </div>


              </form>
            </div>
            <div class="modal-footer">
              <button type="button" data-dismiss="modal" @click="singleRes" class="btn btn-primary">Add</button>
            </div>
          </div>
        </div>
      </div>
      <!-- end edit bulk reservation  -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Kuriftu resorts 2021. Powered by <a href="https://versavvymedia.com">Versavvy Media</a> </span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

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
       <!-- View Full Reservation Details  -->

  <!-- Modal -->
  <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">
            {{ tempDelete.res_firstname }}
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
              
        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
              <thead>
                <th>
                  Key
                </th>
                <th>
                  Value
                </th>
              </thead>
              <tbody>
                <tr v-for="(value, key) in tempDelete">
                  <td>
                  {{ key }}
                  </td>
                  <td>
                  {{ value }}
                  </td>
                </tr>
              </tbody>
        </table>
   
        </div>
       
      </div>
    </div>
  </div>

  <!-- End of View Full Reservation Details -->
    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

 


  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="./includes/logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="./vendor/jquery/jquery.min.js"></script>
  <script src="./vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.5.1/vue-resource.min.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="./vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
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

  <!-- Custom scripts for all pages-->
  <script src="./js/sb-admin-2.min.js"></script>


</body>

</html>
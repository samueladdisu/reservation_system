<?php $currentPage = "Add Special Request"; ?>
<?php include './includes/admin_header.php'; ?>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include './includes/sidebar.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include './includes/topbar.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <!-- <h1 class="h3 mb-0 text-gray-800">Reservations</h1> -->

          </div>
          <!-- Content Row -->
          <div class="row">

            <div id="special_app" class="col-12">

              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Add Special Request</h6>
                </div>

                <div class="card-body d-flex justify-content-center">
                  <form action="" method="POST" @submit.prevent="submitForm" class="col-6" enctype="multipart/form-data">

                    <div class="form-group">
                      <label for="room_acc"> Guest / Company Name</label>
                      <input type="text" v-model="guestName" class="form-control" required>


                    </div>

                    <div class="form-group">
                      <label for="post_tags"> Type </label>
                      <select name="type" v-model="type" class="custom-select" required>
                        <option value="" disabled>--select--</option>
                        <option value="birthday">Birthday</option>
                        <option value="landscape">Landscape</option>
                        <option value="shuttle">Shuttle</option>
                        <option value="other">Other</option>
                      </select>

                    </div>

                    <div class="form-group" v-show="other">
                      <label for="post_tags"> If other selected specify type </label>
                      <input type="text" v-model="otherType" class="form-control">

                    </div>

                    <?php

                    if ($_SESSION['user_role'] == 'SA' || ($_SESSION['user_location'] == 'Boston' && $_SESSION['user_role'] == 'RA')) {

                    ?>
                      <div class="form-group">
                        <label for="post_tags"> Location </label>
                        <select name="room_location" class="custom-select" v-model="location" id="">
                          <option value="" disabled>Resort Location</option>
                          <?php

                          $query = "SELECT * FROM locations";
                          $result = mysqli_query($connection, $query);
                          confirm($result);

                          while ($row = mysqli_fetch_assoc($result)) {
                            $location_id = $row['location_id'];
                            $location_name = $row['location_name'];

                            if ($location_name != 'Boston') {

                              echo "<option value='$location_name'>{$location_name}</option>";
                            }
                          }
                          ?>
                        </select>
                      </div>
                    <?php } else { ?>
                      <input type="hidden" name="room_location" value="<?php echo $_SESSION['user_location']; ?>">


                    <?php  }


                    ?>

                    

                    <div class="form-group">
                      <label for="room_acc"> # of people</label>
                      <input type="number" v-model="numberOfPeople" class="form-control" required>

                    </div>

                    <div class="form-group">
                      <label for="room_acc"> Date</label>
                      <input type="date" v-model="date" class="form-control" required>

                    </div>

                    <div class="form-group">
                      <label for="room_acc"> Remark</label>
                      <textarea cols="30" rows="10" v-model="remark" class="form-control"></textarea>

                    </div>

                    <div class="form-group">
                      <input type="submit" class="btn btn-primary" name="add_req" value="Add Request">
                    </div>

                  </form>

                </div>

              </div>
            </div>

          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Kuriftu resorts 2022. Powered by <a href="https://versavvymedia.com">Versavvy Media</a> </span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

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
  <script src="https://unpkg.com/vue@3.0.2"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <script src="https://unpkg.com/axios@0.27.2/dist/axios.min.js"></script>
  <!-- Core plugin JavaScript-->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- data table plugin  -->

  <script>
    const app = Vue.createApp({
      data() {
        return {
          guestName: "",
          type: "",
          otherType: "",
          numberOfPeople: "",
          date: "",
          remark: "",
          location: "",
          other: false
        }
      },
      watch: {
        type(value) {
          if (value == "other") {
            this.other = true
          } else {
            this.other = false
            this.otherType = ""
          }
        }
      },
      methods: {
        async submitForm() {
          await axios.post('load_modal.php', {
              action: 'addSpecialRequest',
              guest: this.guestName,
              type: this.type,
              otherType: this.otherType,
              num: this.numberOfPeople,
              date: this.date,
              location: this.location,
              remark: this.remark
            }).then(res => console.log(res.data))
            .then(() => {
              this.guestName = ""
              this.type= ""
              this.otherType = ""
              this.numberOfPeople = ""
              this.date = ""
              this.location = ""
              this.remark = ""

              window.location = "view_special.php"
            })
        }
      }
    })


    const specialApp = app.mount('#special_app')
  </script>


</body>

</html>
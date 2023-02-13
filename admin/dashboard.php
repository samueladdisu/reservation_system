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
          <div class="row mb-4">
            <h1 class="h3 mb-0 col-11 text-gray-900">Welcome to Admin
              | <small class="text-gray-600"><?php echo $_SESSION['username']; ?></small>
            </h1>

            <!--             
                        <div class="dropdown show">
                            <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-download fa-sm text-white-50"></i>
                                Generate Report
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="./export.php?report=rooms">Rooms</a>
                                <a class="dropdown-item" href="./export.php?report=reservation">Reservation</a>
                                <a class="dropdown-item" href="./export.php?report=members">Members</a>
                            </div>
                        </div> -->

            <select name="" id="" class="custom-select col-1">
              <option value="">today</option>
              <option value="">this week</option>
              <option value="">this month</option>
              <option value="">this year</option>
            </select>




          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">

              <a href="./daily.php#resApp">
                <div class="card border-left-primary shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                          Rooms</div>
                        
                        <?php
                        $location = $_SESSION['user_location'];
                        $today = date("Y-m-d");
                        if ($location == "Boston") {
                          $query = "SELECT r.room_id, r.room_acc, r.room_number, res.res_firstname, g.info_adults, g.info_kids, g.info_teens,b.b_checkin, b.b_checkout, r.room_location, res.res_remark
                          FROM rooms AS r
                          LEFT JOIN booked_rooms AS b
                          ON r.room_id = b.b_roomId AND '$today' BETWEEN b_checkin AND b_checkout
                          LEFT JOIN reservations AS res
                          ON res.res_id = b.b_res_id
                          LEFT JOIN guest_info AS g
                          ON g.info_res_id = b.b_res_id AND g.info_room_id = b.b_roomId";
                        } else {
                          $query = "SELECT r.room_id, r.room_acc, r.room_number, res.res_firstname, g.info_adults, g.info_kids, g.info_teens,b.b_checkin, b.b_checkout, r.room_location, res.res_remark
                          FROM rooms AS r
                          LEFT JOIN booked_rooms AS b
                          ON r.room_id = b.b_roomId AND '$today' BETWEEN b_checkin AND b_checkout
                          LEFT JOIN reservations AS res
                          ON res.res_id = b.b_res_id
                          LEFT JOIN guest_info AS g
                          ON g.info_res_id = b.b_res_id AND g.info_room_id = b.b_roomId
                          WHERE r.room_location = '$location'";
                        }
                        $select_all_posts = mysqli_query($connection, $query);
                        $post_counts = mysqli_num_rows($select_all_posts);
                        $result = mysqli_query($connection, $query);

                        confirm($result);
                        $available = 0;
                        $booked = 0;
                        $arrivals = 0;
                        $departures = 0;

                        while ($row = mysqli_fetch_assoc($result)) {
                          $room_id = $row['room_id'];
                          $room_acc = $row['room_acc'];
                          $room_number = $row['room_number'];
                          $res_firstname = $row['res_firstname'];
                          $info_adults = $row['info_adults'];
                          $info_kids = $row['info_kids'];
                          $info_teens = $row['info_teens'];
                          $b_checkin = $row['b_checkin'];
                          $b_checkout = $row['b_checkout'];
                          $room_location = $row['room_location'];
                          $res_remark = $row['res_remark'];

                          if ($b_checkin == null) {
                            $available++;
                          } else {
                            $booked++;
                          }

                          if ($b_checkin == $today) {
                            $arrivals++;
                          } else if ($b_checkout == $today) {
                            $departures++;
                          }
                        }

                        echo "<div class='h6 mb-0 mt-2 text-gray-600'>
                        $available Available/ $booked Booked
                      </div>";

                        ?>

                      </div>
                      <div class="col-auto">
                        <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>

            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="./daily.php#resTable">
                <div class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                          Arrival & departure</div>
                        <div class='h6 mb-0 mt-2 text-gray-600'>
                         <?php echo $arrivals; ?> Arrivals/  <?php echo $departures; ?>  Departures
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="./daily.php#resTable">
                <div class="card border-left-info shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">New Bookings
                        </div>
                        <?php
                       

                        if ($location == "Boston") {
                          $query = "SELECT * FROM reservations WHERE res_checkin = '$today' ORDER BY res_id DESC";
                        } else {
                          $query = "SELECT * FROM reservations WHERE res_location = '$location' AND res_checkin = '$today' ORDER BY res_id DESC";
                        }
                        $result = mysqli_query($connection, $query);
                        $new_bookings = mysqli_num_rows($result);
                         echo "<div class='h6 mb-0 mt-2 text-gray-600'>$new_bookings</div>";

                        ?>

                      </div>
                      <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="./daily.php#viewSpecial">
                <div class="card border-left-info shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                          Special Requests</div>
                        <?php

                          if ($location == 'Boston') {
                            $query = "SELECT * FROM special_request WHERE date = '$today' ORDER BY id DESC";
                          } else {
                            $query = "SELECT * FROM special_request WHERE location = '$location' AND date = '$today' ORDER BY id DESC";
                          }
                        
                          $result = mysqli_query($connection, $query);
                        
                          $special = mysqli_num_rows($result);
                          echo "<div class='h6 mb-0 mt-2 text-gray-600'>$special</div>";

                        ?>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>

          <!-- Content Row -->


          <!-- Content Row -->
          <div class="row">

            <div class="col-xl-8 col-lg-7">

              <!-- Area Chart -->

              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Total Sales</h6>

                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                  </div>
                </div>
              </div>




              <!-- Bar Chart -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Bar Chart</h6>
                </div>
                <div class="card-body">
                  <div class="chart-bar">
                    <canvas id="myBarChart"></canvas>
                  </div>

                </div>
              </div>

            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Visitors</h6>

                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle" style="color: #4e73df"></i> Homepage banner
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle" style="color: #1cc88a"></i> Homepage Button
                    </span>
                    <!-- <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> Referral
                    </span> -->
                  </div>
                </div>
              </div>
            </div>

          </div>
          <!-- Content Row -->


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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="./js/t-datepicker.min.js"></script>
  <script src="https://unpkg.com/vue@3.0.2"></script>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- data table plugin  -->

  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>





  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script src="./js/load.js"></script>
  <script src="./js/chart.js"></script>





  <script src="./js/room.js"></script>
  <div class="modal fade" id="ReportModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Report options</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form name="myForm" id="myForm" target="_myFrame" action="includes/GenerateReport.php" method="POST">
          <div class="modal-body">
            <h5 class="m-0 font-weight-bold text-primary">
              Choose options for report
            </h5>
            <div>
              <div>
                <p>Start Date: <input class="dateReportInput" type="text" name="StartDate" id="datepickerStart" autocomplete="off"></p>
              </div>

              <div>
                <p>End Date: <input class="dateReportInput" type="text" name="EndDate" id="datepickerEnd" autocomplete="off"></p>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" value="Report" name="report">Generate Report</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
  <script>
    $(function() {

      var dateFormat = "mm/dd/yy";
      var minDatefrom;

      $("#datepickerStart").datepicker().on("change", function() {
        console.log(getDate(this));
        to.datepicker("option", "minDate", getDate(this));
      });
      to = $("#datepickerEnd").datepicker();


      function getDate(element) {
        var date;
        try {
          date = $.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
          date = null;
        }

        return date;
      }

    });
  </script>

</body>

</html>
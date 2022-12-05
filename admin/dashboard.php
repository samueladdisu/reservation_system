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
            <h1 class="h3 mb-0 text-gray-900">Welcome to Admin
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

            <div class="d-sm-flex align-items-center justify-content-between mb-4">

              <button data-toggle="modal" data-target="#ReportModalCenter" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Sales Report</button>
            </div>


          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">

              <a href="./reservations.php">
                <div class="card border-left-primary shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                          Reservations</div>

                        <?php
                        $location = $_SESSION['user_location'];
                        if ($location == "Boston") {
                          $query = "SELECT * FROM reservations";
                        } else {
                          $query = "SELECT * FROM reservations WHERE res_location = '$location' ";
                        }
                        $select_all_posts = mysqli_query($connection, $query);
                        $post_counts = mysqli_num_rows($select_all_posts);
                        echo "<div class='h5 mb-0 font-weight-bold text-gray-800'>$post_counts</div>";

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
              <a href="./rooms.php">
                <div class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                          Rooms</div>
                        <?php

                        if ($location == 'Boston') {

                          $query = "SELECT * FROM rooms";
                        } else {

                          $query = "SELECT * FROM rooms WHERE room_location = '$location'";
                        }
                        $select_all_categories = mysqli_query($connection, $query);
                        $category_counts = mysqli_num_rows($select_all_categories);
                        echo "<div class='h5 mb-0 font-weight-bold text-gray-800'>$category_counts</div>";

                        ?>
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
              <a href="./users.php">
                <div class="card border-left-info shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Users
                        </div>
                        <?php

                        $query = "SELECT * FROM users";
                        $select_all_users = mysqli_query($connection, $query);
                        $users_counts = mysqli_num_rows($select_all_users);
                        echo "<div class='h5 mb-0 font-weight-bold text-gray-800'>$users_counts</div>";

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
              <a href="./acc.php">
                <div class="card border-left-warning shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                          Room Types</div>
                        <?php

                        if ($location == 'Boston') {
                          $query = "SELECT * FROM room_type";
                        } else {
                          $query = "SELECT * FROM room_type WHERE type_location = '$location' ";
                        }
                        $select_all_comments = mysqli_query($connection, $query);
                        $comments_counts = mysqli_num_rows($select_all_comments);
                        echo "<div class='h5 mb-0 font-weight-bold text-gray-800'>$comments_counts</div>";

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
                  <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>

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

      <?php include './includes/admin_footer.php'; ?>
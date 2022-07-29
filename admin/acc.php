<?php include './includes/admin_header.php'; ?>

<body id="page-top">
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href)
    }
  </script>
  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include './includes/sidebar.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d_flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include './includes/topbar.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="bishoftu-tab" data-toggle="tab" href="#bishoftu" role="tab" aria-controls="bishoftu" aria-selected="true">Bishoftu</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="awash-tab" data-toggle="tab" href="#awash" role="tab" aria-controls="awash" aria-selected="false">Awash</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="entoto-tab" data-toggle="tab" href="#entoto" role="tab" aria-controls="entoto" aria-selected="false">Entoto</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tana-tab" data-toggle="tab" href="#tana" role="tab" aria-controls="tana" aria-selected="false">Lake Tana</a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active mt-4" id="bishoftu" role="tabpanel" aria-labelledby="bishoftu-tab">

              <!-- Content Row -->
              <div class="row">
                <?php
                global $type_location;
                if ($_SESSION['user_role'] == 'SA' || $_SESSION['user_role'] == 'PA') {
                ?>
                  <div class="col-12">
                    <?php



                    if (isset($_POST['submit'])) {
                      $type_name          = escape($_POST['type_name']);
                      $type_location      = escape($_POST['type_location']);
                      $double             = escape($_POST['d_rack_rate']);
                      $single             = escape($_POST['s_rack_rate']);
                      $room_occupancy     = escape($_POST['room_occupancy']);
                      $room_image         = $_FILES['room_image']['name'];
                      $room_image_temp    = $_FILES['room_image']['tmp_name'];

                      move_uploaded_file($room_image_temp, "./room_img/$room_image");

                      $d_weekdays = number_format($double - ($double * 0.15), 2, '.', '');
                      $s_weekdays = number_format($single - ($single * 0.15), 2, '.', '');

                      $s_weekend   = number_format($single - ($single * 0.1), 2, '.', '');
                      $d_weekend   = number_format($double - ($double * 0.1), 2, '.', '');
                      $s_member    = number_format($single - ($single * 0.25), 2, '.', '');
                      $d_member    = number_format($double - ($double * 0.25), 2, '.', '');

                      $query_bishoftu = "INSERT INTO room_type(type_name, type_location, occupancy, room_image, d_rack_rate, d_weekend_rate, d_member_rate, d_weekday_rate, s_rack_rate, s_weekend_rate, s_member_rate, s_weekday_rate) ";

                      $query_bishoftu .= "VALUE ('$type_name', '$type_location', '$room_occupancy', '$room_image', $double, $d_weekend, $d_member, $d_weekdays, $single, $s_weekend, $s_member, $s_weekdays)";

                      $result_bishoftu = mysqli_query($connection, $query_bishoftu);

                      confirm($result_bishoftu);



                      // header("Refresh:0");
                    }


                    ?>

                    <div class="d-flex justify-content-center">

                      <form method="POST" class="row col-6" enctype="multipart/form-data">


                        <div class="form-group col-6">
                          <label for="title">Room Occupancy</label>
                          <input type="text" class="form-control" name="room_occupancy">
                        </div>

                        <div class="form-group col-6">
                          <label for="type_name">Room Type</label>
                          <input type="text" class="form-control" name="type_name">
                        </div>



                        <div class="form-group col-6">
                          <label for="user_role"> Double Occupancy(rack rate)</label>
                          <input type="text" class="form-control" name="d_rack_rate">
                        </div>
                        <div class="form-group col-6">
                          <label for="user_role"> Single Occupancy(rack rate) </label>
                          <input type="text" class="form-control" name="s_rack_rate">
                        </div>


                        <div class="form-group col-6">
                          <label for="type_name">Room Image</label> <br>
                          <input type="file" name="room_image">

                        </div>

                        <div class="form-group col-12">
                          <input type="submit" class="btn btn-primary" name="submit" value="Add">
                        </div>
                      </form>
                    </div>

                    <?php
                    if (isset($_GET['edit'])) {
                      $cat_id = escape($_GET['edit']);
                      include './includes/update_acc.php';
                    }


                    ?>

                  </div>

                <?php } ?>

                <div class="col-12">



                  <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Room Types</h6>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table display table-bordered" id="accTable" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>Id</th>
                              <th>Accomodation</th>
                              <th>Occupancy</th>
                              <th>Image</th>
                              <th>Double Rack rate</th>
                              <th>Double Weekend</th>
                              <th>Double member</th>
                              <th>Double Weekday</th>
                              <th>Single Rack rate</th>
                              <th>Single Weekend</th>
                              <th>Single member</th>
                              <th>Single Weekday</th>
                              <?php
                              if ($_SESSION['user_location'] == 'Boston') {

                              ?>
                                <th>Location</th>

                              <?php
                              }

                              ?>
                              <th></th>
                              <th></th>
                            </tr>
                          </thead>
                          <?php


                          // Display categories from database
                          $location = $_SESSION['user_location'];
                          $role = $_SESSION['user_role'];
                          if ($_SESSION['user_role'] == 'SA' || ($_SESSION['user_location'] == 'Boston' && $_SESSION['user_role'] == 'RA')) {
                            $query = "SELECT * FROM room_type ORDER BY type_id DESC";
                          } else {
                            $query = "SELECT * FROM room_type WHERE type_location = '$location' ORDER BY type_id DESC";
                          }

                          $result = mysqli_query($connection, $query);

                          while ($row = mysqli_fetch_assoc($result)) {
                            $type_id = $row['type_id'];
                            $type_name = $row['type_name'];
                            $db_rate = $row['d_rack_rate'];
                            $sg_rate = $row['s_rack_rate'];
                            $type_location = $row['type_location'];
                          ?>
                            <tr>
                              <td><?php echo $type_id; ?></td>
                              <td><?php echo $type_name; ?></td>
                              <td><?php echo $row['occupancy']; ?></td>
                              <td>
                                <img width="100" src="./room_img/<?php echo $row['room_image']; ?>" alt="">
                              </td>
                              <td><?php echo $db_rate; ?></td>
                              <td><?php echo $row['d_weekend_rate']; ?></td>
                              <td><?php echo $row['d_member_rate']; ?></td>
                              <td><?php echo $row['d_weekday_rate']; ?></td>
                              <td><?php echo $sg_rate; ?></td>
                              <td><?php echo $row['s_weekend_rate']; ?></td>
                              <td><?php echo $row['s_member_rate']; ?></td>
                              <td><?php echo $row['s_weekday_rate']; ?></td>
                              <?php
                              if ($location == 'Boston') {
                                echo "<td> $type_location </td>";
                              }
                              if ($role != 'RA') {
                              ?>


                                <td><?php echo "<a href='acc.php?edit={$type_id}'><i style='color: turquoise;' class='far fa-edit'></i> </a>"; ?></td>
                                <td><?php echo "<a href='acc.php?delete={$type_id}'><i style='color: red;' class='far fa-trash-alt'></i> </a>"; ?></td>
                            </tr>
                        <?php  }
                            } ?>


                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade mt-4" id="awash" role="tabpanel" aria-labelledby="awash-tab">

              <div class="d-flex justify-content-center">


                <?php

                if (isset($_POST['awash'])) {

                  foreach ($_POST as $key => $value) {
                    $form[$key] = $value;
                  }

                  $room_image         = $_FILES['awash_image']['name'];
                  $room_image_temp    = $_FILES['awash_image']['tmp_name'];

                  move_uploaded_file($room_image_temp, "./room_img/awash/$room_image");

                  $query = "INSERT INTO awash_price(name, occupancy, room_img, d_bb_wd, d_hb_wd, d_fb_wd, d_bb_we, d_hb_we, d_fb_we, s_bb_wd, s_hb_wd, s_fb_wd, s_bb_we, s_hb_we, s_fb_we) ";

                  $query .= "VALUE ('{$form['awash_type']}', '{$form['awash_occupancy']}', '$room_image', '{$form['d_BB_wd']}', '{$form['d_HB_wd']}', '{$form['d_FB_wd']}', '{$form['d_BB_we']}', '{$form['d_HB_we']}', '{$form['d_FB_we']}', '{$form['s_BB_wd']}', '{$form['s_HB_wd']}', '{$form['s_FB_wd']}', '{$form['s_BB_we']}', '{$form['s_HB_we']}', '{$form['s_FB_we']}')";

                  $result = mysqli_query($connection, $query);
                  confirm($result);
                  // header("Refresh:0");
                }


                ?>

                <form method="POST" class="row col-6" enctype="multipart/form-data">


                  <div class="form-group col-6">
                    <label for="title">Room Occupancy</label>
                    <input type="text" class="form-control" name="awash_occupancy">
                  </div>

                  <div class="form-group col-6">
                    <label for="type_name">Room Type</label>
                    <input type="text" class="form-control" name="awash_type">
                  </div>


                  <!-- Double Occupancy Form  -->

                  <div class="form-group col-6">
                    <label for="user_role"> Double BB weekdays</label>
                    <input type="text" class="form-control" name="d_BB_wd">
                  </div>

                  <div class="form-group col-6">
                    <label for="type_name">Double BB weekend </label>
                    <input type="text" class="form-control" name="d_BB_we">
                  </div>

                  <div class="form-group col-6">
                    <label for="user_role"> Double HB weekdays </label>
                    <input type="text" class="form-control" name="d_HB_wd">
                  </div>

                  <div class="form-group col-6">
                    <label for="user_role"> Double HB weekend</label>
                    <input type="text" class="form-control" name="d_HB_we">
                  </div>

                  <div class="form-group col-6">
                    <label for="title">Double FB weekdays</label>
                    <input type="text" class="form-control" name="d_FB_wd">
                  </div>

                  <div class="form-group col-6">
                    <label for="user_role"> Double FB weekend </label>
                    <input type="text" class="form-control" name="d_FB_we">
                  </div>

                  <!-- End Double Occupancy Form  -->

                  <!-- Single Occupancy Form  -->


                  <div class="form-group col-6">
                    <label for="user_role"> Single BB weekdays</label>
                    <input type="text" class="form-control" name="s_BB_wd">
                  </div>

                  <div class="form-group col-6">
                    <label for="type_name">Single BB weekend </label>
                    <input type="text" class="form-control" name="s_BB_we">
                  </div>

                  <div class="form-group col-6">
                    <label for="user_role"> Single HB weekdays </label>
                    <input type="text" class="form-control" name="s_HB_wd">
                  </div>

                  <div class="form-group col-6">
                    <label for="user_role"> Single HB weekend</label>
                    <input type="text" class="form-control" name="s_HB_we">
                  </div>

                  <div class="form-group col-6">
                    <label for="title">Single FB weekdays</label>
                    <input type="text" class="form-control" name="s_FB_wd">
                  </div>

                  <div class="form-group col-6">
                    <label for="user_role"> Single FB weekend </label>
                    <input type="text" class="form-control" name="s_FB_we">
                  </div>

                  <!-- End of Single Occupancy Form  -->


                  <div class="form-group col-4">
                    <label for="type_name">Room Image</label> <br>
                    <input type="file" name="awash_image">

                  </div>

                  <div class="form-group col-12">
                    <input type="submit" class="btn btn-primary" name="awash" value="Add">
                  </div>
                </form>

              </div>
              <div class="col-12 row">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Awash Room Types</h6>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table display table-bordered" id="awashTable" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>Room Type</th>
                            <th>Occupancy</th>
                            <th>Image</th>
                            <th>Double BB WD</th>
                            <th>Double HB WD</th>
                            <th>Double FB WD</th>
                            <th>Double BB WE</th>
                            <th>Double HB WE</th>
                            <th>Double FB WE</th>
                            <th>Single BB WD</th>
                            <th>Single HB WD</th>
                            <th>Single FB WD</th>
                            <th>Single BB WE</th>
                            <th>Single HB WE</th>
                            <th>Single FB WE</th>
                            <!-- <th></th>
                            <th></th> -->
                          </tr>
                        </thead>
                        <?php

                        $query = "SELECT * FROM awash_price ORDER BY id DESC";

                        $result = mysqli_query($connection, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                          echo "<tr>";
                          foreach ($row as $key => $value) {
                            $row[$key] = $value;

                            if ($key == 'room_img') {
                        ?>
                              <td>
                                <img width="100" src="./room_img/awash/<?php echo $row['room_img']; ?>" alt="">
                              </td>
                          <?php
                            } else {
                              echo "<td>$row[$key]</td>";
                            }
                          }
                          ?>

                          <?php
                          if ($role != 'RA') {
                          ?>
                            <!-- <td><?php echo "<a href='acc.php?edit={$type_id}'><i style='color: turquoise;' class='far fa-edit'></i> </a>"; ?></td>
                            <td><?php echo "<a href='acc.php?delete={$type_id}'><i style='color: red;' class='far fa-trash-alt'></i> </a>"; ?></td> -->
                            </tr>
                        <?php  }
                        } ?>


                      </table>
                    </div>
                  </div>
                </div>
              </div>


            </div>
            <div class="tab-pane fade mt-4" id="entoto" role="tabpanel" aria-labelledby="entoto-tab">
              <div class="d-flex justify-content-center">


                <?php

                if (isset($_POST['entoto'])) {

                  foreach ($_POST as $key => $value) {
                    $form[$key] = $value;
                  }

                  $room_image         = $_FILES['entoto_image']['name'];
                  $room_image_temp    = $_FILES['entoto_image']['tmp_name'];

                  move_uploaded_file($room_image_temp, "./room_img/entoto/$room_image");

                  $query = "INSERT INTO entoto_price(name, occupancy, room_img, double_occ, single_occ) ";

                  $query .= "VALUE ('{$form['entoto_type']}', '{$form['entoto_occupancy']}', '$room_image', {$form['double_occ']}, {$form['single_occ']})";

                  $result = mysqli_query($connection, $query);
                  confirm($result);
                  // header("Refresh:0");
                }


                ?>

                <form method="POST" class="row col-6" enctype="multipart/form-data">


                  <div class="form-group col-6">
                    <label for="title">Room Occupancy</label>
                    <input type="text" class="form-control" name="entoto_occupancy">
                  </div>

                  <div class="form-group col-6">
                    <label for="type_name">Room Type</label>
                    <input type="text" class="form-control" name="entoto_type">
                  </div>

                  <div class="form-group col-6">
                    <label for="type_name">Double Occupancy</label>
                    <input type="text" class="form-control" name="double_occ">
                  </div>

                  <div class="form-group col-6">
                    <label for="type_name">Single Occupancy</label>
                    <input type="text" class="form-control" name="single_occ">
                  </div>

                  <div class="form-group col-4">
                    <label for="type_name">Room Image</label> <br>
                    <input type="file" name="entoto_image">

                  </div>

                  <div class="form-group col-12">
                    <input type="submit" class="btn btn-primary" name="entoto" value="Add">
                  </div>
                </form>

              </div>
              <div class="col-12 row">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Entoto Room Types</h6>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table display table-bordered" id="awashTable" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>Room Type</th>
                            <th>Occupancy</th>
                            <th>Image</th>
                            <th>Single</th>
                            <th>Double</th>
                          </tr>
                        </thead>
                        <?php

                        $query = "SELECT * FROM entoto_price ORDER BY id DESC";

                        $result = mysqli_query($connection, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                          echo "<tr>";
                          foreach ($row as $key => $value) {
                            $row[$key] = $value;

                            if ($key == 'room_img') {
                        ?>
                              <td>
                                <img width="100" src="./room_img/entoto/<?php echo $row['room_img']; ?>" alt="">
                              </td>
                          <?php
                            } else {
                              echo "<td>$row[$key]</td>";
                            }
                          }
                          ?>

                          <?php
                          if ($role != 'RA') {
                          ?>
                            <!-- <td><?php echo "<a href='acc.php?edit={$type_id}'><i style='color: turquoise;' class='far fa-edit'></i> </a>"; ?></td>
                            <td><?php echo "<a href='acc.php?delete={$type_id}'><i style='color: red;' class='far fa-trash-alt'></i> </a>"; ?></td> -->
                            </tr>
                        <?php  }
                        } ?>


                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade mt-4" id="tana" role="tabpanel" aria-labelledby="tana-tab">
              <div class="d-flex justify-content-center">


                <?php

                if (isset($_POST['tana'])) {

                  foreach ($_POST as $key => $value) {
                    $form[$key] = $value;
                  }

                  $room_image         = $_FILES['tana_image']['name'];
                  $room_image_temp    = $_FILES['tana_image']['tmp_name'];

                  move_uploaded_file($room_image_temp, "./room_img/tana/$room_image");

                  $query = "INSERT INTO tana_price(name, occupancy, room_img, double_occ, single_occ) ";

                  $query .= "VALUE ('{$form['tana_type']}', '{$form['tana_occupancy']}', '$room_image', {$form['double_occ']}, {$form['single_occ']})";

                  $result = mysqli_query($connection, $query);
                  confirm($result);
                  // header("Refresh:0");
                }


                ?>

                <form method="POST" class="row col-6" enctype="multipart/form-data">


                  <div class="form-group col-6">
                    <label for="title">Room Occupancy</label>
                    <input type="text" class="form-control" name="tana_occupancy">
                  </div>

                  <div class="form-group col-6">
                    <label for="type_name">Room Type</label>
                    <input type="text" class="form-control" name="tana_type">
                  </div>

                  <div class="form-group col-6">
                    <label for="type_name">Double Occupancy</label>
                    <input type="text" class="form-control" name="double_occ">
                  </div>

                  <div class="form-group col-6">
                    <label for="type_name">Single Occupancy</label>
                    <input type="text" class="form-control" name="single_occ">
                  </div>

                  <div class="form-group col-4">
                    <label for="type_name">Room Image</label> <br>
                    <input type="file" name="tana_image">

                  </div>

                  <div class="form-group col-12">
                    <input type="submit" class="btn btn-primary" name="tana" value="Add">
                  </div>
                </form>

              </div>
              <div class="col-12 row">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Lake Tana Room Types</h6>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table display table-bordered" id="awashTable" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>Room Type</th>
                            <th>Occupancy</th>
                            <th>Image</th>
                            <th>Single</th>
                            <th>Double</th>
                          </tr>
                        </thead>
                        <?php

                        $query = "SELECT * FROM tana_price ORDER BY id DESC";

                        $result = mysqli_query($connection, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                          echo "<tr>";
                          foreach ($row as $key => $value) {
                            $row[$key] = $value;

                            if ($key == 'room_img') {
                        ?>
                              <td>
                                <img width="100" src="./room_img/tana/<?php echo $row['room_img']; ?>" alt="">
                              </td>
                          <?php
                            } else {
                              echo "<td>$row[$key]</td>";
                            }
                          }
                          ?>

                          <?php
                          if ($role != 'RA') {
                          ?>
                            <!-- <td><?php echo "<a href='acc.php?edit={$type_id}'><i style='color: turquoise;' class='far fa-edit'></i> </a>"; ?></td>
                            <td><?php echo "<a href='acc.php?delete={$type_id}'><i style='color: red;' class='far fa-trash-alt'></i> </a>"; ?></td> -->
                            </tr>
                        <?php  }
                        } ?>


                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>



        </div>
        <!-- /.container-fluid -->

      </div>

      <?php
      // Delete Categories from data base
      if ($role != 'RA') {

        if (isset($_GET['delete'])) {
          $the_type_id = escape($_GET['delete']);
          $query = "DELETE FROM room_type WHERE type_id = {$the_type_id} ";
          $delete = mysqli_query($connection, $query);

          if (!$delete) {
            die('Can not delete data' . mysqli_error($connection));
          } else {
            header("Location: ./acc.php");
          }
        }
      }

      ?>
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


  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <!-- Core plugin JavaScript-->


  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.6.0/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/datatables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <script>
    $(document).ready(function() {
      $("#accTable").DataTable();
      $("#awashTable").DataTable();

    })
  </script>


  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>





  <!-- <script src="./js/room.js"></script> -->

</body>

</html>
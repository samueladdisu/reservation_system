<?php include './includes/admin_header.php'; ?>

<body id="page-top">

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

                    <!-- Page Heading -->
                    <div class="d_sm-flex align-items_center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Accomodation</h1>

                    </div>
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

                                    if ($type_location === "Bishoftu") {

                                        $s_weekend   = number_format($single - ($single * 0.1), 2, '.', '');
                                        $d_weekend   = number_format($double - ($double * 0.1), 2, '.', '');
                                        $s_member    = number_format($single - ($single * 0.25), 2, '.', '');
                                        $d_member    = number_format($double - ($double * 0.25), 2, '.', '');

                                        $query_bishoftu = "INSERT INTO room_type(type_name, type_location, occupancy, room_image, d_rack_rate, d_weekend_rate, d_member_rate, d_weekday_rate, s_rack_rate, s_weekend_rate, s_member_rate, s_weekday_rate) ";

                                        $query_bishoftu .= "VALUE ('$type_name', '$type_location', '$room_occupancy', '$room_image', $double, $d_weekend, $d_member, $d_weekdays, $single, $s_weekend, $s_member, $s_weekdays)";

                                        $result_bishoftu = mysqli_query($connection, $query_bishoftu);

                                        confirm($result_bishoftu);
                                    } else if ($type_location === "Awash") {

                                        $query_awash = "INSERT INTO room_type(type_name, type_location, occupancy, room_image, d_rack_rate, d_weekend_rate, d_weekday_rate, s_rack_rate, s_weekend_rate, s_weekday_rate) ";

                                        $query_awash .= "VALUE ('$type_name', '$type_location', '$room_occupancy', '$room_image', $double, $double, $d_weekdays, $single, $single, $s_weekdays)";

                                        $result_awash = mysqli_query($connection, $query_awash);

                                        confirm($result_awash);
                                    }



                                    // header("Refresh:0");
                                }


                                ?>


                                <form method="POST" class="row" enctype="multipart/form-data">


                                    <div class="form-group col-4">
                                        <label for="title">Room Occupancy</label>
                                        <input type="text" class="form-control" name="room_occupancy">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="type_name">Room Type</label>
                                        <input type="text" class="form-control" name="type_name">
                                    </div>



                                    <div class="form-group col-4">
                                        <label for="user_role"> Double Occupancy(rack rate)</label>
                                        <input type="text" class="form-control" name="d_rack_rate">
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="user_role"> Single Occupancy(rack rate) </label>
                                        <input type="text" class="form-control" name="s_rack_rate">
                                    </div>

                                    <?php

                                    if ($_SESSION['user_role'] != 'PA') {
                                    ?>
                                        <div class="form-group col-4">
                                            <label for="user_role"> Hotel Location </label> <br>
                                            <select name="type_location" class="custom-select" v-model="location" id="">
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

                                    <?php
                                    } else {
                                    ?>
                                        <input type="hidden" name="type_location" value="<?php echo $_SESSION['user_location']; ?>">

                                    <?php
                                    }

                                    ?>

                                    <div class="form-group col-4">
                                        <label for="type_name">Room Image</label> <br>
                                        <input type="file" name="room_image">

                                    </div>

                                    <div class="form-group col-12">
                                        <input type="submit" class="btn btn-primary" name="submit" value="Add">
                                    </div>
                                </form>

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
                                                    <th>Double Full</th>
                                                    <th>Double Weekend</th>
                                                    <th>Double member</th>
                                                    <th>Double Weekday</th>
                                                    <th>Single Full</th>
                                                    <th>Single Weekend</th>
                                                    <th>Single member</th>
                                                    <th>Single Weekday</th>
                                                    <th>Location</th>
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
            <span>Copyright &copy; Kuriftu resorts 2021. Powered by <a href="https://versavvymedia.com">Versavvy Media</a> </span>
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
      })
  </script>

  
  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>





  <!-- <script src="./js/room.js"></script> -->

</body>

</html>
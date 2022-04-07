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
            <h1 class="h3 mb-0 text-gray-800">Reservations</h1>

          </div>
          <!-- Content Row -->
          <div class="row">
            <div id="app">

              <table class="table table-bordered table-hover col-12" width="100%" cellspacing="0">
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

                  <?php
                  echo $location = $_SESSION['user_location'];

                  if ($_SESSION['page']) {
                    $page = $_SESSION['page'];
                  } else {
                    $page = "";
                  }

                  if ($page == "" || $page == 1) {
                    $page_1 = 0;
                  } else {
                    $page_1 = ($page * 10) - 10;
                  }

                  if ($location == "admin") {
                    $query = "SELECT * FROM reservations ORDER BY res_id DESC LIMIT $page_1, 10";
                  } else {
                    $query = "SELECT * FROM reservations WHERE res_location = '$location' ORDER BY res_id DESC LIMIT $page_1, 10";
                  }




                  $result = mysqli_query($connection, $query);
                  confirm($result);
                  while ($row = mysqli_fetch_assoc($result)) {
                    foreach ($row as $name => $value) {
                      if ($name == 'res_roomIDs') {
                        $db_res[$name] = json_decode($value, true);
                      } else {
                        $db_res[$name] = escape($value);
                      }
                    }

                    echo "<tr>";
                  ?>
                    <!-- <td><input type="checkbox" name="checkBoxArray[]" value="<?php echo $db_res['res_id']; ?>" @change="booked(row)" class="checkBoxes"></td> -->
                  <?php
                    echo "<td>{$db_res['res_id']}</td>";
                    echo "<td>{$db_res['res_firstname']}</td>";
                    echo "<td>{$db_res['res_lastname']}</td>";
                    echo "<td>{$db_res['res_phone']}</td>";
                    echo "<td>{$db_res['res_guestNo']}</td>";
                    echo "<td>{$db_res['res_checkin']}</td>";
                    echo "<td>{$db_res['res_checkout']}</td>";
                    echo "<td>{$db_res['res_paymentMethod']}</td>";
                    echo "<td>";
                    foreach ($db_res['res_roomIDs'] as $value) {
                      echo $value . ',';
                    }
                    echo  "</td>";
                    echo "<td>{$db_res['res_price']}</td>";
                    echo "<td>{$db_res['res_confirmID']}</td>";
                    if ($db_res['res_agent'] != 'website' && $db_res['res_paymentStatus'] != 'payed') {

                      echo "<td><a href='./reservations.php?source=edit_res&edit_id={$db_res['res_id']}'>Edit</a></td>";
                      echo "<td><a href='view_all_reservations.php?delete={$db_res['res_id']}'>Delete</a></td>";
                    }
                    echo "</tr>";
                  }


                  ?>

                </tbody>
              </table>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->


      <ul class="pagination my-3 justify-content-center">
        <?php

        if (isset($_GET['page'])) {
          $_SESSION['page'] = $_GET['page'];
        }
        $location = $_SESSION['user_location'];
        if ($location == "admin") {
          $res_count = "SELECT * FROM reservations";
        } else {
          $res_count = "SELECT * FROM reservations WHERE res_location = '$location'";
        }


        $find_count = mysqli_query($connection, $res_count);
        $count = mysqli_num_rows($find_count);
        $count = ceil($count / 10);
        for ($i = 1; $i <= $count; $i++) {
        ?>
          <li class="page-item"><a class="page-link" href="view_all_reservations.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>

        <?php }
        ?>
      </ul>

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Kuriftu resorts 2021. Developed by <a href="https://versavvymedia.com">Versavvy Media</a> </span>
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


  <?php

  if (isset($_GET['delete'])) {
    $rooms = array();
    $ary1 = [1, 3, 5];
    $the_post_id = escape($_GET['delete']);
    $select_rooms_query = "SELECT res_roomIDs FROM reservations WHERE res_id = $the_post_id";
    $select_rooms_result = mysqli_query($connection, $select_rooms_query);

    confirm($select_rooms_result);

    while ($row = mysqli_fetch_assoc($select_rooms_result)) {
      foreach ($row as  $val) {

        $rooms = json_decode($val);
      }
    }


    foreach ($rooms as  $val) {

      //    Update room status 
      $change_status_query = "UPDATE rooms SET room_status = 'Not_booked' WHERE room_id = '$val'";
      $change_status_result = mysqli_query($connection, $change_status_query);
      confirm($change_status_result);

      // Remove Room from Booked rooms table
      $delete_booked_rooms = "DELETE FROM booked_rooms WHERE b_roomId = $val";
      $delete_booked_rooms_result = mysqli_query($connection, $delete_booked_rooms);

      confirm($delete_booked_rooms_result);
    }

    $delete_query = "DELETE FROM reservations WHERE res_id = $the_post_id";
    $delete_result = mysqli_query($connection, $delete_query);
    confirm($delete_result);
    header("Location: ./view_all_reservations.php");
  }

  ?>

  <!-- Bootstrap core JavaScript-->
  <script src="./vendor/jquery/jquery.min.js"></script>
  <script src="./vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/vue@3.0.2"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="./js/load.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="./vendor/jquery-easing/jquery.easing.min.js"></script>


  <script>
    // $(document).ready(function() {
    //   get_data()
    //   setInterval(function() {
    //     get_data()
    //   }, 20000);

    //   function get_data() {
    //     jQuery.ajax({
    //       type: "GET",
    //       url: "./includes/load_reservation.php",
    //       data: '',
    //       beforeSend: function() {

    //       },
    //       complete: function() {

    //       },
    //       success: function(data) {
    //         $("table").html(data);
    //       }
    //     })
    //   }
    // })
  </script>

  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('341b77d990ca9f10d6d9', {
      cluster: 'mt1',
      encrypted: true
    });

    var channel = pusher.subscribe('notifications');
    channel.bind('new_reservation', function(data) {
      // alert(JSON.stringify(data));
      console.log(data[1][2]);
    });

    const app = new Vue({
      el: '#app',
      data: {
        messages: [],
      },
    });
  </script>

  <!-- Custom scripts for all pages-->
  <script src="./js/sb-admin-2.min.js"></script>


</body>

</html>
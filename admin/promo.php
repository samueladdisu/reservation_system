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
            <h1 class="h3 mb-0 text-gray-800">Promo Code</h1>

          </div>
          <!-- Content Row -->
          <div class="row">

            <?php
            if ($_SESSION['user_role'] == 'SA') {
            ?>
              <div class="col-4">
                <?php

                if (isset($_POST['add_promo'])) {
                  $promo_code = escape($_POST['promo_code']);
                  $promo_amount = escape($_POST['promo_amount']);
                  $promo_time = escape($_POST['promo_time']);
                  $promo_usage = escape($_POST['promo_usage']);

                  if ($promo_code == "" || $promo_amount == "") {
                    echo "<script> alert('Please fill all field');</script>";
                  } else {
                    $query = "INSERT INTO promo (promo_code, promo_amount, promo_time, promo_usage) ";
                    $query .= "VALUE ('{$promo_code}', '$promo_amount', '$promo_time', '$promo_usage')";

                    $create_category = mysqli_query($connection, $query);

                    if (!$create_category) {
                      die('Query Failed' . mysqli_error($connection));
                    }
                  }
                }


                ?>


                <form action="" method="post">
                  <div class="form-group">
                    <label for="type_name">Promo Code</label>
                    <input type="text" class="form-control" name="promo_code" id="">
                  </div>
                  <div class="form-group">
                    <label for="type_name">Discount Amount(%)</label>
                    <input type="text" class="form-control" name="promo_amount" id="">
                  </div>
                  <div class="form-group">
                    <label for="type_name">Expiration Date</label>
                    <input type="datetime-local" class="form-control" 
                    name="promo_time">
                  </div>
                  <div class="form-group">
                    <label for="type_name">Number of Usage</label>
                    <input type="text" class="form-control" name="promo_usage" id="">
                  </div>

                  <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="add_promo" value="Add">
                  </div>
                </form>

                <?php
                if (isset($_GET['edit'])) {
                  $cat_id = escape($_GET['edit']);
                  include './includes/update_promo.php';
                }


                ?>
                <?php
                // Delete Categories from data base
                if (isset($_GET['delete'])) {
                  $the_type_id = escape($_GET['delete']);
                  $query = "DELETE FROM promo WHERE promo_id = {$the_type_id} ";
                  $delete = mysqli_query($connection, $query);

                  if (!$delete) {
                    die('Can not delete data' . mysqli_error($connection));
                  } else {
                    header("Location: ./promo.php");
                  }
                }

                ?>

              </div>
            <?php  }


            ?>


            <div class="col-8">


              <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Promo Code</th>
                    <th>Amount</th>
                    <th>Expiration Date</th>
                    <th>Usage</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  $query = "SELECT * FROM promo ORDER BY promo_id DESC";

                  $result = mysqli_query($connection, $query);

                  while ($row = mysqli_fetch_assoc($result)) {
                    $promo_id = $row['promo_id'];
                    $promo_code = $row['promo_code'];
                    $promo_amount = $row['promo_amount'];
                    $promo_time = $row['promo_time'];
                    $promo_usage = $row['promo_usage'];
                  ?>
                    <tr>
                      <td><?php echo $promo_id; ?></td>
                      <td><?php echo $promo_code; ?></td>
                      <td><?php echo $promo_amount; ?></td>
                      <td><?php echo $promo_time; ?></td>
                      <td><?php echo $promo_usage; ?></td>

                      <?php

                      if ($_SESSION['user_role'] == 'SA') {
                      ?>



                        <td><?php echo "<a href='promo.php?delete={$promo_id}'><i style='color: red;' class='far fa-trash-alt'></i> </a>"; ?></td>
                        <td><?php echo "<a href='promo.php?edit={$promo_id}'> <i style='color: turquoise;' class='far fa-edit'></i> </a>"; ?></td>
                    </tr>
                <?php  }
                    } ?>





                </tbody>
              </table>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <?php include './includes/admin_footer.php'; ?>

      
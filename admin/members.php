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
        <?php

        if ($_SESSION['user_location'] == 'admin') {
        ?>

          <!-- Begin Page Content -->
          <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 text-gray-800">Members</h1>

            </div>
            <!-- Content Row -->
            <div class="row">
              <?php
              if (isset($_GET['source'])) {
                $source = escape($_GET['source']);
              } else {
                $source = '';
              }
              switch ($source) {
                case 'add_member':
                  include "./includes/add_member.php";
                  break;
                case 'edit_member':
                  include "./includes/edit_member.php";
                  break;
                default:
                  include "./includes/view_all_members.php";
                  break;
              }


              ?>
            </div>

          </div>
          <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
    <?php    } else { ?>
      <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">Sorry, You're Not Allowed in this area</h1>

        </div>
        <!-- Content Row -->
        <div class="row">

        </div>

      </div>
    <?php } ?>
    <?php include './includes/admin_footer.php'; ?>
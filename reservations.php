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
            <h1 class="h3 mb-0 text-gray-800">Reservations</h1>

          </div>
          <!-- Content Row -->
          <div class="row">
            <?php
              if(isset($_GET['source'])){
                $source = escape($_GET['source']);
                
              }else{
                $source = '';
              }
              switch($source){
                case 'add_reservation':
                  include "./add_reservation.php";
                  break;
                case 'edit_reservation':
                  include "./includes/edit_reservation.php";
                  break;
                default:
                  header("Location: ./view_all_reservations.php");
                  
                  break;
              }
            
            
            ?>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <?php include './includes/admin_footer.php'; ?>
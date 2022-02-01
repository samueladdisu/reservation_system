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
                            | <small class="text-gray-600"><?php echo $_SESSION['username']; ?></small></h1>

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
                                                if($location == "admin"){
                                                    $query = "SELECT * FROM reservations";

                                                }else {
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

                                                if($location == 'admin'){

                                                    $query = "SELECT * FROM rooms";
                                                }else{

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
                                                    Accomodation</div>
                                                <?php

                                                if ($location == 'admin') {
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

                    <div class="row">

                    </div>

                    <!-- Content Row -->


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include './includes/admin_footer.php'; ?>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load('current', {
                    'packages': ['bar']
                });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        //   ['Data', 'Count'],

                        <?php

                        $element_text = ['Active Posts', 'Categories', 'Users', 'Comments'];
                        $element_count = [$post_count, $category_counts, $users_counts, $comments_counts];

                        for ($i = 0; $i < 4; $i++) {
                            echo "['$element_text[$i]']" . "," . "[$element_count[$i]],";
                        }


                        ?>



                        //   ['Posts', 1000]
                    ]);

                    var options = {
                        chart: {}
                    };

                    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                    chart.draw(data, google.charts.Bar.convertOptions(options));
                }
            </script>
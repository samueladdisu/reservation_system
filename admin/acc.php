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
                        <h1 class="h3 mb-0 text-gray-800">Accomodation</h1>

                    </div>
                    <!-- Content Row -->
                    <div class="row">
                        <?php
                        global $type_location;
                        if ($_SESSION['user_role'] == 'SA' || $_SESSION['user_role'] == 'PA') {
                        ?>
                            <div class="col-4">
                                <?php



                                if (isset($_POST['submit'])) {
                                    $type_name = escape($_POST['type_name']);
                                    $type_location = escape($_POST['type_location']);
                                    $rack_rate = escape($_POST['rack_rate']);
                                    if ($type_name == "") {
                                        echo "<script> alert('Please Enter Category Title');</script>";
                                    } else {
                                        $query = "INSERT INTO room_type (type_name, type_location, rack_rate) ";
                                        $query .= "VALUE ('{$type_name}', '$type_location', '$rack_rate')";

                                        $create_category = mysqli_query($connection, $query);

                                        if (!$create_category) {
                                            die('Query Failed' . mysqli_error($connection));
                                        }
                                    }

                                    header("Refresh:0");

                                }


                                ?>


                                <form action="" method="post">




                                    <div class="form-group">
                                        <label for="type_name">Room Type</label>
                                        <input type="text" class="form-control" name="type_name" id="">
                                    </div>
                                    <div class="form-group">
                                        <label for="user_role"> Full Amount </label>
                                        <input type="text" class="form-control" name="rack_rate" id="">
                                    </div>

                                    <?php

                                    if ($_SESSION['user_role'] != 'PA') {
                                    ?>
                                        <div class="form-group">
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



                                    <div class="form-group">
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

                        <div class="col-8">


                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Accomodation</th>
                                        <th>Full Amount(Rack Rate)</th>
                                        <th>Price for today</th>
                                        <th>Location</th>
                                        <?php

                                        if ($_SESSION['user_role'] == 'admin') {
                                            echo "<th>Location</th>";
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    date_default_timezone_set('Africa/Addis_Ababa');
                                    $monday = date('m/d/Y', strtotime('monday'));
                                    $friday = date('m/d/Y', strtotime('friday'));
                                    $sunday = date('m/d/Y', strtotime('sunday'));
                                    $thursday = date('m/d/Y', strtotime('thursday'));
                                    $saturday = date('m/d/Y', strtotime('saturday'));
                                    // echo $weekdays;

                                    $today =  date('m/d/Y', strtotime('friday'));

                                    $room_query = "SELECT * FROM room_type";
                                    $result = mysqli_query($connection, $room_query);

                                    while($row = mysqli_fetch_assoc($result)){

                                        $price = $row['rack_rate'];
                                        
                                        if ($today >= $sunday || $today <= $thursday) {

                                            $weekday_rate = $price * 0.15;

                                            $price = $price - $weekday_rate;

                                            $update_price = "UPDATE room_type SET room_price = $price";
                                            $result_price = mysqli_query($connection, $update_price);
                                            confirm($result_price);

                                          

                                        } else if($today == $friday){

                                            $weekend_rate = $price * 0.909;

                                            $update_price = "UPDATE room_type SET room_price = $weekend_rate";
                                            $result_price = mysqli_query($connection, $update_price);
                                            confirm($result_price);
                                        } else if($today == $saturday){
                                            $update_price = "UPDATE room_type SET room_price = $price";
                                            $result_price = mysqli_query($connection, $update_price);
                                            confirm($result_price);
                                        }
                                    }
                                    // Display categories from database
                                    $location = $_SESSION['user_location'];
                                    $role = $_SESSION['user_role'];
                                    if ($location == 'Boston' && $role == 'SA') {
                                        $query = "SELECT * FROM room_type ORDER BY type_id DESC";
                                    } else {
                                        $query = "SELECT * FROM room_type WHERE type_location = '$location' ORDER BY type_id DESC";
                                    }

                                    $result = mysqli_query($connection, $query);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $type_id = $row['type_id'];
                                        $type_name = $row['type_name'];
                                        $db_rack_rate = $row['rack_rate'];
                                        $type_location = $row['type_location'];
                                        $room_price = $row['room_price'];
                                    ?>
                                        <tr>
                                            <td><?php echo $type_id; ?></td>
                                            <td><?php echo $type_name; ?></td>
                                            <td><?php echo $db_rack_rate; ?></td>
                                            <td><?php echo $room_price; ?></td>
                                            <?php
                                            if ($location == 'Boston') {
                                                echo "<td> $type_location </td>";
                                            }
                                            if ($role != 'RA') {
                                            ?>


                                                <td><?php echo "<a href='acc.php?edit={$type_id}'>Edit </a>"; ?></td>
                                                <td><?php echo "<a href='acc.php?delete={$type_id}'>Delete </a>"; ?></td>
                                        </tr>
                                <?php  }
                                        } ?>

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



                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include './includes/admin_footer.php'; ?>
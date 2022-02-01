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
                        <h1 class="h3 mb-0 text-gray-800">Locations</h1>

                    </div>
                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-4">
                            <?php

                            if (isset($_POST['submit'])) {
                                $location_name = escape($_POST['location_name']);
                                if ($location_name == "") {
                                    echo "<script> alert('Please Enter location Name');</script>";
                                } else {
                                    $query = "INSERT INTO locations (location_name) ";
                                    $query .= "VALUE ('{$location_name}')";

                                    $create_category = mysqli_query($connection, $query);

                                    if (!$create_category) {
                                        die('Query Failed' . mysqli_error($connection));
                                    }
                                }
                            }


                            ?>


                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="type_name">Location name</label>
                                    <input type="text" class="form-control" name="location_name" id="">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="submit" value="Add">
                                </div>
                            </form>

                            <?php
                            if (isset($_GET['edit'])) {
                                $cat_id = escape($_GET['edit']);
                                include './includes/update_location.php';
                            }


                            ?>

                        </div>

                        <div class="col-8">


                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php


                                    $query = "SELECT * FROM locations ";
                                    $result = mysqli_query($connection, $query);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $location_id = $row['location_id'];
                                        $location_name = $row['location_name'];
                                        
                                    ?>
                                        <tr>
                                            <td><?php echo $location_id; ?></td>
                                            <td><?php echo $location_name; ?></td>
                                            <td><?php echo "<a href='locations.php?delete={$location_id}'>Delete </a>"; ?></td>
                                            <td><?php echo "<a href='locations.php?edit={$location_id}'>Edit </a>"; ?></td>
                                        </tr>
                                    <?php  } ?>

                                    <?php
                                    // Delete Categories from data base
                                    if (isset($_GET['delete'])) {
                                        $the_type_id = escape($_GET['delete']);
                                        $query = "DELETE FROM locations WHERE location_id = {$the_type_id} ";
                                        $delete = mysqli_query($connection, $query);

                                        if (!$delete) {
                                            die('Can not delete data' . mysqli_error($connection));
                                        } else {
                                            header("Location: ./locations.php");
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
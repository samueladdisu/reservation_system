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

                        <div class="col-4">
                            <?php

                            if (isset($_POST['submit'])) {
                                $type_name = escape($_POST['type_name']);
                                $type_location = escape($_POST['type_location']);
                                if ($type_name == "") {
                                    echo "<script> alert('Please Enter Category Title');</script>";
                                } else {
                                    $query = "INSERT INTO room_type (type_name, type_location) ";
                                    $query .= "VALUE ('{$type_name}', '$type_location')";

                                    $create_category = mysqli_query($connection, $query);

                                    if (!$create_category) {
                                        die('Query Failed' . mysqli_error($connection));
                                    }
                                }
                            }


                            ?>


                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="type_name">Room Type</label>
                                    <input type="text" class="form-control" name="type_name" id="">
                                </div>


                                <?php
                                global $type_location;
                                if ($_SESSION['user_role'] == 'admin') {
                                ?>

                                    <div class="form-group">
                                        <label for="user_role"> Hotle Location </label> <br>
                                        <select name="type_location" class="custom-select" id="">
                                            <option>Select option</option>
                                            <option value="Bishoftu">Bishoftu</option>
                                            <option value="Adama">Adama</option>
                                            <option value="Entoto">Entoto</option>
                                            <option value="Lake_Tana">Lake Tana</option>
                                            <option value="Awash">Awash</option>
                                            <option value="Boston">Boston</option>
                                        </select>
                                    </div>

                                <?php  } else { ?>

                                    <input type="hidden" name="type_location" value="<?php echo $_SESSION['user_role']; ?>">

                                <?php } ?>
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

                        <div class="col-8">


                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    // Display categories from database
                                    $location = $_SESSION['user_role'];

                                    $query = "SELECT * FROM room_type WHERE type_location = '$location' ";
                                    $result = mysqli_query($connection, $query);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $type_id = $row['type_id'];
                                        $type_name = $row['type_name'];
                                        $type_location = $row['type_location'];
                                    ?>
                                        <tr>
                                            <td><?php echo $type_id; ?></td>
                                            <td><?php echo $type_name; ?></td>
                                            <td><?php echo "<a href='acc.php?delete={$type_id}'>Delete </a>"; ?></td>
                                            <td><?php echo "<a href='acc.php?edit={$type_id}'>Edit </a>"; ?></td>
                                        </tr>
                                    <?php  } ?>

                                    <?php
                                    // Delete Categories from data base
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
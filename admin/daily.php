<?php include './includes/admin_header.php'; ?>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include './includes/sidebar.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div style="width: 100vw;" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include './includes/topbar.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <!-- <h1 class="h3 mb-0 text-gray-800">Reservations</h1> -->

          </div>
          <!-- Content Row -->
          <div class="row">
            <div class="col-12 mb-2">


              <div id="resApp">
                <!-- Delete Modal  -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Are you sure You want to Delete?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <div class="modal-body">Select "Delete" to confirm deletion.</div>
                      <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" @click="deleteRes" data-dismiss="modal">Delete</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End of Delete Modal  -->

                <!-- View Full Reservation Details Modal -->
                <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">
                          {{ tempRow.res_firstname }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div v-if="guestInfo.length > 0">
                          <h1 class="my-2">Room Info</h1>

                          <div class="card-group">

                            <div class="card" style="width: 18rem;" v-for="row in guestInfo" :key="row.info_id">
                              <div class="card-body">
                                <h5 class="card-title font-weight-bold"> {{ row.info_room_acc }} <span v-if="row.info_board"> - {{ row.info_board }} </span> </h5>

                              </div>
                              <ul class="list-group list-group-flush">
                                <li class="list-group-item"> <strong>Adults:</strong>{{ row.info_adults }}</li>
                                <li class="list-group-item"> <strong>Kids:</strong> {{ row.info_kids }}</li>
                                <li class="list-group-item"> <strong>Teens:</strong> {{ row.info_teens }}</li>
                                <li class="list-group-item"> <strong>Room Number:</strong> {{ row.info_room_number }}</li>
                                <li class="list-group-item"> <strong>Room Location:</strong> {{ row.info_room_location }}</li>
                              </ul>
                            </div>
                          </div>

                        </div>

                        <h1 class="my-2">Detail Guest Info</h1>

                        <div class="card-group mt-4">
                          <div class="card" style="width: 18rem;">
                            <ul class="list-group">
                              <li class="list-group-item"> <strong>Full Name:</strong> {{ tempRow.res_firstname }} {{ tempRow.res_lastname }}</li>
                              <li class="list-group-item"> <strong>Phone:</strong> {{ tempRow.res_phone }}</li>
                              <li class="list-group-item"> <strong> Email: </strong>{{ tempRow.res_email }}</li>
                              <li class="list-group-item"> <strong>Check in:</strong> {{ tempRow.res_checkin }}</li>
                              <li class="list-group-item"> <strong>Check out:</strong> {{ tempRow.res_checkout }}</li>
                              <li class="list-group-item"> <strong>Agent:</strong> {{ tempRow.res_agent }}</li>
                            </ul>
                          </div>

                          <div class="card" style="width: 18rem;">

                            <ul class="list-group">
                              <li class="list-group-item"> <strong>Group Name:</strong> {{ tempRow.res_groupName }}</li>
                              <li class="list-group-item"> <strong>Price:</strong> {{ tempRow.res_price }}</li>
                              <li class="list-group-item"> <strong> Remark: </strong>{{ tempRow.res_remark }}</li>
                              <li class="list-group-item"> <strong>Promo:</strong> {{ tempRow.res_promo }}</li>
                              <li class="list-group-item"> <strong>Date of Birth:</strong> {{ tempRow.res_dob }}</li>
                              <li class="list-group-item"> <strong>Member User name:</strong> {{ tempRow.res_member }}</li>
                            </ul>
                          </div>

                        </div>

                        <div class="card-group  mt-4">
                          <div class="card" style="width: 18rem;">
                            <ul class="list-group">
                              <li class="list-group-item"> <strong>Location:</strong> {{ tempRow.res_location }}</li>
                              <li class="list-group-item"> <strong>Confirm ID:</strong> {{ tempRow.res_confirmID }}</li>
                              <li class="list-group-item"> <strong> Special Request: </strong>{{ tempRow.res_specialRequest }}</li>
                              <li class="list-group-item"> <strong>Payment Status:</strong> {{ tempRow.res_paymentStatus }}</li>
                              <li class="list-group-item"> <strong>Check out:</strong> {{ tempRow.res_checkout }}</li>
                              <li class="list-group-item"> <strong>Booked At:</strong> {{ tempRow.created_at }}</li>
                            </ul>
                          </div>
                          <div class="card" style="width: 18rem;">
                            <ul class="list-group">
                              <li class="list-group-item"> <strong>Contry:</strong> {{ tempRow.res_country }}</li>
                              <li class="list-group-item"> <strong>Address:</strong> {{ tempRow.res_address }}</li>
                              <li class="list-group-item"> <strong> City: </strong>{{ tempRow.res_city }}</li>
                              <li class="list-group-item"> <strong>Zip Code:</strong> {{ tempRow.res_zipcode }}</li>
                              <li class="list-group-item"> <strong>Payment Method:</strong> {{ tempRow.res_paymentMethod }}</li>
                              <li class="list-group-item"> <strong>Payment Confirmed At:</strong> {{ tempRow.payment_confirmed_at }}</li>
                            </ul>
                          </div>



                        </div>

                      </div>

                    </div>
                  </div>
                </div>

                <!-- End of View Full Reservation Details -->
                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Exchange Rates</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="table-responsive">
                          <table class="table display table-bordered" width="100%" id="exRates" cellspacing="0">


                            <thead>
                              <tr>
                                <th>Id</th>
                                <th>Date</th>
                                <th>Rate</th>
                              </tr>
                            </thead>
                            <?php

                            $ex_query = "SELECT * FROM exchage_rates ORDER BY id DESC";
                            $ex_result = mysqli_query($connection, $ex_query);

                            confirm($ex_result);

                            while ($row = mysqli_fetch_assoc($ex_result)) {
                            ?>
                              <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['date'] ?></td>
                                <td><?php echo $row['rate'] ?></td>
                              </tr>
                            <?php
                            }

                            ?>

                          </table>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>

                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Room Status </h6>
                  </div>
                  <div class="card-body">
                    <div class="row py-1">

                      <div class="form-group mt-2 col-3">
                        <input type="date" v-model="filterDate" class="form-control" />
                      </div>

                      <!------------------------- t-date picker end  ------------------>

                      <?php

                      if ($_SESSION['user_role'] == 'SA' || ($_SESSION['user_location'] == 'Boston' && $_SESSION['user_role'] == 'RA')) {

                      ?>
                        <div class="form-group mt-2 col-2">
                          <select name="room_location" class="custom-select" v-model="filterLocation" @change="checkLocation" id="">
                            <option disabled value="">Resort Location</option>
                            <?php

                            $query = "SELECT * FROM locations";
                            $result = mysqli_query($connection, $query);
                            confirm($result);

                            while ($row = mysqli_fetch_assoc($result)) {
                              $location_id = $row['location_id'];
                              $location_name = $row['location_name'];

                              if ($location_name != 'Boston') {

                                echo "<option value='$location_name'>{$location_name}</option>";
                              }
                            }
                            ?>
                          </select>
                        </div>
                      <?php } else { ?>
                        <input type="hidden" name="room_location" value="<?php echo $_SESSION['user_location']; ?>">


                      <?php  }


                      ?>

                      <div id="bulkContainer" class="col-3 mt-2">

                        <?php

                        if ($_SESSION['user_role'] == 'SA' || ($_SESSION['user_location'] == 'Boston' && $_SESSION['user_role'] == 'RA')) {

                        ?>

                          <button name="booked" @click.prevent="fetchRoomStatus(filterLocation)" class="btn btn-success">Filter</button>

                          <button @click.prevent="fetchRoomStatus('all')" class="btn btn-danger mx-2">Clear Filters</button>

                        <?php } else { ?>
                          <input type="hidden" name="room_location" value="<?php echo $_SESSION['user_location']; ?>">

                          <button name="booked" @click.prevent="fetchRoomStatus('<?php echo $_SESSION['user_location']; ?>')" class="btn btn-success">Filter</button>

                          <button @click.prevent="fetchRoomStatus('<?php echo $_SESSION['user_location']; ?>')" class="btn btn-danger mx-2">Clear Filters</button>
                        <?php  } ?>





                      </div>

                    </div>

                    <div class="table-responsive">
                      <table class="table display table-bordered" width="100%" id="roomStatus" cellspacing="0">


                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>Type</th>
                            <th>Room no.</th>
                            <th>Guest Name</th>
                            <th>Adults</th>
                            <th>Kids</th>
                            <th>teens</th>
                            <th>Arrival</th>
                            <th>Departure</th>
                            <th>Status</th>
                            <th>Remark</th>
                            <th>Location</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>

                      </table>
                    </div>
                  </div>
                </div>


                <div class="card shadow mb-4" id="resTable">
                  <div class="card-header d-flex justify-content-between py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Reservations</h6>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                      Exchange Rates
                    </button>

                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table display table-bordered" width="100%" id="viewResTable" cellspacing="0">


                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone</th>
                            <th>Arrival</th>
                            <th>Departure</th>
                            <th>Total Price</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>

                      </table>
                    </div>
                  </div>
                </div>

              </div>


              <div id="viewSpecial">

                <!-- Delete Modal Special request table  -->
                <div class="modal fade" id="deleteModalSpecial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Are you sure You want to Delete the Special Request?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <div class="modal-body">Select "Delete" to confirm deletion.</div>
                      <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" @click="deleteReq" data-dismiss="modal">Delete</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End of Delete Modal Special request table  -->
                <div class="card shadow mb-4">
                  <div class="card-header d-flex py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Special Request Table</h6>


                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table display table-bordered" width="100%" id="viewReq" cellspacing="0">


                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>Guest Name</th>
                            <th>Type</th>
                            <th>Non specified Type</th>
                            <th># of people</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Created by</th>
                            <th>Created at</th>
                            <th>Updated by</th>
                            <th>Updated at</th>
                            <th>Remark</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>

                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div id="groupResApp">

                <!-- View Full Reservation Details Modal -->
                <div class="modal fade" id="view-group-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">
                          {{ tempRow.group_name }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">

                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                          <thead>
                            <th>
                              Name
                            </th>
                            <th>
                              Value
                            </th>
                          </thead>
                          <tbody>
                            <tr v-for="(value, key) in tempRow">
                              <td>
                                {{ key }}
                              </td>
                              <td>
                                {{ value }}
                              </td>
                            </tr>
                          </tbody>
                        </table>

                      </div>

                    </div>
                  </div>
                </div>

                <!-- End of View Full Reservation Details -->

                <!-- Delete Modal  -->
                <div class="modal fade" id="deleteModalGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Are you sure You want to Delete?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <div class="modal-body">Select "Delete" to confirm deletion.</div>
                      <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" @click="deleteGroupRes" data-dismiss="modal">Delete</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End of Delete Modal  -->

                <!-- Add Guest At Check in Modal -->


                <div class="modal fade" style="z-index: 99999;" id="addGuest" tabindex="-1" role="dialog">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Guest</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form class="row">

                          <div class="form-group col-6">
                            <label for="recipient-name" class="col-form-label">First Name:</label>
                            <input type="text" v-model="formData.firstName" class="form-control" id="recipient-name">
                          </div>
                          <div class="form-group col-6">
                            <label for="recipient-name" class="col-form-label">Last Name:</label>
                            <input type="text" v-model="formData.lastName" class="form-control" id="recipient-name">
                          </div>
                          <div class="form-group col-12">
                            <label for="recipient-name" class="col-form-label">Email:</label>
                            <input type="text" v-model="formData.email" class="form-control" id="recipient-name">
                          </div>
                          <div class="form-group col-6">
                            <label for="recipient-name" class="col-form-label">Phone:</label>
                            <input type="text" v-model="formData.phone" class="form-control" id="recipient-name">
                          </div>

                          <div class="form-group col-6">
                            <label for="recipient-name" class="col-form-label">Date of Birth:</label>
                            <input type="date" v-model="formData.dob" class="form-control" id="recipient-name">
                          </div>

                          <div class="form-group col-6">
                            <label for="recipient-name" class="col-form-label">Check in:</label>
                            <input type="date" class="form-control" :value="tempcheckin" readonly>
                          </div>

                          <div class="form-group col-6">
                            <label for="recipient-name" class="col-form-label">Check Out:</label>
                            <input type="date" class="form-control" :value="tempcheckout" readonly>
                          </div>

                          <div class="form-group col-12">
                            <label for="recipient-name" class="col-form-label">Remark</label>
                            <textarea name="" v-model="formData.remark" class="form-control" cols="30" rows="7"></textarea>
                          </div>

                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" @click.prevent="addGuest" class="btn btn-secondary">Add</button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- End of Add Guest At Check in Modal -->

                <!-- Select Room for Single guest res  -->

                <div class="modal fade" id="selectRoom" tabindex="-1" role="dialog">
                  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Select Room

                        </h5>
                        <button type="button" class="close" data-dismiss="modal">
                          <span>&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="container-fluid">




                          <div class="table-responsive">

                            <table class="table display table-bordered table-hover" id="addSingleTable" width="100%" cellspacing="0">

                              <thead>
                                <tr>
                                  <th>Id</th>
                                  <th>Room Id</th>
                                  <th>Room Type</th>
                                  <th>Room Number</th>
                                  <th>Hotel Location</th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>

                        </div>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- End of Select Room for Single guest res  -->

                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Group Reservations</h6>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table display table-bordered" width="100%" id="viewBulkTable" cellspacing="0">


                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>Group Name</th>
                            <th>Guest Number</th>
                            <th>Rooms</th>
                            <th>Ava. Rooms</th>
                            <th>Check in</th>
                            <th>Check out</th>
                            <th>Reason</th>
                            <th>Remark</th>
                            <th>Location</th>
                            <th>Total Price</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>

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


  <!-- <script src="https://unpkg.com/axios/dist/axios.min.js"></script> -->
  <script src="https://unpkg.com/axios@0.27.2/dist/axios.min.js"></script>
  <!-- Core plugin JavaScript-->


  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.6.0/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/datatables.min.js"></script>
  <script src="./vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>


  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <script src="./js/res.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="./js/sb-admin-2.min.js"></script>


  <script>
    $(document).ready(function() {

      $('#exRates').DataTable({
        order: [
          [0, 'des']
        ],
      });
    })

    // Reservation and Room Status Table 
    const resApp = Vue.createApp({
      data() {
        return {
          posts: [''],
          tempRow: {},
          location: '',
          filterDate: "<?php echo date('Y-m-d'); ?>",
          location: '',
          modal: "",
          tempcheckin: '',
          tempcheckout: '',
          firstName: '',
          lastName: '',
          email: '',
          phone: '',
          dob: '',
          remark: '',
          tempDelete: {},
          guestInfo: []
        }
      },
      methods: {
        table(row) {
          $('#viewResTable').DataTable({
            destroy: true,
            dom: 'lBfrtip',
            buttons: [
              'excel',
              'print',
              'csv'
            ],
            order: [
              [0, 'desc']
            ],
            data: row,
            columns: [{
                data: 'res_id'
              },
              {
                data: 'res_firstname'
              },
              {
                data: 'res_lastname'
              },
              {
                data: 'res_phone'
              },
              {
                data: 'res_checkin'
              },
              {
                data: 'res_checkout'
              },
              {
                data: 'res_price'
              },
              {
                data: 'res_id',
                render: function(data) {
                  return `<div class="dropdown no-arrow">
                  <a class="dropdown-toggle"  role="button" id="dropdownMenuLink" data-toggle="dropdown">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-600"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                    <a data-toggle="modal" :data-target="modal" class="dropdown-item" >
                      Add
                    </a>
                    <a class="dropdown-item" data-id="${data}" id="view" >
                      View
                    </a>
                    <a class="dropdown-item" id="edit" href="edit_reservation.php?id=${data}" >
                      Edit
                    </a>
                    <div class="dropdown-divider"></div>
                    <a data-id="${data}" id="delete"  class="dropdown-item text-danger">
                      Delete
                    </a>

                  </div>
                </div>`
                }
              }
            ],
          });


          let vm = this

          // $(document).on('click', '#edit', function(){
          //   let res_id = $(this).data("id")

          // })

          $(document).on('click', '#delete', function() {
            // get room id from the table
            let ids = $(this).data("id")
            let temprow = {}

            // filter alldata which is equal to the room id
            vm.posts.forEach(item => {
              if (item.res_id == ids) {
                temprow = item
              }
            })

            // assign to temp row
            vm.tempDelete = temprow
            console.log("temp row", vm.tempDelete);
            $('#deleteModal').modal('show')
          })

          $(document).on('click', '#view', function() {
            // get room id from the table
            let ids = $(this).data("id")
            let temprow = {}

            // filter alldata which is equal to the room id
            vm.posts.forEach(item => {
              if (item.res_id == ids) {
                temprow = item
              }
            })

            // assign to temp row
            vm.tempRow = temprow
            console.log("temp row", vm.tempRow);
            vm.fetchGuestinfo()
            $('#exampleModalLong').modal('show')
          })

        },
        async deleteRes() {
          await axios.post('./includes/backEndreservation.php', {
            action: 'delete',
            row: this.tempDelete
          }).then(res => {
            console.log(res.data);
            this.fetchData()
          })
        },
        fetchData() {
          axios.post('./includes/backEndreservation.php', {
            action: 'fetchResDaily'
          }).then(res => {
            // console.log("comes from api", res.data);
            this.posts = res.data
            this.table(res.data)
          })
        },
        async fetchGuestinfo() {
          await axios.post('./includes/backEndreservation.php', {
            action: 'guestInfo',
            id: this.tempRow.res_id
          }).then(res => {
            console.log(res.data);

            this.guestInfo = res.data
          })
        },
        async fetchRoomStatus(flocation = "all") {

          // console.log(flocation);
          // console.log(this.filterDate)
          await axios.post('./includes/backEndreservation.php', {
            action: 'roomStatus',
            location: flocation,
            date: this.filterDate
          }).then(res => {
            // console.log(res.data[0].b_checkin);

            res.data.forEach(item => {
              item.status = ""

              if (item.b_checkin === null) {
                item.status = "Free"
              } else if (item.b_checkin === this.filterDate) {
                item.status = "Arrival"
              } else if (this.filterDate > item.b_checkin && this.filterDate < item.b_checkout) {
                item.status = "Stay over"
              } else if (item.b_checkout === this.filterDate) {
                item.status = "Departure"
              }


            });

            console.log(res.data)
            this.roomStatusTable(res.data)
          })
        },
        roomStatusTable(row) {
          $('#roomStatus').DataTable({
            destroy: true,
            dom: 'lBfrtip',
            iDisplayLength: 150,
            scrollY: "500px",
            buttons: [
              'excel',
              'print',
              'csv'
            ],
            order: [
              [0, 'asc']
            ],
            data: row,
            columns: [{
                data: 'room_id'
              },
              {
                data: 'room_acc'
              },
              {
                data: 'room_number'
              },
              {
                data: 'res_firstname'
              },
              {
                data: 'info_adults'
              },
              {
                data: 'info_kids'
              },
              {
                data: 'info_teens'
              },
              {
                data: 'b_checkin'
              },
              {
                data: 'b_checkout'
              },
              {
                data: 'status',
              },
              {
                data: 'res_remark'
              },
              {
                data: 'room_location'
              }
            ],
          });

        },

      },
      created() {
        this.fetchData()
        <?php

        if ($_SESSION['user_role'] == 'SA' || ($_SESSION['user_location'] == 'Boston' && $_SESSION['user_role'] == 'RA')) {
        ?>
          this.fetchRoomStatus()

        <?php } else { ?>

          this.fetchRoomStatus('<?php echo $_SESSION['user_location']; ?>')

        <?php  } ?>
      }
    })

    const resAppVm = resApp.mount("#resApp")

    // End of res and roomstatus app

    // Special request Table 
    const reqapp = Vue.createApp({
      data() {
        return {
          allData: [],
          tempDelete: {}
        }
      },
      methods: {
        table(row) {
          $('#viewReq').DataTable({
            destroy: true,
            dom: 'lBfrtip',
            buttons: [
              'excel',
              'print',
              'csv'
            ],
            order: [
              [0, 'desc']
            ],
            data: row,
            columns: [{
                data: 'id'
              },
              {
                data: 'guest_name'
              },
              {
                data: 'type'
              },
              {
                data: 'other_type'
              },
              {
                data: 'number_of_people'
              },
              {
                data: 'location'
              },
              {
                data: 'date'
              },
              {
                data: 'created_by'
              },
              {
                data: 'created_at'
              },
              {
                data: 'updated_by'
              },
              {
                data: 'updated_at'
              },
              {
                data: 'remark'
              },
              {
                data: 'id',
                render: function(data) {
                  return `<div class="dropdown no-arrow">
                        <a class="dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown">
                          <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-600"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        
                          <a class="dropdown-item" id="edit" href="edit_special.php?id=${data}">
                            Edit
                          </a>
                          <div class="dropdown-divider"></div>
                          <a data-id="${data}" id="deleteReq" class="dropdown-item text-danger">
                            Delete
                          </a>

                        </div>
                      </div>`
                }
              }
            ],
          });


          let vm = this

          $(document).on('click', '#deleteReq', function() {
            // get room id from the table
            let ids = $(this).data("id")
            let temprow = {}

            // filter alldata which is equal to the room id
            vm.allData.forEach(item => {
              if (item.id == ids) {
                temprow = item
              }
            })

            // assign to temp row
            vm.tempDelete = temprow
            console.log("Delete Special", vm.tempDelete);
            $('#deleteModalSpecial').modal('show')
          })


        },
        async fetchReq() {
          await axios.post('load_modal.php', {
            action: "fetchReqDaily"
          }).then(res => {

            console.log(res.data);
            if (res.data === "empty") {
              this.allData = {}
              this.table({})
            } else {
              this.allData = res.data
              this.table(res.data)
            }

            console.log("all data", this.allData);
            console.log("res data", res.data);
          })
        },
        async deleteReq() {
          console.log("delete Req", this.tempDelete);
          await axios.post('load_modal.php', {
            action: 'deleteReq',
            id: this.tempDelete.id
          }).then(res => {
            console.log(res.data);
            this.fetchReq()
          })
        },
      },
      created() {
        this.fetchReq()
      }
    })

    const reqApp = reqapp.mount('#viewSpecial')

    // End of special request table

    // Group res app 
    const groupResApp = Vue.createApp({
      data() {
        return {
          posts: [''],
          tempRow: {},
          location: '',
          date: '',
          modal: "",
          tempcheckin: '',
          tempcheckout: '',
          formData: {
            firstName: '',
            lastName: '',
            email: '',
            phone: '',
            dob: '',
            remark: '',
          },
          tempDelete: {},
          g_res_id: '',
          group_name: '',
          rooms: {}
        }
      },
      methods: {
        table(row) {
          $('#viewBulkTable').DataTable({
            destroy: true,
            dom: 'lBfrtip',
            buttons: [
              'excel',
              'print',
              'csv'
            ],
            order: [
              [0, 'desc']
            ],
            data: row,
            columns: [{
                data: 'group_id'
              },
              {
                data: 'group_name'
              },
              {
                data: 'group_guest'
              },
              {
                data: 'group_roomQuantity'
              },
              {
                data: 'group_remainingRooms'
              },
              {
                data: 'group_checkin'
              },
              {
                data: 'group_checkout'
              },
              {
                data: 'group_reason',
                render: function(data, display) {
                  if (data == 'con') {
                    return `Conference`
                  } else if (data == 'wed') {
                    return `Wedding`
                  }

                }
              },
              {
                data: 'group_remark'
              },
              {
                data: 'group_location'
              },
              {
                data: 'group_price'
              },
              {
                data: 'group_id',
                render: function(data, row) {
                  return `<div class="dropdown no-arrow">
                        <a class="dropdown-toggle"  role="button" id="dropdownMenuLink" data-toggle="dropdown">
                          <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-600"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                          <a class="dropdown-item" data-id="${data}"  id="add">
                            Add
                          </a>
                          <a class="dropdown-item" data-id="${data}" id="view-group">
                            View
                          </a>
                          <a class="dropdown-item" id="edit" href="edit_bulk_reservation.php?id=${data}">
                            Edit
                          </a>
                          <div class="dropdown-divider"></div>
                          <a data-id="${data}" id="deleteGroup"  class="dropdown-item text-danger">
                            Delete
                          </a>

                        </div>
                      </div>`
                }
              }
            ],
          });


          let vm = this
          $(document).on('click', '#add', function() {
            // get room id from the table
            let ids = $(this).data("id")
            let temprow = {}
            vm.g_res_id = ids
            // filter alldata which is equal to the room id
            vm.posts.forEach(item => {
              if (item.group_id == ids) {
                temprow = item
              }
            })

            vm.tempcheckin = temprow.group_checkin
            vm.tempcheckout = temprow.group_checkout
            vm.group_name = temprow.group_name
            vm.getRooms(ids)
            $('#selectRoom').modal('show')
          })

          $(document).on('click', '#deleteGroup', function() {
            // get room id from the table
            let ids = $(this).data("id")
            let temprow = {}

            // filter alldata which is equal to the room id
            vm.posts.forEach(item => {
              if (item.group_id == ids) {
                temprow = item
              }
            })

            // assign to temp row
            vm.tempDelete = temprow
            console.log("temp row", vm.tempDelete);
            $('#deleteModalGroup').modal('show')
          })
          $(document).on('click', '#view-group', function() {
            // get room id from the table
            let ids = $(this).data("id")
            let temprow = {}

            // filter alldata which is equal to the room id
            vm.posts.forEach(item => {
              if (item.group_id == ids) {
                temprow = item
              }
            })

            // assign to temp row
            vm.tempRow = temprow
            console.log("temp row", vm.tempRow);
            vm.fetchGuestinfo()
            $('#view-group-modal').modal('show')
          })


        },
        async fetchGuestinfo() {
          await axios.post('group_res.php', {
            action: 'guestInfo',
            id: this.tempRow.group_id
          }).then(res => {
            console.log(res.data);

            this.guestInfo = res.data
          })
        },
        async getRooms(id) {
          console.log(id);
          await axios.post('group_res.php', {
            action: 'getRooms',
            id: id
          }).then(res => {
            console.log(res.data);
            this.rooms = res.data
            this.singleTable(res.data)
          })
        },
        singleTable(row) {
          $('#addSingleTable').DataTable({
            destroy: true,
            dom: 'lBfrtip',
            buttons: [
              'colvis',
              'excel',
              'print',
              'csv'
            ],
            data: row,
            columns: [{
                data: 'g_id'
              },
              {
                data: 'g_room_id'
              },
              {
                data: 'g_room_acc'
              },
              {
                data: 'g_room_number'
              },
              {
                data: 'g_room_location'
              },
              {
                data: 'g_id',
                render: function(data) {
                  return `<input type="button" class="btn btn-primary" value="Select" data-row="${data}" id="selectRow">`
                }
              }
            ],
          });
          let vm = this
          $(document).on('click', '#selectRow', function() {
            // get room id from the table
            let ids = $(this).data("row")
            let temprow = {}

            // filter alldata which is equal to the group id
            vm.rooms.forEach(item => {
              if (item.g_id == ids) {
                temprow = item
              }
            })

            // assign to temp row
            vm.tempDelete = temprow
            console.log("temp row", vm.tempDelete);
            $('#addGuest').modal('show')
          })
        },
        async addGuest() {

          console.log("room", this.tempDelete);
          console.log("checkin", this.tempcheckin);
          console.log("checkout", this.tempcheckout);
          console.log("Form data", this.formData);
          console.log("------------------------");
          console.log("group id", this.g_res_id);
          await axios.post('group_res.php', {
            action: 'addSingleRes',
            room: this.tempDelete,
            checkin: this.tempcheckin,
            checkout: this.tempcheckout,
            formData: this.formData,
            group_name: this.group_name,
            group_id: this.g_res_id
          }).then(res => {
            // window.location.href = 'view_bulk_reservations.php'
            console.log(res.data);
          })
        },
        async deleteGroupRes() {
          await axios.post('group_res.php', {
            action: 'delete',
            row: this.tempDelete
          }).then(res => {
            console.log(res.data);
            this.fetchData()
          })
        },
        fetchData() {
          axios.post('group_res.php', {
            action: 'fetchResDaily'
          }).then(res => {
            console.log("comes from api", res.data);
        
            if (res.data === "empty") {
              this.allData = {}
              this.table({})
              this.posts = {}
            } else {
              this.allData = res.data
              this.table(res.data)
              this.posts = res.data
            }
          })
        }
      },
      created() {
        this.fetchData()
      }
    })

    const groupRes = groupResApp.mount("#groupResApp")
  </script>


</body>

</html>
<?php include './includes/admin_header.php'; ?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include './includes/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="resApp" style="width: 100vw;" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include './includes/topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Cancelation Report</h1>

                    </div>
                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Cancelation Report</h6>
                                </div>
                                <div class="card-body">
                                    <!------------------------- t-date picker  --------------------->
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">Pick a Date & Filter </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row py-1">

                                                <div class="form-group mt-2 col-3">
                                                    <input type="text" class="form-control" name="daterange" id="date" value="" readonly />
                                                </div>

                                                <!------------------------- t-date picker end  ------------------>



                                                <div class="table-responsive">
                                                    <table class="table display table-bordered" width="100%" id="viewBulkTable" cellspacing="0">


                                                        <thead>
                                                            <tr>

                                                                <th>Guest First Name</th>
                                                                <th>Guest Last Name</th>
                                                                <th>Room Location</th>
                                                                <th>email</th>
                                                                <th>Phone Number</th>
                                                                <th>Canceling Agent</th>
                                                                <th>Canceling Date</th>
                                                                <th>Cancelation Reason</th>
                                                                <th>Room Numbers</th>
                                                                <th>Total Price</th>

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
                            <!-- /.container-fluid -->

                        </div>
                        <!-- End of Main Content -->



                        <!-- End of View Full Reservation Details -->



                        <!-- End of Delete Modal  -->

                        <!-- Footer -->
                        <footer class="sticky-footer bg-white">
                            <div class="container my-auto">
                                <div class="copyright text-center my-auto">
                                    <span>Copyright &copy; Kuriftu resorts 2022. Powered by <a href="https://versavvymedia.com">Versavvy Media</a> </span>
                                </div>
                            </div>
                        </footer>
                        <!-- End of Footer -->





                        <!-- End of Select Room for Single guest res  -->
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

                <script>
                    // Enable pusher logging - don't include this in production

                    var start, end
                    var today = new Date();
                    const dd = String(today.getDate()).padStart(2, '0');
                    const mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                    const yyyy = today.getFullYear();

                    let tomorrow = new Date(today)
                    tomorrow.setDate(tomorrow.getDate() + 1)

                    tomorrow = new Date(new Date().getTime() + 24 * 60 * 60 * 1000)
                    const td = String(tomorrow.getDate()).padStart(2, '0');
                    const tm = String(tomorrow.getMonth() + 1).padStart(2, '0'); //January is 0!
                    const ty = tomorrow.getFullYear();

                    today = mm + '/' + dd + '/' + yyyy;
                    tomorrow = tm + '/' + td + '/' + ty;

                    start = yyyy + '-' + mm + '-' + dd;
                    end = ty + '-' + tm + '-' + td;

                    console.log("inital start", start);
                    console.log("inital end", end);

                    $(document).ready(function() {

                        console.log("initial start", start);
                        console.log("initial end", end);
                        $('#date').daterangepicker();
                        $('#date').data('daterangepicker').setStartDate(today);
                        $('#date').data('daterangepicker').setEndDate(tomorrow);

                        $('#date').on('apply.daterangepicker', function(ev, picker) {
                            // console.log(picker.startDate.format('YYYY-MM-DD'));
                            // console.log(picker.endDate.format('YYYY-MM-DD'));

                            start = picker.startDate.format('YYYY-MM-DD')
                            end = picker.endDate.format('YYYY-MM-DD')
                            console.log("updated start", start);
                            console.log("updated end", end);
                            app.fetchData(start, end);
                        });
                    })

                    function downloadDocument(row) {
                        // Get the ID or other necessary data from the row
                        console.log(row)
                    }



                    const app = Vue.createApp({
                        data() {
                            return {
                                posts: [''],
                                tempRow: {},
                                location: 'Bishoftu',
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
                                rooms: {},
                                pats: '',
                                payStatus: ''
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
                                            data: 'res_firstname'
                                        },
                                        {
                                            data: 'res_lastname'
                                        },
                                        {
                                            data: 'res_location'
                                        },
                                        {
                                            data: 'res_email'
                                        },
                                        {
                                            data: 'res_phone'
                                        },
                                        {
                                            data: 'cancel_agent'
                                        },
                                        {
                                            data: 'cancel_date'
                                        },
                                        {
                                            data: 'cancel_remark',

                                        },

                                        {
                                            data: 'res_roomNo'
                                        },
                                        {
                                            data: 'res_price'
                                        },
                                        // {
                                        //     data: 'group_price'
                                        // },

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



                            },

                            async fetchData(start, end) {
                                await axios.post('./includes/backEndreservation.php', {
                                    action: 'fetchCancelationReport',
                                    start: start,
                                    end: end,
                                    location: this.location
                                }).then(res => {
                                    console.log(res.data);
                                    this.table(res.data)
                                })

                            },

                            async fetchDataAll() {
                                await axios.post('./includes/backEndreservation.php', {
                                    action: 'fetchAllCancelationReport',
                                    location: this.location
                                }).then(res => {
                                    console.log(res.data);
                                    this.table(res.data)
                                })

                            }

                        },
                        created() {

                            <?php

                            if ($_SESSION['user_role'] == 'SA' || ($_SESSION['user_location'] == 'Boston' && $_SESSION['user_role'] == 'RA')) {
                            ?>
                                this.location = "ALL"

                            <?php } else { ?>

                                this.location = '<?php echo $_SESSION['user_location']; ?>'

                            <?php  } ?>
                            this.fetchDataAll()

                        }
                    }).mount("#resApp")
                </script>

                <!-- Custom scripts for all pages-->
                <script src="./js/sb-admin-2.min.js"></script>


</body>

</html>
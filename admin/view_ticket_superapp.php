<?php $currentPage = "Ticket"; ?>
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
                        <h1 class="h3 mb-0 text-gray-800">
                            Super App Tickets Reservation
                        </h1>

                    </div>
                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-12" id="viewSpecial">
                            <div class="card shadow mb-4">
                                <div class="card-header d-flex py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"> Table</h6>


                                </div>
                                <div class="card-body">

                                    <div class="form-group col-3">
                                        <label for="location">Location</label>

                                        <select v-model="location" @change="fetchLocation" class="custom-select">

                                            <option value="all">All</option>
                                            <option value="boston">Boston</option>
                                            <option value="waterpark">Water Park</option>
                                            <option value="entoto">Entoto</option>
                                            <option value="bishoftu">Bishoftu</option>
                                        </select>
                                    </div>




                                    <div class="table-responsive">
                                        <table class="table display table-bordered" width="100%" id="viewTicketSupperApp" cellspacing="0">


                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Package Type</th>
                                                    <th>Date</th>
                                                    <th>Tickets</th>
                                                    <th>Location</th>
                                                    <th>Price</th>
                                                    <th>Payment status</th>
                                                    <th>Txn Number</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>


                            <!-- View Full Reservation Details Modal -->
                            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div>
                                                <h1 class="my-2">Info</h1>

                                                <div class="card-group">

                                                    <div class="card" style="width: 18rem;">
                                                        <div class="card-body">
                                                            <h5 class="card-title font-weight-bold">
                                                                {{ tempRow.first_name + " " + tempRow.last_name }}
                                                            </h5>

                                                        </div>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <span class="font-weight-bold">Email:</span>
                                                                {{ tempRow.email }}
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="font-weight-bold">Phone:</span>
                                                                {{ tempRow.phone_number }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>

                                            <h1 class="my-2"></h1>

                                            <div class="card-group mt-4">
                                                <div class="card" style="width: 18rem;">
                                                    <div class="card-header">

                                                        <h5 class="card-title font-weight-bold">
                                                            Tickets
                                                        </h5>
                                                    </div>
                                                    <ul class="list-group">
                                                        <div v-if="tempRow.location == 'boston'">
                                                            <li class="list-group-item" v-for="item in tempRow.amt">
                                                                <span class="font-weight-bold">{{ item.name }}:</span>
                                                                {{ item.quantity  }}
                                                            </li>
                                                        </div>

                                                        <div v-else-if="tempRow.location == 'waterpark'">
                                                            <li class="list-group-item">
                                                                <span class="font-weight-bold">Adult:</span>
                                                                {{ tempRow.adult }}
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="font-weight-bold">Kids:</span>
                                                                {{ tempRow.kids }}
                                                            </li>
                                                        </div>

                                                    </ul>
                                                </div>

                                                <div class="card" style="width: 18rem;">
                                                    <div class="card-header">
                                                        <h5 class="card-title font-weight-bold">
                                                            Redeemed Tickets
                                                        </h5>
                                                    </div>

                                                    <ul class="list-group">
                                                        <div v-if="tempRow.location == 'boston'">
                                                            <li class="list-group-item" v-for="item in tempRow.redeemed_amt">
                                                                <span class="font-weight-bold">{{ item.name }}:</span>
                                                                {{ item.quantity  }}
                                                            </li>

                                                        </div>
                                                        <div v-else-if="tempRow.location == 'waterpark'">
                                                            <li class="list-group-item">
                                                                <span class="font-weight-bold">Adult:</span>
                                                                {{ tempRow.redeemed_adult_ticket }}
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="font-weight-bold">Kids:</span>
                                                                {{ tempRow.redeemed_kids_ticket }}
                                                            </li>
                                                        </div>
                                                    </ul>
                                                </div>

                                            </div>

                                            <div class="card-group  mt-4">
                                                <div class="card" style="width: 18rem;">
                                                    <ul class="list-group">

                                                    </ul>
                                                </div>
                                                <div class="card" style="width: 18rem;">
                                                    <ul class="list-group">

                                                    </ul>
                                                </div>



                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- End of View Full Reservation Details -->

                            <!-- Checkout Modal  -->
                            <div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to redeem this ticket?</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <button class="btn btn-primary" @click="redeemTicket" data-dismiss="modal">Yes</button>
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

            <!-- Delete Modal  -->

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


    <script>
        const app = Vue.createApp({
            data() {
                return {
                    allData: [],
                    tempRow: {},
                    location: "all",
                    proUrl: "https://tickets.kuriftucloud.com/",
                    // proUrl: "http://localhost:8000/",
                    ava_amt: [],
                    total_amt: [],
                    paymentStatus: "paid",
                    tempId: ''
                }
            },
            methods: {
                dateFunction(ts) {
                    let date_ob = new Date(ts);
                    let date = date_ob.getDate();
                    let month = date_ob.getMonth() + 1;
                    let year = date_ob.getFullYear();

                    var final = year + "-" + month + "-" + date;
                    return final;
                },
                redeemTicket(id) {
                    console.log("THIS IS THE TICKET ID", this.tempId)

                    axios.post('tickets_function.php', {
                        action: 'redeemTicket',
                        ID: this.tempId
                    }).then(res => {
                        this.fetchReq();

                    })
                },
                table(row) {
                    $('#viewTicketSupperApp').DataTable({
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
                                data: 'first_name',
                                render: function(data, type, row) {
                                    return data + ' ' + row.last_name
                                }
                            },
                            {
                                data: 'phone_number'
                            },
                            {
                                data: 'package'
                            },
                            {
                                data: 'createdAt',
                                render: function(data, type, row) {
                                    return reqApp.dateFunction(data)
                                }
                            },
                            {
                                data: 'quantity',

                            },
                            {
                                data: 'location'
                            },
                            {
                                data: 'price',
                                render: function(data, type, row) {
                                    return data + ' ' + row.currency
                                }
                            },
                            {
                                data: 'payment_status'
                            },
                            {
                                data: 'tx_ref'
                            },
                            {
                                data: 'id',
                                render: function(data) {
                                    let checkoutOption = `<a data-id="${data}" id="redemeTic" class="dropdown-item text-danger">Redeem Ticket</a><div class="dropdown-divider"></div>`;

                                    return `<div class="dropdown no-arrow">
                        <a class="dropdown-toggle"  role="button" id="dropdownMenuLink" data-toggle="dropdown">
                          <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-600"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                          <div class="dropdown-divider"></div>
                          ${checkoutOption}
                          <div class="dropdown-divider"></div>
                        </div>
                      </div>`
                                }
                            }
                        ],
                    });


                    let vm = this

                    $(document).on('click', '#redemeTic', function() {
                        // get room id from the table
                        let ids = $(this).data("id")
                        // assign to temp row
                        vm.tempId = ids

                        $('#ticketModal').modal('show')
                    })




                },
                async fetchReq() {

                    console.log("YE")
                    axios.post('tickets_function.php', {
                        action: 'fetchAllTickets',
                    }).then(res => {
                        console.log("comes from api", res.data);
                        this.posts = res.data
                        this.table(res.data)
                    })
                },
                async fetchLocation() {

                    axios.post('tickets_function.php', {
                        action: 'fetchLocationTickets',
                        location: this.location
                    }).then(res => {
                        console.log("comes from api", res.data);
                        this.posts = res.data
                        this.table(res.data)
                    })

                },

                async fetchUnpaid() {

                    try {
                        const filteredData = this.alldata.filter(item => item.payment_status === this.paymentStatus);
                        this.table(filteredData)
                    } catch (error) {
                        console.log(error);
                    }
                },
                async deleteReq() {
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

        const reqApp = app.mount('#viewSpecial')
    </script>


</body>

</html>
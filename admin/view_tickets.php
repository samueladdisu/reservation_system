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
              Tickets Reservation
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
                    </select>
                  </div>


                  <div class="table-responsive">
                    <table class="table display table-bordered" width="100%" id="viewTicket" cellspacing="0">


                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Name</th>
                          <th>Phone</th>
                          <th>Confirmation code</th>
                          <th>Date</th>
                          <th>Tickets</th>
                          <th>Location</th>
                          <th>Price</th>
                          <th>Payment status</th>
                          <!-- <th>Txn ref</th>
                          <th>Payment method</th>
                          <th>Order status</th>
                          <th> Remarks</th>
                          <th>CreatedAt</th>
                          <th>UpdatedAt</th> -->
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
                              <li class="list-group-item" v-for="item in total_amt">
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
                              <li class="list-group-item" v-for="item in ava_amt">
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
                      <button class="btn btn-primary" @click="deleteReq" data-dismiss="modal">Delete</button>
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
        table(row) {
          $('#viewTicket').DataTable({
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
                data: 'confirmation_code'
              },
              {
                data: 'createdAt',
                render: function(data, type, row) {
                  return reqApp.dateFunction(data)
                }
              },
              {
                data: 'adult',
                render: function(data, type, row) {
                  if (row.location == 'waterpark') {
                    return "Ad: " + data + ' ' + "kids: " + row.kids
                  } else if (row.location == 'boston') {
                    return row.quantity
                  }
                }
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
                data: 'id',
                render: function(data) {
                  return `<div class="dropdown no-arrow">
                        <a class="dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown">
                          <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-600"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                          <a data-toggle="modal" :data-target="modal" class="dropdown-item">
                            Add
                          </a>
                          <a class="dropdown-item" data-id="${data}" id="view">
                            View
                          </a>
                          <a class="dropdown-item" id="edit" href="edit_special.php?id=${data}">
                            Edit
                          </a>
                          <div class="dropdown-divider"></div>
                          <a data-id="${data}" id="delete" class="dropdown-item text-danger">
                            Delete
                          </a>

                        </div>
                      </div>`
                }
              }
            ],
          });


          let vm = this

          $(document).on('click', "#view", function() {
            let ids = $(this).data('id')
            let temprow = {}

            // filter alldata which is equal to the room id
            vm.alldata.forEach(item => {
              if (item.id == ids) {
                temprow = item
              }
            })

            // assign to temp row
            vm.tempRow = temprow
            vm.total_amt = JSON.parse(temprow.amt)
            vm.ava_amt = JSON.parse(temprow.redeemed_amt)
            console.log("temp row", vm.tempRow);
            $('#exampleModalLong').modal('show')
          })


        },
        async fetchReq() {

          const currentUrl = window.location.href;
          const urlParams = new URLSearchParams(currentUrl.split('?')[1])

          const location = urlParams.get('location') || this.location


          console.log(location);
          try {
            const res = await axios.post(this.proUrl + 'view_activity_reservation', {
              location
            })
            console.log(res.data);

            this.alldata = res.data
            this.table(this.alldata)
          } catch (error) {
            console.log(error);
          }
        },
        async fetchLocation() {
          try {
            const res = await axios.post(this.proUrl + 'view_activity_reservation', {
              location: this.location
            })
            console.log(res.data);

            this.alldata = res.data
            this.table(this.alldata)
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
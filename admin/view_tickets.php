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
            <h1 class="h3 mb-0 text-gray-800">Water park ticket

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
                  <div class="table-responsive">
                    <table class="table display table-bordered" width="100%" id="viewTicket" cellspacing="0">


                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Name</th>
                          <th>Phone</th>
                          <th>Confirmation code</th>
                          <th>Date</th>
                          <th>Guests</th>
                          <th>Location</th>
                          <th>Price</th>
                          <!-- <th>Txn ref</th>
                          <th>Payment status</th>
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

      <!-- View Full Reservation Details Modal -->
      <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
          tempDelete: {}
        }
      },
      methods: {
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
                data: 'reservation_date'
              }, 
              {
                data: 'adult',
                render: function(data, type, row) {
                  return "Ad: " + data + ' ' + "kids: " + row.kids
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
              // {
              //   data: 'tx_ref'
              // },
              // {
              //   data: 'payment_status'
              // },
              // {
              //   data: 'payment_method'
              // },
              // {
              //   data: 'order_status'
              // },
              // {
              //   data: 'addons'
              // },
              // {
              //   data: 'createdAt'
              // },
              // {
              //   data: 'updatedAt'
              // },
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

          $(document).on('click', '#delete', function() {
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
            console.log("temp row", vm.tempDelete);
            $('#deleteModal').modal('show')
          })


        },
        async fetchReq() {

          try {
            const res = await axios.get('https://tickets.kuriftucloud.com/view_activity_reservation')
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
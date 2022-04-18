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
            <h1 class="h3 mb-0 text-gray-800">Reservations</h1>

          </div>
          <!-- Content Row -->
          <div class="row">
            <div class="col-12 mb-2">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Reservations</h6>
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
                {{ tempRow.res_firstname }}
              </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead>
                  <th>
                    Room Number
                  </th>
                  <th>
                    Room Type
                  </th>
                  <th>
                    Guests
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

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Kuriftu resorts 2022. Powered by <a href="https://versavvymedia.com">Versavvy Media</a> </span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

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


  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <!-- Core plugin JavaScript-->


  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.6.0/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/datatables.min.js"></script>
  <script src="./vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <script>
    // Enable pusher logging - don't include this in production




    const app = Vue.createApp({
      data() {
        return {
          posts: [''],
          tempRow: {},
          location: '',
          date: '',
          modal: "",
          tempcheckin: '',
          tempcheckout: '',
          firstName: '',
          lastName: '',
          email: '',
          phone: '',
          dob: '',
          remark: '',
          tempDelete: {}
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
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown">
                          <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-600"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                          <a data-toggle="modal" :data-target="modal" class="dropdown-item" href="#">
                            Add
                          </a>
                          <a class="dropdown-item" data-id="${data}" id="view" href="#">
                            View
                          </a>
                          <div class="dropdown-divider"></div>
                          <a data-id="${data}" id="delete" href="#" class="dropdown-item text-danger">
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
            console.log("temp row", typeof(vm.tempRow));
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
            action: 'fetchRes'
          }).then(res => {
            console.log("comes from api", res.data);
            // let guest, room, type;
            //  res.data.forEach(data => {
            //   if(data.res_guestNo){
            //     let guest = JSON.parse(data.res_guestNo)
            //     console.log(guest[1]);
            //   }else if (data.res_roomNo){
            //     let room = JSON.parse(data.res_roomNo)
            //   }else if (data.res_roomType){
            //     let type = JSON.parse(data.res_roomType)
            //   }
            // })

            // console.log("guests",guest);
            // console.log("room number",room);
            // console.log("room type",type);
            this.posts = res.data
            this.table(res.data)
          })
        }
      },
      created() {
        this.fetchData()
        Pusher.logToConsole = true;

        const pusher = new Pusher('341b77d990ca9f10d6d9', {
          cluster: 'mt1',
          encrypted: true
        });

        const channel = pusher.subscribe('notifications');
        channel.bind('new_reservation', (data) => {
          if (data) {
            this.fetchData()
          }
        })
      }
    }).mount("#resApp")
  </script>

  <!-- Custom scripts for all pages-->
  <script src="./js/sb-admin-2.min.js"></script>


</body>

</html>
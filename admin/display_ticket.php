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
            <h1 class="h3 mb-0 text-gray-800">Guest Information

            </h1>

          </div>
          <!-- Content Row -->
          <div class="row">

            <div class="col-12" id="viewSpecial">

              <div class="card">

                <div class="card-header">
                  <h5 class="text-success" v-if="eligible">Guest is eligible</h5>
                  <h5 class="text-danger" v-else>Ticket is already redeemed</h5>

                </div>

                <ul class="list-group list-group-flush">
                  <li class="list-group-item">Name: {{ allData.first_name }} - {{ allData.last_name }}</li>
                  <li class="list-group-item">Email: {{ allData.email }} </li>
                  <li class="list-group-item">Phone: {{ allData.phone_number }} </li>
                  <li class="list-group-item">Location: {{ allData.location }} </li>
                  <li class="list-group-item">Confirmation Code: {{ allData.confirmation_code }} </li>
                  <li class="list-group-item">Date: 11-1-2023</li>
                  <li class="list-group-item">Guest: {{ allData.adult }} Ad, {{ allData.kids }} kids</li>
                  <li class="list-group-item">Price: {{ allData.price }} {{ allData.currency }} </li>
                  <li class="list-group-item">Payment method: {{ allData.payment_method }}</li>
                  <li class="list-group-item">Payment Status: {{ allData.payment_status }}</li>
                  <li class="list-group-item">Order Status: {{ allData.order_status }}</li>
                </ul>
                <div class="card-footer">
                  <a href="#" class="btn btn-secondary mr-2 mb-2">Go Back</a>
                  <a href="#" class="btn btn-primary mb-2">View ticket Reservation</a>
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
            <span>Copyright &copy; Kuriftu resorts 2023. Powered by <a href="https://versavvymedia.com">Versavvy Media</a> </span>
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
    

    let currentUrl = window.location.href;
    let urlParams = new URLSearchParams(currentUrl.split("?")[1]);
   
    let g_token = urlParams.get("guest_token");
    let u_token = urlParams.get("user_token");
    console.log(g_token)
    console.log(u_token)



    const app = Vue.createApp({
      data() {
        return {
          allData: {},
          eligible: false
        }
      },
      methods: {
        async send() {
          try {
            await axios.post('https://tickets.kuriftucloud.com/verify', {
              guest_token: g_token,
              user_token: u_token
            }).then((response) => {
              console.log(response.data)
              this.allData = response.data.data[0]
              if(response.data.msg == "reserved") {
                this.eligible = true
              }else if(response.data.msg == "checked_in") {
                this.eligible = false

              }
            })

          } catch (e) {
            console.log(e)
          }

        }
      },
      mounted() {
        this.send()
      }
    })

    const reqApp = app.mount('#viewSpecial')
  </script>


</body>

</html>
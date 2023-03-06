<?php $currentPage = "Ticket"; ?>


<?php include './includes/admin_header.php'; ?>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->

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
          <div class="d-sm-flex d-flex justify-content-center align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Guest Information</h1>
            <a href="./dashboard.php">
              <span>Back Dashboard</span>
            </a>
          </div>
          <!-- Content Row -->
          <div>

            <div id="viewSpecial">
              <button class="btn btn-primary mb-2" @click="downloadPdf" id="download-pdf">Download Receipt</button>
              <!-- <div class="card border-success" v-if="eligible">
                <div class="card-header">
                  <h5 class="text-success">{{ allData.first_name }} {{ allData.last_name }} is eligible</h5>
                </div>
                <div class="card-body">
                  Purchased Tickets: <br>
                  {{ allData.adult }} Ad - {{ allData.kids }} Kids <br> <br>
                  Redeemed Tickes: <br>
                  {{ allData.redeemed_adult_ticket
                  }} Ad - {{ allData.redeemed_kids_ticket }} kids <br> <br>
                  Available Ticket: <br>
                  {{ ava_ad }} Ad - {{ ava_kid }} Kids <br> <br>


                  <form class="mt-3">
                    <div class="form-group d-md-flex">

                      <select class="form-control mr-2 mb-2" v-model="adult">
                        <option disabled value="">--select--</option>
                        <option v-for="amt in ava_ad" :value="amt">
                          {{ amt }} Adult
                        </option>
                      </select>

                      <select class="form-control" v-model="kid">
                        <option disabled value="">--select--</option>
                        <option v-for="amt in ava_kid" :value="amt">
                          {{ amt }} Kid
                        </option>
                      </select>

                    </div>
                  </form>


                </div>
                <div class="card-footer">
                  <button class="btn btn-primary mr-2 mb-2" @click="redeemTicket">Redeem Ticket</button>
                  <a href="./qrcode/" class="btn btn-secondary">
                    cancel
                  </a>
                </div>
              </div> -->

              <div id="lastReadem">
                <div class="card border-success" v-if="eligible">

                  <div class="card-header">

                    <h5 class="text-success">{{ allData.first_name }} {{ allData.last_name }} is eligible</h5>

                  </div>

                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">Name: {{ allData.first_name }} - {{ allData.last_name }}</li>
                    <li class="list-group-item">Email: {{ allData.email }} </li>
                    <li class="list-group-item">Phone: {{ allData.phone_number }} </li>
                    <li class="list-group-item">Location: {{ allData.location }} </li>
                    <li class="list-group-item">Price: {{ allData.price }} {{ allData.currency }} </li>
                    <li class="list-group-item">Payment method: {{ allData.payment_method }}</li>
                    <li class="list-group-item">Transaction Number: {{ allData.tx_ref }}</li>
                    <li class="list-group-item">Payment Status: {{ allData.payment_status }}</li>
                    <li class="list-group-item">Order Status: {{ allData.order_status }}</li>

                    <li class="list-group-item">Confirmation Code: {{ allData.confirmation_code }} </li>
                    <li class="list-group-item">Date: {{ allData.updatedAt }}</li>
                    <li class="list-group-item">Tickets: {{ allData.adult }} Ad, {{ allData.kids }} kids</li>
                    <li class="list-group-item">Redeemed Tickets: {{ allData.redeemed_adult_ticket
                    }} Ad, {{ allData.redeemed_kids_ticket }} kids</li>

                  </ul>
                  <div class="card-footer">
                    <a href="./qrcode/" class="btn btn-secondary mr-2 mb-2">Go Back</a>
                    <a href="view_tickets.php" class="btn btn-primary mb-2">View Ticket Reservation</a>
                  </div>
                </div>
                <div class="card border-success" v-else-if="entoto_eligible">
                  <div class="card-header">
                    <h5 class="text-success">{{ allData.first_name }} {{ allData.last_name }} is eligible</h5>
                  </div>
                  <div class="card-body">
                    Purchased Tickets: <br>
                    {{ amt[0].quantity }} {{ amt[0].package_type }} - {{ amt[1].quantity }} {{ amt[1].package_type }} - {{
                  amt[2].quantity }} {{ amt[2].package_type }} <br> <br>
                    Available Ticket: <br>
                    <form class="mt-3 d-md-flex">
                      <div class="form-group mr-2 mb-2">
                        <label class="font-weight-bold my-4">For Kids</label>
                        <select class="form-control mb-2" v-model="pedalKart">
                          <option disabled value="">Pedal Kart</option>
                          <option value="0">0</option>
                          <option v-for="amt in avaAmt[0].packages[0].quantity" :value="amt">
                            {{ amt }}
                          </option>
                        </select>
                        <select class="form-control mb-2" v-model="trampoline">
                          <option disabled value="">Trampoline</option>
                          <option value="0">0</option>
                          <option v-for="amt in avaAmt[0].packages[1].quantity" :value="amt">
                            {{ amt }}
                          </option>
                        </select>
                        <select class="form-control mb-2" v-model="childrenPlayground">
                          <option disabled value="">Children Playground</option>
                          <option value="0">0</option>
                          <option v-for="amt in avaAmt[0].packages[2].quantity" :value="amt">
                            {{ amt }}
                          </option>
                        </select>

                        <select class="form-control mb-2" v-model="wallClimbing">
                          <option disabled value="">wall climbing</option>
                          <option value="0">0</option>
                          <option v-for="amt in avaAmt[0].packages[3].quantity" :value="amt">
                            {{ amt }}
                          </option>
                        </select>
                      </div>
                      <div class="form-group mr-2 mb-2">
                        <label class="font-weight-bold my-4">Adrenaline</label>
                        <select class="form-control mb-2" v-model="zipAdre">
                          <option disabled value="">Zip Line</option>
                          <option value="0">0</option>
                          <option v-for="amt in avaAmt[1].packages[0].quantity" :value="amt">
                            {{ amt }}
                          </option>
                        </select>

                        <select class="form-control mb-2" v-model="ropeCourse">
                          <option disabled value="">Rope Course</option>
                          <option value="0">0</option>
                          <option v-for="amt in avaAmt[1].packages[1].quantity" :value="amt">
                            {{ amt }}
                          </option>
                        </select>

                        <select class="form-control mb-2" v-model="goKart">
                          <option disabled value="">Go Kart</option>
                          <option value="0">0</option>
                          <option v-for="amt in avaAmt[1].packages[2].quantity" :value="amt">
                            {{ amt }}
                          </option>
                        </select>
                      </div>
                      <div class="form-group mr-2 mb-2">
                        <label class="font-weight-bold my-4">Entoto Adventure</label>
                        <select class="form-control mb-2" v-model="horseRiding">
                          <option disabled value="">Horse Riding</option>
                          <option value="0">0</option>
                          <option v-for="amt in avaAmt[2].packages[0].quantity" :value="amt">
                            {{ amt }}
                          </option>
                        </select>

                        <select class="form-control mb-2" v-model="paintBall">
                          <option disabled value="">Paintball</option>
                          <option value="0">0</option>
                          <option v-for="amt in avaAmt[2].packages[1].quantity" :value="amt">
                            {{ amt }}
                          </option>
                        </select>

                        <select class="form-control mb-2" v-model="archery">
                          <option disabled value="">Archery</option>
                          <option value="0">0</option>
                          <option v-for="amt in avaAmt[2].packages[2].quantity" :value="amt">
                            {{ amt }}
                          </option>
                        </select>
                        <select class="form-control mb-2" v-model="zipAdv">
                          <option disabled value="">Zip Line</option>
                          <option value="0">0</option>
                          <option v-for="amt in avaAmt[2].packages[3].quantity" :value="amt">
                            {{ amt }}
                          </option>
                        </select>
                      </div>
                    </form>


                  </div>
                  <div class="card-footer">
                    <button class="btn btn-primary mr-2 mb-2" @click="redeemEntotoTicket">Redeem Ticket</button>
                    <a href="./qrcode/" class="btn btn-secondary">
                      cancel
                    </a>
                  </div>
                </div>

                <div class="card border-success" v-else-if="boston_eligible">
                  <div class="card-header">
                    <h5 class="text-success">{{ allData.first_name }} {{ allData.last_name }} is eligible</h5>
                  </div>
                  <div class="card-body">
                    Purchased Tickets: <br>
                    {{ amt[0].quantity }} {{ amt[0].name }}<br>
                    {{ amt[1].quantity }} {{ amt[1].name }} <br>
                    {{ amt[2].quantity }} {{ amt[2].name }}<br>
                    {{ amt[3].quantity }} {{ amt[3].name }}
                    <br> <br>
                    Available Ticket: <br>
                    {{ avaAmt[0].quantity }} {{ avaAmt[0].name }} <br>
                    {{ avaAmt[1].quantity }} {{ avaAmt[1].name }} <br>
                    {{ avaAmt[2].quantity }} {{ avaAmt[2].name }} <br>
                    {{ avaAmt[3].quantity }} {{ avaAmt[3].name }}

                    <br> <br>

                    <form class="mt-3 d-md-flex">
                      <div class="form-group mr-2 mb-2">
                        <label class="font-weight-bold my-4">Packages</label>
                        <select class="form-control mb-2" v-model="pediMani">
                          <option disabled value="">Peedcure & deep manicure</option>
                          <option value="0">0</option>
                          <option v-for="amt in avaAmt[0].quantity" :value="amt">
                            {{ amt }}
                          </option>
                        </select>

                        <select class="form-control mb-2" v-model="aroma">
                          <option disabled value="">Aroma massage</option>
                          <option value="0">0</option>
                          <option v-for="amt in avaAmt[1].quantity" :value="amt">
                            {{ amt }}
                          </option>
                        </select>

                        <select class="form-control mb-2" v-model="spa">
                          <option disabled value="">Spa</option>
                          <option value="0">0</option>
                          <option v-for="amt in avaAmt[2].quantity" :value="amt">
                            {{ amt }}
                          </option>
                        </select>

                        <select class="form-control mb-2" v-model="hair">
                          <option disabled value="">Hair</option>
                          <option value="0">0</option>
                          <option v-for="amt in avaAmt[3].quantity" :value="amt">
                            {{ amt }}
                          </option>
                        </select>
                      </div>
                    </form>


                  </div>
                  <div class="card-footer">
                    <button class="btn btn-primary mr-2 mb-2" @click="redeemBoston">Redeem Ticket</button>
                    <a href="./qrcode/" class="btn btn-secondary">
                      cancel
                    </a>
                  </div>
                </div>


                <div class="card" v-else>

                  <div class=" card-header">

                    <h5 class=" text-danger">Ticket is already redeemed</h5>

                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">Name: {{ allData.first_name }} - {{ allData.last_name }}</li>
                    <li class="list-group-item">Email: {{ allData.email }} </li>
                    <li class="list-group-item">Phone: {{ allData.phone_number }} </li>
                    <li class="list-group-item">Location: {{ allData.location }} </li>
                    <li class="list-group-item">Confirmation Code: {{ allData.confirmation_code }} </li>
                    <li class="list-group-item">Date: 11-1-2023</li>
                    <li class="list-group-item">Tickets: {{ allData.adult }} Ad, {{ allData.kids }} kids</li>
                    <li class="list-group-item">Redeemed Tickets: {{ allData.redeemed_adult_ticket
                    }} Ad, {{ allData.redeemed_kids_ticket }} kids</li>
                    <li class="list-group-item">Price: {{ allData.price }} {{ allData.currency }} </li>
                    <li class="list-group-item">Payment method: {{ allData.payment_method }}</li>
                    <li class="list-group-item">Payment Status: {{ allData.payment_status }}</li>
                    <li class="list-group-item">Order Status: {{ allData.order_status }}</li>
                  </ul>
                  <div class="card-footer">
                    <a href="./qrcode/" class="btn btn-secondary mr-2 mb-2">Go Back</a>
                    <a href="view_tickets.php" class="btn btn-primary mb-2">View ticket Reservation</a>
                  </div>
                </div>



              </div>
              <!-- Scan Button -->
              <div class="scan-button" style="border-radius:5rem; position: fixed; bottom: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; align-items: center;">
                <a href="./qrcode"><button class="btn btn-circle" style="width:70px; height:70px; background-color: #c2874a;"><i class="bi bi-camera" style="font-size: 2rem; color: #fff;"></i></button></a>
                <div class="qr-code" style="width: 50px; height: 50px; margin-top: 10px; border-radius: 50%;"></div>
              </div>

              <!-- Success Modal -->
              <div id="ticket_success_tic" class="success_tic modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <a class="close" href="#" data-dismiss="modal">&times;</a>
                    <div class="page-body">
                      <div class="text-center" v-if="spinner">
                        <div class="spinner-border" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                      </div>
                      <div v-if="success">
                        <div class="head">
                          <h3 style="margin-top:5px;">Operation Successful!</h3>
                          <!-- <h4>Lorem ipsum dolor sit amet</h4> -->
                        </div>

                        <h1 style="text-align:center;">
                          <div class="checkmark-circle">
                            <div class="background"></div>
                            <div class="checkmark draw"></div>
                          </div>
                        </h1>
                        <div style="text-align:center; margin-top: 2rem;">
                          <a href="display_ticket.php">
                            View reservation
                          </a>
                        </div>
                      </div>

                    </div>

                  </div>



                </div>

              </div>
              <!-- End of Success Modal -->
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
            <span>Copyright &copy; Kuriftu resorts 2023. Powered by <a href="https://versavvymedia.com">Versavvy
                Media</a> </span>
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
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
          eligible: false,
          entoto_eligible: false,
          boston_eligible: false,
          url: 'https://tickets.kuriftucloud.com/verify',
          // url: 'http://localhost:8000/verify',
          ava_ad: 0,
          ava_kid: 0,
          adult: "",
          kid: "",
          spinner: false,
          success: false,
          amt: [],
          redeemAmt: [],
          avaAmt: [],
          // entoto package values
          // For kids
          pedalKart: "",
          trampoline: "",
          childrenPlayground: "",
          wallClimbing: "",

          // Adrenaline
          zipAdre: "",
          ropeCourse: "",
          goKart: "",

          // Entoto Adventure
          horseRiding: "",
          paintBall: "",
          archery: "",
          zipAdv: "",

          //boston package values
          pediMani: "",
          aroma: "",
          spa: "",
          hair: ""
        }
      },
      // computed: {
      //   formatedate() {
      //     let date_ob = new Date(this.allData.updatedAt);
      //     let date = date_ob.getDate();
      //     let month = date_ob.getMonth() + 1;
      //     let year = date_ob.getFullYear();

      //     var final = year + "-" + month + "-" + date;
      //     return final;
      //   }
      // },
      methods: {
        dateFunction(ts) {
          let date_ob = new Date(ts);
          let date = date_ob.getDate();
          let month = date_ob.getMonth() + 1;
          let year = date_ob.getFullYear();

          var final = year + "-" + month + "-" + date;
          return final;
        },
        downloadPdf() {
          const today = new Date();
          var todayString = today.toLocaleDateString("en-GB").toString();
          var pdf = new jsPDF();
          var pdfContent = document.getElementById("lastReadem");
          pdf.fromHTML(pdfContent, 15, 15);
          pdf.save(todayString + "ticket-pdf.pdf");

        },
        async send() {
          try {
            await axios.post(this.url, {
              guest_token: g_token,
              user_token: u_token
            }).then((res) => {
              console.log(res.data)

              if (res.data.msg == "already_checked_in") {
                this.eligible = false
                this.allData = res.data.data[0]
              } else if (res.data.msg == "waterpark_checked_in") {
                this.eligible = true
                this.allData = res.data.data[0]
              }
              // else if (res.data.msg == "waterpark tickets") {
              //   this.eligible = true
              //   this.allData = res.data.data.result[0]
              //   this.ava_ad = res.data.data.ava_ad
              //   this.ava_kid = res.data.data.ava_kid
              // }  
              else if (res.data.msg == "entoto tickets") {

                this.entoto_eligible = true
                this.allData = res.data.data.result[0]
                this.amt = res.data.data.amt
                this.redeemAmt = res.data.data.redeemed_amt
                this.avaAmt = res.data.data.ava_amt
              } else if (res.data.msg == "boston tickets") {
                this.boston_eligible = true
                this.allData = res.data.result[0]
                this.amt = res.data.amt
                this.redeemAmt = res.data.redeemed_amt
                this.avaAmt = res.data.ava_amt
              } else {
                this.eligible = false
              }

              console.log(this.allData);
            })

          } catch (e) {
            console.log(e)
          }

        },
        async redeemTicket() {

          if (this.adult == "" && this.kid == "") {
            alert("Please select a ticket")
            return
          }
          try {


            $('#ticket_success_tic').modal('show')
            this.spinner = true

            await axios.post('https://tickets.kuriftucloud.com/checkGuest', {
              guest_token: g_token,
              redeemed_ad: this.adult,
              redeemed_kid: this.kid,

            }).then(res => {
              console.log(res.data);

              if (res.data.msg == "checked_in") {
                this.spinner = false
                this.success = true

                setTimeout(() => {
                  window.location.href = "view_tickets.php?location=waterpark"
                }, 2000);
              }
            })
          } catch (error) {

          }
        },
        async redeemEntotoTicket() {

          if (this.pedalKart == "" && this.trampoline == "" && this.childrenPlayground == "" && this.walClimbing == "" && this.zipAdre == "" && this.ropeCourse == "" && this.goKart == "" && this.horseRiding == "" && this.paintBall == "" && this.archery == "" && this.zipAdv == "") {
            alert("Please select a ticket")
            return
          }
          try {
            $('#ticket_success_tic').modal('show')
            this.spinner = true

            await axios.post('https://tickets.kuriftucloud.com/checkEntotoGuest', {
              guest_token: g_token,
              data: {
                pedalKart: this.pedalKart,
                trampoline: this.trampoline,
                childrenPlayground: this.childrenPlayground,
                wallClimbing: this.wallClimbing,
                zipAdre: this.zipAdre,
                ropeCourse: this.ropeCourse,
                goKart: this.goKart,
                horseRiding: this.horseRiding,
                paintBall: this.paintBall,
                archery: this.archery,
                zipAdv: this.zipAdv
              }
            }).then(res => {
              console.log(res.data);

              if (res.data.msg == "checked_in") {
                this.spinner = false
                this.success = true

                setTimeout(() => {
                  window.location.href = "view_tickets.php?location=entoto"
                }, 2000);
              }
            })
          } catch (error) {

          }
        },
        async redeemBoston() {
          if (this.pediMani == "" && this.aroma == "" && this.spa == "" && this.hair == "") {
            alert("Please select a ticket")
            return
          }

          try {
            $('#ticket_success_tic').modal('show')
            this.spinner = true

            await axios.post('https://tickets.kuriftucloud.com/checkBostonGuest', {
              guest_token: g_token,
              data: {
                pediMani: this.pediMani,
                aroma: this.aroma,
                spa: this.spa,
                hair: this.hair
              }
            }).then(res => {
              console.log(res.data);

              if (res.data.msg == "checked_in") {
                this.spinner = false
                this.success = true

                setTimeout(() => {
                  window.location.href = "view_tickets.php?location=boston"
                }, 2000);
              }
            })
          } catch (error) {
            console.log(error);
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
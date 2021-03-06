<?php $currentPage = "Add Reservation"; ?>
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
            <!-- <h1 class="h3 mb-0 text-gray-800">Reservations</h1> -->

          </div>
          <!-- Content Row -->
          <div class="row">



            <div id="app">


              <form action="" @submit.prevent="addReservation" method="POST" id="reservation" class="col-12 row" enctype="multipart/form-data">

                <h1 class="mb-4">Make Reservation</h1>




                <div class="col-12">
                  <!------------------------- t-date picker  --------------------->
                  <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Pick a Date & Filter </h6>
                    </div>
                    <div class="card-body">
                      <div class="row py-1">
                        <div class="t-datepicker mt-2 col-3">
                          <div class="t-check-in">
                            <div class="t-dates t-date-check-in">
                              <label class="t-date-info-title">Check In</label>
                            </div>
                            <input type="hidden" class="t-input-check-in" name="start">
                            <div class="t-datepicker-day">
                              <table class="t-table-condensed">
                                <!-- Date theme calendar -->
                              </table>
                            </div>
                          </div>
                          <div class="t-check-out">
                            <div class="t-dates t-date-check-out">
                              <label class="t-date-info-title">Check Out</label>
                            </div>
                            <input type="hidden" class="t-input-check-out" name="end">
                          </div>
                        </div>

                        <!------------------------- t-date picker end  ------------------>

                        <?php

                        if ($_SESSION['user_role'] == 'SA' || ($_SESSION['user_location'] == 'Boston' && $_SESSION['user_role'] == 'RA')) {

                        ?>
                          <div class="form-group mt-2 col-2">
                            <select name="room_location" class="custom-select" v-model="location" @change="checkLocation" id="">
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

                        <div class="form-group mt-2 col-2">

                          <select class="custom-select" v-model="roomType" id="">
                            <option disabled value="">Room Type</option>
                            
                              <option value="type.name" v-if="location !== 'Bishoftu'" v-for="type in types">
                                {{ type.name }}
                              </option>

                              <option value="type.type_name" v-if="location === 'Bishoftu'" v-for="type in types">
                                {{ type.type_name }}
                              </option>
                         
                            
                          </select>
                        </div>



                        <div id="bulkContainer" class="col-3 mt-2">
                          <button name="booked" @click.prevent="filterRooms" class="btn btn-success">Filter</button>

                          <button name="booked" value="location" id="location" @click.prevent="clearFilter" class="btn btn-danger mx-2">Clear Filters</button>

                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cart">
                            Cart
                          </button>

                        </div>

                        <!-- Button trigger modal -->



                      </div>
                    </div>
                  </div>

                  <!-- Modal -->
                  <div class="modal fade" id="guest">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Add Guests</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                            <label for="" class="text-dark">Room 1:</label>
                            <div class="row">
                              <select v-model="res_adults" @change="CheckGuest" class="custom-select col-3">
                                <option value="" disabled>Adults*</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                              </select>

                              <select @change="CheckGuest" v-model="res_teen" class="custom-select col-3 offset-1" :disabled="teen">
                                <option value="" disabled>Teens(12-17)</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                              </select>

                              <select @change="CheckGuest" v-model="res_kid" class="custom-select col-3 offset-1" :disabled="kid">
                                <option value="" disabled>kid(6-11)</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                              </select>


                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" @click="booked" data-dismiss="modal" class="btn btn-primary">Save changes</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Loft Modal  -->
                  <!-- Modal -->
                  <div class="modal fade" id="loftModal">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Add Guests</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                            <label for="" class="text-dark">Room 1:</label>
                            <div class="row">
                              <select name="adults" v-model="res_adults" class="custom-select col-3">
                                <option value="" disabled>Guests</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                              </select>

                              <select name="adults" @change="checkLoftTeen" v-model="res_teen" class="custom-select col-3 offset-1" :disabled="loftTeen">
                                <option value="" disabled>Teens(12-17)</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                              </select>

                              <select name="adults" @change="checkLoftKid" v-model="res_kid" class="custom-select col-3 offset-1" :disabled="loftKid">
                                <option value="" disabled>kid(6-11)</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                              </select>


                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" @click="booked" data-dismiss="modal" class="btn btn-primary">Save changes</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="modal fade" id="cart">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Selected Rooms</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">

                          <!-- cart items  -->
                          <div class="list-group">

                            <div v-if="cart.length">
                              <a href="#" v-for="item in cart" :key="item.room_id" class="list-group-item list-group-item-action flex-column align-items-start ">
                                <div class="d-flex w-100 justify-content-between">
                                  <h5 class="mb-1">{{ item.room_acc }} - {{ item.room_number }}</h5>
                                  <small> ${{ item.room_price }} / night</small>
                                </div>
                                <p class="mb-1"> Adults: {{ item.adults }} </p>
                                <p class="mb-1"> Teens: {{ item.teens }} </p>
                                <p class="mb-1"> Kids: {{ item.kids }} </p>

                                <div class="d-flex w-100 justify-content-between">
                                  <small>{{ item.room_location }} </small>

                                  <div class="d-flex">

                                    <p class="ml-2">
                                      <i style='color: red;' @click="deleteCart(item)" class='far fa-trash-alt'></i>
                                    </p>
                                  </div>
                                </div>
                              </a>
                            </div>

                            <div v-else>
                              <h2> No Room Selected </h2>
                            </div>


                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Available Rooms </h6>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">

                        <table class="table display table-bordered table-hover" id="addReserveTable" width="100%" cellspacing="0">

                          <thead>
                            <tr>
                              <th>Id</th>
                              <th>Occupancy</th>
                              <th>Accomodation</th>
                              <th>Price</th>
                              <th>Room Number</th>
                              <th>Room Status</th>
                              <th>Hotel Location</th>
                              <th>Select Room</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                </div>

                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Fill in Guest Information</h6>
                  </div>
                  <div class="card-body d-flex justify-content-center">
                    <div class="col-6 row">
                      <div class="form-group col-6">
                        <input type="text" placeholder="First Name*" class="form-control" v-model="formData.res_firstname" name="res_firstname" required>
                      </div>
                      <div class="form-group col-6">
                        <input type="text" placeholder="Last Name*" class="form-control" v-model="formData.res_lastname" name="res_lastname" required>
                      </div>

                      <div class="form-group col-6">
                        <input type="text" placeholder="Phone No.*" class="form-control" v-model="formData.res_phone" name="res_phone" required>
                      </div>

                      <div class="form-group col-6">
                        <input type="text" placeholder="Email*" class="form-control" v-model="formData.res_email" name="res_email" required>
                      </div>





                      <div class="form-group col-6">
                        <select name="res_paymentMethod" v-model="formData.res_paymentMethod" class="custom-select" required>
                          <option value="">Payment Method*</option>
                          <option value="bank_transfer">Bank Transfer</option>
                          <option value="cash">Cash</option>
                          <option value="GC1">Gift Card 1</option>
                          <option value="GC2">Gift Card 2</option>
                          <option value="GC3">Gift Card 3</option>
                        </select>

                      </div>


                      <div class="form-group col-6">
                        <select name="res_paymentStatus" v-model="formData.res_paymentStatus" class="custom-select" required>
                          <option value="">Payment Status*</option>
                          <option value="paid">Paid</option>
                          <option value="pending_payment">pending payment</option>
                        </select>
                      </div>



                      <div class="form-group col-6">
                        <input type="text" placeholder="Special Request" class="form-control" v-model="formData.res_specialRequest" name="res_specialRequest" id="">
                        <!-- <textarea name="res_specialRequest" id="" cols="30" rows="10" placeholder="Special Request" class="form-control"></textarea> -->
                      </div>

                      <div class="form-group col-6">
                        <input type="text" placeholder="Promo Code" v-model="formData.res_promo" @keyup="getData()" class="form-control">

                        <div class="panel-footer" v-if="search_data.length">
                          <ul class="list-group">
                            <p class="list-group-item" @click="getName(data1.promo_code)" v-for="data1 in search_data">
                              {{ data1.promo_code }} {{ data1.promo_active }}
                            </p>
                          </ul>
                        </div>


                      </div>

                      <div class="form-group col-12">
                        <textarea name="res_remark" v-model="formData.res_remark" placeholder="Remark" id="" cols="30" rows="10" class="form-control"></textarea>
                      </div>


                      <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="add_res" value="Add Reservation">
                      </div>
                    </div>
                  </div>
                </div>




              </form>



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
            <span aria-hidden="true">??</span>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="./js/t-datepicker.min.js"></script>
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

  <!-- data table plugin  -->



  <script>
    let start, end;

    $(document).ready(function() {
      const tdate = $('.t-datepicker')
      tdate.tDatePicker({
        show: true,
        iconDate: '<i class="fa fa-calendar"></i>'
      });
      tdate.tDatePicker('show')


      tdate.on('eventClickDay', function(e, dataDate) {

        var getDateInput = tdate.tDatePicker('getDateInputs')

        start = getDateInput[0];
        end = getDateInput[1];

        console.log("start", start);
        console.log("end", end);
      })
    });



    const app = Vue.createApp({
      data() {
        return {
          search_data: [],
          location: '',
          types: [],
          roomType: '',
          allData: '',
          bookedRooms: [],
          totalPrice: 0,
          cart: [],
          selectAllRoom: false,
          selectBtn: false,
          stayedNights: 0,
          isPromoApplied: '',
          promoCode: '',
          oneClick: false,
          kid: false,
          teen: false,
          loftKid: false,
          loftTeen: false,
          formData: {
            res_firstname: '',
            res_lastname: '',
            res_phone: '',
            res_email: '',
            res_groupName: '',
            res_paymentMethod: '',
            res_paymentStatus: '',
            res_promo: '',
            res_specialRequest: '',
            res_remark: '',
            res_extraBed: false
          },
          tempRow: {},
          res_adults: '',
          res_teen: '',
          res_kid: '',
        }

      },
      methods: {

        async checkLocation() {
          console.log("location", this.location);

          await axios.post('load_modal.php', {
            action: 'fetchTypes',
            location: this.location
          }).then(res => {
            console.log("respose", res.data);
            this.types = res.data
          })

        },
        table(row) {
          var selected = [];
          $('#addReserveTable').DataTable({
            destroy: true,
            dom: 'lBfrtip',
            buttons: [
              // 'colvis',
              'excel',
              'print',
              'csv'
            ],
            data: row,
            text: "edit",
            rowCallback: function(row, data) {
              if ($.inArray(data.DT_RowId, selected) !== -1) {
                $(row).addClass('selected');
              }
            },
            columns: [{
                data: 'room_id',
              },
              {
                data: 'room_occupancy'
              },
              {
                data: 'room_acc',
                render: function(data) {
                  return `<span data-acc="${data}" id="selectAcc"> ${data} </span>`
                }
              },
              {
                data: 'room_price'
              },
              {
                data: 'room_number'
              },
              {
                data: 'room_status'
              },
              {
                data: 'room_location'
              },
              {
                data: 'room_id',
                render: function(data, type, row) {
                  return `<input type="button" class="btn btn-primary" value="Select" data-id="${data}" data-row="${row}" id="selectRow">`
                }
              }
            ],
          });


          let vm = this
          $(document).on('click', '#selectRow', function() {

            if (start && end) {
              let acc = $('#selectAcc').data("acc")
              // get room id from the table
              let ids = $(this).data("id")
              let temprow = {}
              // filter alldata which is equal to the room id
              vm.allData.forEach(item => {
                if (item.room_id == ids) {
                  temprow = item
                }
              })

              // assign to temp row
              vm.tempRow = temprow
              console.log("temp row", vm.tempRow);


              if (acc === "Loft Family Room") {
                $('#loftModal').modal('show')
              } else {
                $('#guest').modal('show')
              }




            } else {
              alert("Please Select Check In and Check Out Date");
            }
          })

          $('#addReserveTable tbody').on('click', 'tr', function() {
            if (start && end) {
              var id = this.id;
              var index = $.inArray(id, selected);

              if (index === -1) {
                selected.push(id);
              } else {
                selected.splice(index, 1);
              }

              $(this).toggleClass('selected');
            }

          });




        },
        async fetchAll() {

          await axios.post('load_modal.php', {
            action: 'fetchAll'
          }).then(res => {
            this.allData = res.data
            this.table(res.data)
            // console.log(this.allData);
          }).catch(err => console.log(err.message))
        },
        deleteCart(item) {
          let cartIndex = this.cart.indexOf(item)
          this.cart.splice(cartIndex, 1)

          console.log(this.cart);
        },
        booked() {

          this.cart.forEach(item => {
            console.log(item.room_id);
          })
          let guests = {
            adults: this.res_adults,
            teens: this.res_teen,
            kids: this.res_kid,
            ...this.tempRow,
          }


          this.cart.push(guests);


          console.log("singleRoom", guests);
          console.log("cart", this.cart);
          guests = {}
          this.res_adults = ''
          this.res_teen = ''
          this.res_kid = ''
        },
        checkLoftTeen() {
          if (this.res_teen == 1) {
            this.loftKid = true
            this.res_kid = 0
          } else {
            this.loftKid = false
          }
        },
        checkLoftKid() {
          if (this.res_kid == 1) {
            this.loftTeen = true
            this.res_teen = 0
          } else {
            this.loftTeen = false
          }

        },
        CheckGuest() {
          console.log("adults", typeof(this.res_adults));
          console.log("teen", typeof(this.res_teen));
          console.log("kid", typeof(this.res_kid));
          if (this.res_adults === "1") {

            if ((this.res_teen === "2" && this.res_kid === "2") || (this.res_teen === "2" && this.res_kid === "1") || (this.res_teen === "1" && this.res_kid === "2")) {
              alert("This combination of guest numbers is not possible.");
             
              this.res_teen = 0;
              this.res_kid = 0;
            }


          } else if (this.res_adults === "2") {

            if ((this.res_teen === "2" && this.res_kid === "2") || (this.res_teen === "2" && this.res_kid === "0") || (this.res_teen === "1" && this.res_kid === "2")) {
              // alert("This combination of guest numbers is not possible.");
              console.log("2 adult 2 teen");
              this.res_teen = 0;
              this.res_kid = 0;
            } 
          } else if (this.res_adults === "0") {
            alert("adult cant be 0");
            this.res_teen = 0;
            this.res_kid = 0;
          } 
            

        },
        checkAdult() {

        },
        checkTeen() {
          if (this.res_teen == 2 && this.res_adults == 2) {
            console.log("more than two");
            this.res_teen = 0

            alert("2 adult and 2 teens can't stay in 1 room")

            console.log(this.res_kid);
          } else if (this.res_teen == 2 && this.res_kid == 2 ){
            if (this.res_adults == 2){
              alert("2 adult and 2 teens 2 kids can't stay in 1 room")

              this.res_teen = 0
              this.res_kid = 0
            }
          }
        },
        checkKid() {
          if (this.res_kid == 2 && this.res_adults == 2) {
            console.log("more than two");
            // this.teen = true
            alert(`2 adult, 2 kids and ${this.res_teen} teen can't stay in 1 room`)
            this.res_kid = 0
            console.log(this.res_teen);
          } else {
            this.teen = false
            console.log(this.res_teen);
          }
        },

        async addReservation() {
          console.log("Selected room", this.cart);
          console.log("check in", start);
          console.log("check out", end);
          console.log("Form Data", this.formData);

          if (this.cart && start && end) {

            await axios.post('load_modal.php', {
              action: 'addReservation',
              Form: this.formData,
              checkin: start,
              checkout: end,
              rooms: this.cart,
              // price: this.totalPrice
            }).then(res => {
              // window.location.href = 'view_all_reservations.php'
              console.log(res.data);
              this.totalPrice = res.data
            })
          } else {
            alert('Cart is empty please select room(s)')
          }


        },
        async filterRooms() {
          console.log(this.location);
          await axios.post('load_modal.php', {
            action: 'filter',
            location: this.location,
            roomType: this.roomType,
            checkin: start,
            checkout: end
          }).then(res => {
            console.log(res.data);
            this.allData = res.data
            this.table(res.data)
          }).catch(err => console.log(err.message))

          console.log("filtered data", this.allData);
        },
        clearFilter() {
          this.fetchAll()
          this.roomType = ''
          this.location = ''
        },

        getData() {
          this.search_data = []
          axios.post('load_modal.php', {
            query: this.formData.res_promo,
            action: 'fetchPromo'
          }).then(res => {
            console.log(res.data);
            this.search_data = res.data
          });
        },
        getName(name) {
          this.formData.res_promo = name
          this.search_data = []
        }
      },
      created() {
        this.fetchAll()
        Pusher.logToConsole = true;

        let fKey = '<?php echo $_ENV['FRONT_KEY'] ?>'
        let bKey = '<?php echo $_ENV['BACK_SINGLE_KEY'] ?>'
        let gKey = '<?php echo $_ENV['BACK_GROUP_KEY'] ?>'

        // Front end reservation notification channel from pusher


        const pusher = new Pusher(fKey, {
          cluster: 'mt1',
          encrypted: true
        });

        const channel = pusher.subscribe('front_notifications');
        channel.bind('front_reservation', (data) => {
          if (data) {
            this.fetchAll()
          }
        })

        // Back end reservation notification channel from pusher

        const back_pusher = new Pusher(bKey, {
          cluster: 'mt1',
          encrypted: true
        });

        const back_channel = back_pusher.subscribe('back_notifications');

        back_channel.bind('backend_reservation', (data) => {
          if (data) {
            this.fetchAll()
          }
        })

        // Group reservation notification channel from pusher

        const group_pusher = new Pusher(gKey, {
          cluster: 'mt1',
          encrypted: true
        });


        const group_channel = group_pusher.subscribe('group_notifications')

        group_channel.bind('group_reservation', data => {
          if (data) {
            this.fetchAll()
          }
        })
      }
    })

    app.mount('#app')
  </script>





  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>





  <!-- <script src="./js/room.js"></script> -->

</body>

</html>
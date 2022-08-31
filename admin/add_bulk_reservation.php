<?php ob_start(); ?>
<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php session_start(); ?>

<?php

if (!isset($_SESSION['user_role'])) {
  header("Location: ./index.php");
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Kuriftu Resort - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/s/dt/dt-1.10.10,se-1.1.0/datatables.min.css">
  <!-- Custom styles for this template-->

  <link rel="stylesheet" href="./css/t-datepicker.min.css">
  <link rel="stylesheet" href="./css/themes/t-datepicker-green.css">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css">

</head>

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


              <form action="" method="POST" @submit.prevent="addbulk" id="reservation" class="col-12 row" enctype="multipart/form-data">

                <h1 class="mb-4">Group Reservation</h1>




                <div class="col-12">
                  <!------------------------- t-date picker  --------------------->

                  <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Fill in Guest Information</h6>
                    </div>
                    <div class="card-body d-flex justify-content-center">
                      <div class="col-6 row">
                        <label> Select Dates * </label>
                        <div class="t-datepicker col-12 form-group  my-2">
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

                        <div class="form-group col-6">
                          <label> Group Name * </label>
                          <input type="text" class="form-control" v-model="formData.group_name" required>
                        </div>

                        <div class="form-group col-6">
                          <label> Payment Status * </label>
                          <select v-model="formData.group_paymentStatus" class="custom-select" required>
                            <option disabled value="">-select-</option>
                            <option value="payed">Paid</option>
                            <option value="pending_payment">pending payment</option>
                          </select>
                        </div>


                        <div class="form-group col-6">
                          <label> Number of Guests * </label>
                          <input type="text" class="form-control" v-model="formData.group_GNum" @change='SetGuests' required>
                        </div>

                        <div class="form-group col-6">
                          <label for="">Select Room</label> <br>
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" required>
                            Select Room
                          </button>
                        </div>
                        <div class="form-group col-6">
                          <label> Event Type * </label>
                          <select v-model="formData.group_reason" class="custom-select" required>
                            <option disabled value="">-select-</option>
                            <option value="con">Conference</option>
                            <option value="wed">Wedding</option>
                          </select>
                        </div>

                        <div class="form-group col-6">
                          <label> Pricing * </label>
                          <select v-model="formData.group_status" @change="customChecker" class="custom-select" required>
                            <option disabled value="">-select-</option>
                            <option value="def">Default Pricing</option>
                            <option value="cus">Custom Pricing</option>
                          </select>
                        </div>

                        <div class="form-group col-6" v-if="custom">
                          <label for="">Weekends Price *</label>
                          <input type="text" class="form-control" v-model="formData.Weekends" required>
                        </div>

                        <div class="form-group col-6" v-if="custom">
                          <label for="">Weekdays Price *</label>
                          <input type="text" class="form-control" v-model="formData.Weekdays" required>
                        </div>

                        <div class="form-group col-6" v-if="custom">
                          <label for="">Breakfast Price</label>
                          <input type="text" class="form-control" v-model="formData.custom_Breakfast">
                        </div>

                        <div class="form-group col-6" v-if="custom">
                          <label> Extrabed Price</label>
                          <input type="text" class="form-control" v-model="formData.custom_Extrabed">
                        </div>

                        <div class="form-group col-6" v-if="custom">
                          <label>Lunch Price</label>
                          <input type="text" class="form-control" v-model="formData.custom_Lunch">
                        </div>

                        <div class="form-group col-6" v-if="custom">
                          <label>Dinner Price</label>
                          <input type="text" class="form-control" v-model="formData.custom_Dinner">
                        </div>

                        <div class="form-group col-6" v-if="custom">
                          <label>BBQ Price</label>
                          <input type="text" class="form-control" v-model="formData.custom_BBQ">
                        </div>

                        <div class="form-group col-6" v-if="custom">
                          <label>TeaBreak Price</label>
                          <input type="text" class="form-control" v-model="formData.custom_TeaBreak">
                        </div>

                        <div class="form-group col-6">
                          <label>Lunch Guests</label>
                          <input type="text" class="form-control" v-model="formData.group_Lunch">
                        </div>

                        <div class="form-group col-6">
                          <label>Dinner Guests </label>
                          <input type="text" class="form-control" v-model="formData.group_Dinner">
                        </div>

                        <div class="form-group col-6">
                          <label>BBQ Guests </label>
                          <input type="text" class="form-control" v-model="formData.group_BBQ" value="formData.group_BBQ">
                        </div>

                        <div class="form-group col-6">
                          <label for="">Tea Break*</label>
                          <select type="text" class="custom-select" v-model="formData.group_TeaBreak" required>
                            <option disabled value="">-select-</option>
                            <option value="1">1 (Morning or Afternoon)</option>
                            <option value="2">2 (Both Morning and Afternoon)</option>
                          </select>
                        </div>

                        <div class="form-group col-12">
                          <textarea v-model="formData.group_remark" placeholder="Remark*" id="" cols="30" rows="5" class="form-control"></textarea>
                        </div>




                        <div class="form-group">
                          <input type="submit" class="btn btn-primary" name="add_res" value="Submit">
                        </div>
                        <!-- <div class="card-footer py-3">
                                                    <h6 class="m-0 font-weight-bold text-primary">Fill in Gue</h6>
                                                </div> -->

                      </div>
                    </div>
                    <div class="card-footer">

                    </div>
                  </div>


                </div>





              </form>




              <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog">
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

                        <div class="card shadow mb-4">
                          <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Available Rooms </h6>
                          </div>
                          <div class="card-body">
                            <div class="row py-1">

                              <!------------------------- t-date picker end  ------------------>

                              <?php

                              if ($_SESSION['user_role'] == 'SA' || ($_SESSION['user_location'] == 'Boston' && $_SESSION['user_role'] == 'RA')) {

                              ?>
                                <div class="form-group mt-2 col-2">
                                  <select name="room_location" @change="checkLocation" class="custom-select" v-model="location" id="">
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
                                <select name="room_location" class="custom-select" v-model="roomType" id="">
                                  <option disabled value="">Room Type</option>
                                  <option :value="type.name" v-if="location !== 'Bishoftu'" v-for="type in types">
                                    {{ type.name }}
                                  </option>

                                  <option :value="type.type_name" v-if="location === 'Bishoftu'" v-for="type in types">
                                    {{ type.type_name }}
                                  </option>
                                </select>
                              </div>

                              <div class="form-group mt-2 col-2">
                                <input type="number" v-model="room_quantity" class="form-control" placeholder="Number of Rooms">
                              </div>

                              <div id="bulkContainer" class="col-3 mt-2">
                                <button name="booked" @click.prevent="filterRooms" class="btn btn-success">Filter</button>

                                <button name="booked" value="location" id="location" @click.prevent="clearFilter" class="btn btn-danger mx-2">Clear Filters</button>

                              </div>
                            </div>


                            <div class="table-responsive">
                              <table class="table display table-bordered table-hover" id="bulkTable" width="100%" cellspacing="0">

                                <thead>
                                  <tr>
                                    <th><input type="checkbox" id="selectAllboxes" v-model="selectAllRoom" @change="bookAll"></th>
                                    <th>id</th>
                                    <th>Occupancy</th>
                                    <th>Accomodation</th>
                                    <th>Price</th>
                                    <th>Room Number</th>
                                    <th>Room Status</th>
                                    <th>Hotel Location</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="row in allData" :key="row.room_id">
                                    <td><input type="checkbox" :value="row.room_id" @change="booked(row)" class="checkBoxes"></td>
                                    <td>
                                      {{ row.room_id }}
                                    </td>
                                    <td>
                                      {{ row.room_occupancy }}
                                    </td>
                                    <td>
                                      {{ row.room_acc }}
                                    </td>
                                    <td>
                                      {{ row.room_price }}
                                    </td>
                                    <td>
                                      {{ row.room_number }}
                                    </td>
                                    <td>
                                      {{ row.room_status }}
                                    </td>
                                    <td>
                                      {{ row.room_location }}
                                    </td>
                                  </tr>

                                </tbody>
                              </table>
                            </div>


                          </div>
                          <div class="modal-footer">
                            <input type="submit" name="Submit" class="btn btn-primary" value="Submit" @click.prevent="closePopOut">
                          </div>
                        </div>
                      </div>
                    </div>
                    </form>
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


  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <!-- Core plugin JavaScript-->


  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.6.0/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/datatables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- <script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script> -->

  <script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>
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
          location: '',
          room_quantity: '',
          roomType: '',
          custom: false,
          chekedList: false,
          defualt_value: '',
          types: [],
          formData: {
            group_name: '',
            group_paymentStatus: '',
            group_remark: '',
            group_reason: '',
            group_GNum: '',
            group_TeaBreak: '',
            group_BBQ: '',
            group_Dinner: '',
            group_Lunch: '',
            Weekends: '',
            Weekdays: '',
            group_status: '',
            custom_TeaBreak: '',
            custom_BBQ: '',
            custom_Dinner: '',
            custom_Lunch: '',
            custom_Breakfast: '',
            custom_Extrabed: '',

          },
          bookedRooms: [],
          selectAllRoom: false,
          allData: '',

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
        SetGuests() {


          this.formData.group_BBQ = this.formData.group_GNum;
          this.formData.group_Dinner = this.formData.group_GNum;
          this.formData.group_Lunch = this.formData.group_GNum;
          this.formData.defualt_value = this.formData.group_GNum;;

        },
        closePopOut() {
          console.log("Selected Rooms", this.bookedRooms);
          $("#exampleModalCenter").modal("hide");


        },
        IfChecked() {
          if (this.bookedRooms.length == 0) {
            this.chekedList = false;
          } else if (this.bookedRooms.length !== 0) {
            this.chekedList = true;
          }

        },
        customChecker() {
          if (this.formData.group_status == 'cus') {
            this.custom = true
          } else {
            this.custom = false
          }
        },
        bookAll() {

          const checkBoxes = document.querySelectorAll('.checkBoxes')
          const selectAllBoxes = document.querySelector('#selectAllboxes')


          if (this.selectAllRoom) {
            this.bookedRooms = this.allData
            checkBoxes.forEach(check => {
              check.checked = true
            })
          } else {
            this.bookedRooms = []
            checkBoxes.forEach(check => {
              check.checked = false
            })
          }

          console.log("booked rooms", this.bookedRooms);
          console.log(this.allData);
        },
        booked(row) {


          if (event.target.checked) {
            console.log(row);
            this.bookedRooms.push(row)
          } else {
            // let rowIndex = this.bookedRooms.indexOf(row)

            // console.log(rowIndex);
            // this.bookedRooms.splice(rowIndex, 1)
            // console.log(this.bookedRooms);

            this.bookedRooms = this.bookedRooms.filter(item => {
              return item.room_id !== row.room_id
            })

            this.bookedRooms.forEach(item => {
              console.log(item.room_id);
            })
            console.log("new line");
          }

          // if(this.bookedRooms.length == 0 ){
          //     this.chekedList = false;
          // }else if (this.bookedRooms.length !== 0){
          //     this.chekedList = true;
          // }
          // this.fetchAll()
        },
        async addbulk() {

          let capacity = this.bookedRooms.length * 3
          if (start && end) {

            if (this.formData.group_GNum >= this.bookedRooms.length) {

              if (capacity >= this.formData.group_GNum) {

                await axios.post('group_res.php', {
                  action: 'Newadd',
                  checkin: start,
                  checkout: end,
                  rooms: this.bookedRooms,
                  form: this.formData,
                  RoomNum: this.room_quantity,
                  location: this.location
                }).then(res => {
                  // window.location.href = 'view_bulk_reservations.php'
                  console.log(res.data);
                })
              } else {
                alert("Rooms capacity exceeded reduce guest number!")
              }

            } else {
              alert("Rooms cannot exceed guest number!")
            }

          } else {
            alert('Please Select Dates!')
          }

        },
        async fetchAll() {

          await axios.post('load_modal.php', {
            action: 'fetchAll'
          }).then(res => {
            this.allData = res.data
            // this.table(res.data)
            // console.log(this.allData);
          }).catch(err => console.log(err.message))
        },
        async filterRooms() {
          console.log(this.location);

          if (start && end) {
            if (this.room_quantity) {
              await axios.post('group_res.php', {
                action: 'filter',
                location: this.location,
                roomType: this.roomType,
                roomQuantity: this.room_quantity,
                checkin: start,
                checkout: end
              }).then(res => {
                console.log(res.data);
                this.allData = res.data
                // this.table(res.data)
              }).catch(err => console.log(err.message))
            }
          }


          console.log("filtered data", this.allData);
        },
        clearFilter() {
          this.fetchAll()
          this.roomType = ''
          this.location = ''
        },
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
      },
    })

    app.mount('#app')


    // window.addEventListener('load', () => {

    //   const checkBoxes = document.querySelectorAll('.checkBoxes')
    //   const selectAllBoxes = document.querySelector('#selectAllboxes')
    //   selectAllBoxes.addEventListener('click', function() {
    //     if (this.checked) {
    //       console.log("all");
    //       checkBoxes.forEach(check => {
    //         check.checked = true
    //       })

    //     } else {
    //       checkBoxes.forEach(check => {
    //         check.checked = false
    //       })
    //     }
    //   })
    // })
  </script>





  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>





  <!-- <script src="./js/room.js"></script> -->

</body>

</html>
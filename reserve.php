<?php include  'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

  <link rel="stylesheet" href="css/t-datepicker.min.css">
  <link rel="stylesheet" href="css/themes/t-datepicker-green.css">
  <link rel="stylesheet" href="./css/style.css">

  <title>Reservation</title>
</head>

<body>
  <div id="app">
    <header class="header">
      <div class="container">
        <nav class="nav-center">
          <div class="menu">
            <div class="line1"></div>
            <div class="line2"></div>
          </div>
          <div class="logo">
            <img src="./img/Kuriftu_logo.svg" alt="">
          </div>
          <div class="login2">
            <a href="./signIn.php" class="btn-primary1 log mx-2">Log In</a>
            <a href="./signUp.php" class="btn-secondary2 sign">Sign Up</a>
          </div>


          <?php

          if (isset($_SESSION['m_username'])) {
            $user_name =  $_SESSION['m_username'];
          ?>
            <div class="profile">
              <div @click="showDropdown" class="profile-icon">
                <h1 class="profile-name">
                  SA
                </h1>

              </div>

              <div v-if="dropdown" class="drop-down">
                <ul>
                  <li><a href="./profile.php"> <i class="fa-solid fa-user"></i> Profile</a></li>
                  <li> <a href="./logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log out</a></li>
                </ul>
              </div>
            </div>

          <?php
          } else {
            $user_name = null;
          ?>



          <?php
          }

          ?>


        </nav>
        <div class="login">
          <a href="./signIn.php" class="btn-primary1 log mx-2">Log In</a>
          <a href="./signUp.php" class="btn-secondary2 sign">Sign Up</a>
        </div>
        <div class="side-socials">
          <img src="./img/facebook.svg" alt="">
          <img src="./img/instagram.svg" alt="">
          <img src="./img/youtube.svg" alt="">
        </div>

      </div>
    </header>

    <div class="container">
      <div class="form-wrapper">

        <form class="myform" @submit.prevent="submitData">

          <div class="desti-location">
            <div class="icon">
              <img src="./img/location.svg" alt="">
            </div>
            <select class="mySelect" v-model="desti">
              <option disabled value="">
                <p>Choose Destination</p>
              </option>
              <?php

              $query = "SELECT * FROM locations";
              $result = mysqli_query($connection, $query);

              confirm($result);

              while ($row = mysqli_fetch_assoc($result)) {
                $location_id = $row['location_id'];
                $location_name = $row['location_name'];
              ?>
                <option value='<?php echo $location_name ?>'><?php echo $location_name ?></option>
              <?php  }

              ?>
            </select>

          </div>
          <div class="add-guest">

            <!--  <div class="guest-option ">
              <div class="gu-icon" type="text">
                <div class="icon">
                  <img src="./img/guests.svg" alt="">
                </div>
                <p>Guests</p>
              </div>
              <div class="roomoption-all">

                <div class="room-option">
                  <table>
                    <th>Rooms</th>
                    <th>Adult    <p>(add atleast one)</p></th>
                    <th>Child
                      <p>(add child below)</p>
                    </th>
  
                    <tr>
                      <td>Room 1</td>
                      <td>
  
                        <div class="increment-wrapper">
                          <div class="all-btn-wrapper">
                            <input type="text" value="1">
                            <button class="button inc">
                              <span>
                                <img src="./img/up.svg" alt="">
                              </span> </button>
                            <button class="button dec">
                              <span> <img src="./img/arrow.svg" alt=""></span>
                            </button>
                          </div>
  
                        </div>
                      </td>
                      <td>
  
                        <div class="increment-wrapper">
                          <div class="all-btn-wrapper">
                            <input type="text" value="0">
                            <button class="button inc">
                              <span>
                                <img src="./img/up.svg" alt="">
                              </span> </button>
                            <button class="button dec">
                              <span> <img src="./img/arrow.svg" alt=""></span>
                            </button>
                          </div>
  
                        </div>
                      </td>
  
  
                    </tr>
  
                  </table>
                 
                  <div class="add-child">
                    <div class="container">
                    <hr class="single-line">
                      <div class="child-wrapper">
                        <h3>Select Child Age </h3>
                        <p>make sure to select a child age range on the option below</p>
    
                        <select class="selecter" name="" id="">
                          <option value="">0-6
    
                          </option>
                          <option value="">6-11
    
                          </option>
                          <option value="">11-17
    
                          </option>
                        </select>
                      </div>
                    </div>
                  </div>
  
                  <div class="action-btn">
                    <button class="btn btn-primarygreen">Add Room </button>
                    <button type="submit" class="btn btn-primaryred">Done</button>
                  </div>
  
                </div>
              </div>
              <div  class="all-option">
              <div class="increment-wrapper">
                <label>Adults</label>
                <input type="text" value="1">
                <button class="button inc">
                  <span>
                    <img src="./img/up.svg" alt="">
                  </span> </button>
                <button class="button dec">
                  <span> <img src="./img/arrow.svg" alt=""></span>
                </button>
              </div>
              <div class="increment-wrapper">
                <label>Kids</label>
                <input type="text" value="0">
                <button class="button inc">
                  <span>
                    <img src="./img/up.svg" alt="">
                  </span> </button>
                <button class="button dec">
                  <span> <img src="./img/arrow.svg" alt=""></span>
                </button>
              </div>
            </div> -->
            <!-- </div> -->


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
                        <select name="adults" v-model="res_adults" @change="CheckGuest" class="custom-select col-3">
                          <option value="" disabled>Adults*</option>
                          <option value="0">0</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                        </select>

                        <select name="adults" @change="CheckGuest" v-model="res_teen" class="custom-select col-3 offset-1" :disabled="teen">
                          <option value="" disabled>Teens(12-17)</option>
                          <option value="0">0</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                        </select>

                        <select name="adults" @change="CheckGuest" v-model="res_kid" class="custom-select col-3 offset-1" :disabled="kid">
                          <option value="" disabled>kid(6-11)</option>
                          <option value="0">0</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                        </select>


                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" @click="nextBook" data-dismiss="modal" class="btn btn-primary">Save changes</button>
                  </div>
                </div>
              </div>
            </div>


          </div>
          <!-- <div class="add-guest">
            <div class="icon">
              <img src="./img/guests.svg" alt="">
            </div>
            <select class="mySelect2" v-model="desti">
              <option class="myoption" disabled value="">
                Single Guests</option>
              <option class="insideoption" value="">
                <p>   Kids</p>
           
                  
             
              </option>

              <option value=" ">Adults</option>
            </select>

          </div> -->
          <div class="t-datepicker ">
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
          <button type="submit" class="btn btn-primary1">
            Availability
          </button>
        </form>
      </div>


      <div class="row">


        <!-- available rooms -->

        <div class="col-lg-8 mt-5">
          <div class="mycard mt-5" v-for="rows in roomName" :key="rows.room_id">
            <!-- <div  v-if="rows.room_acc === 'Deluxe Lake Front King Size Bed'"> -->


            <img :src="'./admin/room_img/' + rows.room_image" class="mycard-img-top" alt="...">
            <div class="mycard-body">
              <h5 class="mycard-title">
                {{ rows.room_acc }} - {{ rows.room_location}}
              </h5>
              <p class="mycard-price">
                <small class="text-muted">
                  ${{ rows.room_price }} Per Night
                  {{ rows.room_id }}
                </small>

                <small class="text-red">
                  only {{ rows.cnt }} left
                </small>
              </p>
              <p class="mycard-text">
              <ul>
                <!-- <li v-for="am in amenities(row.room_amenities)" :key="am">
                  {{ am }}
                </li> -->
              </ul>
              </p>
              <div class="amenities-icon">
                <div class="icon-wrapper">
                  <img src="./img/wifi.svg" alt="">
                  <p>wifi</p>
                </div>
                <div class="icon-wrapper">
                  <img src="./img/tv.svg" alt="">
                  <p>television</p>
                </div>
                <div class="icon-wrapper">
                  <img src="./img/bath.svg" alt="">
                  <p>bath</p>
                </div>
                <div class="icon-wrapper">
                  <img src="./img/room_service.svg" alt="">
                  <p>service</p>
                </div>
                <div class="icon-wrapper">
                  <img src="./img/bell.svg" alt="">
                  <p>Lobby</p>
                </div>
                <div class="icon-wrapper">
                  <img src="./img/laudary.svg" alt="">
                  <p>laudary</p>
                </div>
                <div class="icon-wrapper">
                  <img src="./img/location2.svg" alt="">
                  <p>location</p>
                </div>
                <div class="icon-wrapper">
                  <img src="./img/parking.svg" alt="">
                  <p>parking</p>
                </div>
              </div>
              <p class="mycard-text">
                {{ rows.room_desc.substring(0,155)+".."}}
              </p>
              <div class="btn-container1">
                <a href="" @click.prevent="addRoom(rows)" class="btn btn-primary1">Select Room</a>
                <a href="" @click.prevent="addRoom(rows)" class="pop-btn btn btn-primary1">Room Detail</a>
              </div>
            </div>
            <!-- </div> -->
          </div>
        </div>

        <div class="col-lg-4 mt-5">
          <div v-if="cart.length != 0" class="cart-container mt-5">
            <div class="cart-image">
              <img src="./admin/room_img/kuriftu.jpg" alt="">
            </div>
            <div class="cart-wrapper">
              <h2 class="cart-title">Your Stay At Kuriftu</h2>
              <div class="cart" v-for="items of cart" :key="items.id">
                <div class="guest-info">
                  <div class="check-out">
                    <h3>Check Out</h3>
                    <p>{{items.checkout}}</p>
                  </div>
                  <div class="check-in">
                    <h3>Check in</h3>
                    <p>{{items.checkin}}</p>
                  </div>
                  <div class="guests">
                    <h3>Guests</h3>
                    <p>{{ items.adults }} Adults {{ items.teens }} Teens {{ items.kids }} Kids</p>
                  </div>
                </div>
                <div class="upper">
                  <h3>{{ items.room_acc }} - {{ items.room_location}}</h3>

                </div>
                <div class="lower">
                  <p class="text-muted">
                  </p>

                  <p class="text-muted">
                    ${{ items.room_price }} Per Night
                  </p>
                </div>
                <div class="cl-icon close" @click.prevent="deleteRoom(items)">
                  <i class="bi bi-trash">Delete</i>
                  <!-- <i class="edit-icon"><img src="./img/edit.svg" alt=""> 
                    <p class="edit-p">edit</p>
                    </i>
                     -->
                  <!-- <i class="add-icon"><img src="./img/add2.svg" alt="">
                    <p class="add-p">Add Room</p>
                  </i> -->
                </div>



              </div>


              <hr>
              <div class="footer-btn promo mb-3">

                <div class="input-group">
                  <input type="text" placeholder="Apply Promo Code" name="res_promo" v-model="promoCode" class="form-control">
                  <div class="input-group-append">
                    <button :disabled="oneClick" @click="fetchPromo" class="input-group-text">Apply</button>

                  </div>
                </div>
              </div>
              <div class="cart-footer-lg" v-if="cart.length != 0">

                <div class="footer-btn">
                  <a @click.prevent="completeCart" class="btn btn-primary3"> BOOK NOW</a>
                </div>

                <div class="price">
                  Total: ${{ totalprice }} <br>
                  Rooms: {{ cart.length }}
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="bottom-cart" v-if="cart.length != 0">

        <div class="bottom-cart-modal" v-if="toggleModal">
          <div class="cart-header">
            <h3 class="summary-title">Booking Summary</h3>
            <div class="close" @click="openModal">
              <img src="./img/close2.svg" alt="">
              <!-- <i class="bi bi-x"></i> -->
            </div>

          </div>


          <hr>

          <div class="cart-content" v-for="items in cart" :key="items.id">
            <div class="upper">
              <h3>{{ items.room_acc }} - {{ items.room_location}}</h3>
              <div class="close" @click.prevent="deleteRoom(items)">
                <i class="bi bi-trash"></i>
              </div>
            </div>

            <div class="lower">
              <p class="text-muted">
              </p>

              <p class="text-muted">
                ${{ items.room_price }}
              </p>
            </div>

            <hr>


          </div>

        </div>
        <div class="cart-footer">
          <div class="price">
            <div>
              Total: ${{ totalprice }} <br>
              Rooms: {{ cart.length }}
            </div>

            <div @click="openModal">
              <i class="bi bi-chevron-up"></i>
            </div>
          </div>

          <div class="footer-btn">

            <a @click.prevent="completeCart" class="btn btn-primary1"> BOOK NOW</a>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="pop-up">
    <div class="container">
      <div class="close-button">
        <img class="close-img" src="./img/close2.svg" alt="">
      </div>
      <div class="pop-wrapper">
        <div class="pop-title">
          <p>Deluxe Lake Front Double King Size Bed</p>
        </div>
        <div class="room-all">
          <div class="room-img">
            <img class="single-room" src="./admin/room_img/Top lake view King (4)-min.jpg" alt="">
            <!-- <div class="diff-images">
              <img src="./admin/room_img/Top lake view King (9)-min.jpg" alt="">
              <img src="./admin/room_img/Top lake view King (4)-min.jpg" alt="">
              <img src="./admin/room_img/Top lake view King (9)-min.jpg" alt="">
            </div> -->
          </div>
          <div class="room-desc">
            <div class="amenties">
              <h3>Executive Room with Lounge Access</h3>
              <div class="amenities-icon">
                <div class="icon-wrapper">
                  <img src="./img/wifi2.svg" alt="">
                  <p>wifi</p>
                </div>
                <div class="icon-wrapper">
                  <img src="./img/tv.svg" alt="">
                  <p>television</p>
                </div>
                <div class="icon-wrapper">
                  <img src="./img/bath.svg" alt="">
                  <p>bath</p>
                </div>
                <div class="icon-wrapper">
                  <img src="./img/room_service.svg" alt="">
                  <p>service</p>
                </div>
                <div class="icon-wrapper">
                  <img src="./img/bell.svg" alt="">
                  <p>Lobby</p>
                </div>
                <div class="icon-wrapper">
                  <img src="./img/laudary.svg" alt="">
                  <p>laudary</p>
                </div>
                <div class="icon-wrapper">
                  <img src="./img/location2.svg" alt="">
                  <p>location</p>
                </div>
                <div class="icon-wrapper">
                  <img src="./img/parking.svg" alt="">
                  <p>parking</p>
                </div>
                <div class="icon-wrapper">
                  <img src="./img/swim.svg" alt="">
                  <p>swimming</p>
                </div>

                <div class="icon-wrapper">
                  <img src="./img/telephone.svg" alt="">
                  <p>telephone</p>
                </div>
                <div class="icon-wrapper">
                  <img src="./img/service.svg" alt="">
                  <p>room</p>
                </div>
                <div class="icon-wrapper">
                  <img src="./img/view2.svg" alt="">
                  <p>view</p>
                </div>
                <div class="icon-wrapper">
                  <img src="./img/voice.svg" alt="">
                  <p>soundproof</p>
                </div>

              </div>
              <div class="room-detail">
                <h3>Room Details</h3>
                <p>Room Size 30 m²<br><br>
                  Comfy beds, 8 – Based on 14 reviews <br><br>
                  This double room features air conditioning, TV, high speed wireless internet, mini-bar and electric kettle.
                  This room also includes access to the Business lounge, complimentary bottled water, private bathroom and bathtub.</p>
              </div>
              <div class="view-detail">
                <h3>View</h3>
                <div class="view-all">
                  <img class="check" src="./img/check.svg" alt="">
                  <p>Lake View</p>
                </div>

              </div>
              <div class="room-faci">

                <h3>Room Facilities</h3>
                <div class="all-facilities">

                  <div class="single-facility">
                    <img class="check" src="./img/check.svg" alt="">
                    <p>Floors accessible</p>
                  </div>
                  <div class="single-facility">
                    <img class="check" src="./img/check.svg" alt="">
                    <p>Linens</p>
                  </div>
                  <div class="single-facility">
                    <img class="check" src="./img/check.svg" alt="">
                    <p>Refrigerator</p>
                  </div>
                  <div class="single-facility">
                    <img class="check" src="./img/check.svg" alt="">
                    <p>Walk-in closet</p>
                  </div>
                  <div class="single-facility">
                    <img class="check" src="./img/check.svg" alt="">
                    <p>Tea/Coffee maker</p>
                  </div>
                  <div class="single-facility">
                    <img class="check" src="./img/check.svg" alt="">
                    <p>Air conditioning</p>
                  </div>
                  <div class="single-facility">
                    <img class="check" src="./img/check.svg" alt="">
                    <p>Flat-screen TV</p>
                  </div>
                  <div class="single-facility">
                    <img class="check" src="./img/check.svg" alt="">
                    <p>Socket near the bed</p>
                  </div>
                  <div class="single-facility">
                    <img class="check" src="./img/check.svg" alt="">
                    <p>Soundproof</p>
                  </div>
                  <div class="single-facility">
                    <img class="check" src="./img/check.svg" alt="">
                    <p>Satellite channels</p>
                  </div>
                  <div class="single-facility">
                    <img class="check" src="./img/check.svg" alt="">
                    <p>Telephone</p>
                  </div>
                  <div class="single-facility">
                    <img class="check" src="./img/check.svg" alt="">
                    <p>Electric kettle</p>
                  </div>
                </div>
                <div class="other-services">
                  <h3>Parking</h3>
                  <p>Free public parking is possible on site</p>
                </div>

              </div>


            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include_once './includes/footer.php' ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <script>
    var start, end
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



      })
    });

    const user = '<?php echo $user_name ?>'
    const app = Vue.createApp({
      mounted() {

      },
      data() {
        return {
          checkIn: '',
          checkOut: '',
          desti: '',
          allData: '',
          cart: [],
          totalprice: '',
          promoCode: '',
          toggleModal: false,
          oneClick: false,
          isPromoApplied: '',
          dropdown: false,
          guest: false,
          res_adults: '0',
          res_teen: '0',
          res_kid: '0',
          res_guest: [],
          kid: false,
          teen: false,
          roww: '',
          totalpriceCart: 0.00,
          PriceArray: [],
          currSeconds: 0,
          timer: 0,
          roomName: []
        }
      },

      methods: {

        popOutSelected(row) {

          let temp = [];
          let newArray = []
          this.allData.forEach(item => {
            newArray = item.filter(data => {
              return !(data.room_acc == row.room_acc && data.room_id == row.room_id)

            })
            temp.push(newArray)
          })

          console.log("Original Data: ", this.allData);

          console.log("Filterd Data: ", temp);
          var Vm = this;

          this.allData = temp
          // Vm.$set(this.allData, temp)
          Vue.nextTick(() => {
            console.log("view updated")
          })
          console.log("Updated Original Data: ", this.allData);

          // Outerfunction(temp);
          this.takeOneEach(this.allData)

        },

        CheckGuest() {


          if (this.res_adults == "1") {

            if ((this.res_teen == "2" && this.res_kid == "2") || (this.res_teen == "2" && this.res_kid == "1") || (this.res_teen == "1" && this.res_kid == "2")) {
              alert("you cant");
            } else {
              this.res_guest = [this.res_adults, this.res_teen, this.res_kid];

            }


          } else if (this.res_adults == "2") {

            if ((this.res_teen == "2" && this.res_kid == "2") || (this.res_teen == "2" && this.res_kid == "0") || (this.res_teen == "1" && this.res_kid == "2")) {
              alert("you cant");
            } else {

              this.res_guest = [this.res_adults, this.res_teen, this.res_kid];

            }
          } else if (this.res_adults == "0") {
            alert("adult cant be 0");
          } else {
            alert("booked");
            this.res_guest = [this.res_adults, this.res_teen, this.res_kid];

          }

        },

        checkAdult() {
          if (this.res_teen || this.res_kid) {
            if (this.res_teen) {
              if (this.res_teen == 2) {

                if (this.res_adults == 2) {

                  alert("you cant");

                } else if (this.res_adults == 1) {

                  if (this.res_kid == 0) {
                    alert("you can");
                  } else {
                    alert("you cant");
                  }
                }
              }
            }

            if (res.res_kid) {
              if (res.res_kid == 2) {

                if (this.res_adults == 2 && this.res_teen == 0) {
                  alret("you can");
                } else {
                  alert("you cant");
                }

              } else if (res.res_kid == 1) {
                if (res.res_adults == 1 && (res.res_teen == 1 || res.res_teen == 1)) {
                  alert("you can")
                } else if (res.res_adults == 2 && res.res_teen == 1) {
                  alert("you can");
                } else {
                  alert("you cant");
                }

              }
            }

          } else {
            alert("you can");
          }


        },
        checkTeen() {
          if (this.res_teen == 2 && this.res_adults == 2) {

            this.res_teen = 0

            alert("2 adult and 2 teens can't stay in 1 room")

          } else {
            this.kid = false

          }
        },
        checkKid() {
          if (this.res_kid == 2 && this.res_adults == 2) {

            // this.teen = true
            alert(`2 adult, 2 kids and ${this.res_teen} teen can't stay in 1 room`)
            this.res_kid = 0

          } else {
            this.teen = false

          }
        },
        showDropdown() {
          this.dropdown = !this.dropdown
        },
        openModal() {
          this.toggleModal = !this.toggleModal

        },
        fetchPromo() {
          this.oneClick = true


          if (!localStorage.promo) {

            axios.post('book.php', {
              action: 'promoCode',
              data: this.promoCode
            }).then(res => {
              let discount = this.totalprice - ((res.data / 100) * this.totalprice)

              this.totalprice = discount
              localStorage.total = JSON.stringify(this.totalprice)


            })
            this.isPromoApplied = true
            localStorage.promo = this.isPromoApplied
          }

          this.isPromoApplied = JSON.parse(localStorage.promo || false)

          // console.log("bottom promo", this.isPromoApplied);


          // console.log("total price", this.totalprice);
        },
        completeCart() {

          if (start && end) {

            axios.post('book.php', {
              action: 'insert',
              checkIn: start,
              checkOut: end,
              location: this.desti,
              data: this.cart,
              total: this.totalprice,
              totalroom: this.cart.length
            }).then((res) => {
              console.log(res.data);
              window.location.href = "register.php"

            })
          } else {
            alert("Please Select Check in and Check out date")
          }

        },
        addRoom(row) {


          if (start && end) {
            this.roww = row;


            $('#guest').modal('show')

          } else {
            alert("Please Select Dates")
          }



        },



        nextBook() {
          let rooms = 0;
          var total = 0.00;

          row = this.roww



          if (user) {

            if (row.cnt > 0) {

              this.row.adults = this.res_guest[0],
                this.row.teens = this.res_guest[1],
                this.row.kids = this.res_guest[2],

                this.cart.push(row)
              this.cart.forEach(val => {
                total += (parseInt(val.room_price) - (0.15 * parseInt(val.room_price))) * this.nights


              })
              this.totalprice = total
              localStorage.total = JSON.stringify(this.totalprice)
              localStorage.cart = JSON.stringify(this.cart)

              row.cnt--
            }
          } else {

            if (row.cnt > 0) {

              let guests = {
                checkin: start,
                checkout: end,
                adults: this.res_guest[0],
                teens: this.res_guest[1],
                kids: this.res_guest[2],
              }
              // console.log("row size:" + Object.keys(row).length);

              let PutTogeter = Object.assign(row, guests)
              this.cart.push(PutTogeter);
              let temparray = [];

              axios.post('book.php', {
                action: 'calculatePrice',
                checkIn: start,
                checkOut: end,
                data: this.cart
              }).then((res) => {
                console.log(res.data);
                this.PriceArray = res.data;
              }).then((res) => {
                this.PriceArray.forEach(val => {
                  total += val;

                })


                this.totalprice = total.toFixed(2);
                localStorage.total = JSON.stringify(this.totalprice)
                localStorage.cart = JSON.stringify(this.cart)
                localStorage.setItem("priceContainer", JSON.stringify(this.PriceArray));
                row.cnt--

                this.popOutSelected(row)


              })
              // this.cart.forEach((val) => {
              //   // console.log(val);
              //   total += parseInt(val.room_price) * this.nights;




              // })
              // console.log(this.PriceArray);
              // this.totalprice = total;
              // var sum = 0.00;
              // for (let i = 0; i < temparray.length; i++) {
              //   sum += temparray[i];
              //   console.log("hello")
              // }

              // temparray.forEach(val => {
              //  this.totalprice += val;
              // console.log(val);
              // total += val.Iprice;
              // this.totalprice += val.Iprice;
              // })
              // console.log(sum);
              // this.totalprice = total
              // console.log(total);

            }
          }



          guests = {}
          this.res_adults = "0"
          this.res_teen = "0"
          this.res_kid = "0"
          $('#guest').modal('hide')
        },

        booked() {


        },

        deleteRoom(row) {
          var tempBack = []
          var retrievedData = localStorage.getItem("priceContainer");
          var PriceCon = JSON.parse(retrievedData);
          let deleteTotal = 0;
          if (user) {
            let cartIndex = this.cart.indexOf(row)
            this.cart.splice(cartIndex, 1)
            this.cart.forEach(val => {
              deleteTotal += (parseInt(val.room_price) - (0.15 * parseInt(val.room_price))) * this.nights

            })


            this.totalprice = deleteTotal
            localStorage.cart = JSON.stringify(this.cart)


            row.cnt++
          } else {
            let found = false;
            let cartIndex = this.cart.indexOf(row)
            this.cart.splice(cartIndex, 1)
            PriceCon.splice(cartIndex, 1)
            PriceCon.forEach(val => {
              deleteTotal += val;

            })

            this.allData.forEach(item => {
              for (let key2 in item) {
                console.log(key2)
                if (item[0].room_acc == row.room_acc) {
                  found = true;
                  console.log(item[0])
                  row.cnt--
                  item.push(row)
                  break;

                }

              }

            })
            if (found == false) {
              let TempoArray = []
              row.cnt--
              TempoArray.push(row)
              this.allData[this.allData.length++] = TempoArray
            }
            this.takeOneEach(this.allData)
            console.log(" Delete new Array", this.allData)

            this.totalprice = deleteTotal
            localStorage.total = JSON.stringify(this.totalprice)
            localStorage.cart = JSON.stringify(this.cart)
            localStorage.setItem("priceContainer", JSON.stringify(PriceCon))
            // row.cnt++



          }
        },
        fetchAllData() {
          axios.post('book.php', {
            action: 'fetchall'
          }).then(res => {
            this.allData = res.data
            this.takeOneEach(this.allData)


          })
        },

        takeOneEach(dataToShorten) {

          this.roomName = []
          dataToShorten.forEach(data1 => {

            let i = 0;
            if (data1.length !== 0) {
              // break;
              data1[i]["cnt"] = data1.length;
              this.roomName.push(data1[0])
            }





          })



        },

        checkAvailablity() {
          axios.post('book.php', {
            action: 'fetchall'
          }).then(res => {
            this.allData = res.data

          })
        },




        async submitData() {

          if (start && end) {
            await axios.post('book.php', {
              action: 'getData',
              checkIn: start,
              checkOut: end,
              desti: this.desti
            }).then(res => {
              this.allData = res.data
            }).catch(err => {
              console.log(err);
            })
          } else {
            alert('Please fill all fields')
          }
        },
        // amenities(am) {

        //   let amt = JSON.parse(JSON.parse(am))
        //   let arryAmt = new Array()
        //   arryAmt = amt

        //   // arryAmt.filter(ary => {
        //   //   return ary.replace("\"", '')
        //   // })
        //   return arryAmt
        // },

      },
      computed: {
        nights() {
          var checkin = new Date(start);
          var checkout = new Date(end);
          var Difference_In_Time = checkout.getTime() - checkin.getTime();
          var stayedNights = Difference_In_Time / (1000 * 3600 * 24);
          return stayedNights
        }
      },
      created() {
        this.fetchAllData()
        this.cart = JSON.parse(localStorage.cart || '[]')
        this.totalprice = JSON.parse(localStorage.total || '[]')


        Pusher.logToConsole = true;

        // Front end reservation notification channel from pusher

        const pusher = new Pusher('d178c59a7edb1db43e11', {
          cluster: 'mt1',
          encrypted: true
        });

        const channel = pusher.subscribe('front_notifications');
        channel.bind('front_reservation', (data) => {
          if (data) {
            this.fetchAllData()
          }
        })

        // Back end reservation notification channel from pusher

        const back_pusher = new Pusher('399f6a3873a4061d829f', {
          cluster: 'mt1',
          encrypted: true
        });

        const back_channel = back_pusher.subscribe('back_notifications');

        back_channel.bind('backend_reservation', (data) => {
          if (data) {
            this.fetchAllData()
          }
        })

        // Group reservation notification channel from pusher

        const group_pusher = new Pusher('afcb8aece0584791ae17', {
          cluster: 'mt1',
          encrypted: true
        });


        const group_channel = group_pusher.subscribe('group_notifications')

        group_channel.bind('group_reservation', data => {
          if (data) {
            this.fetchAllData()
          }
        })

      }
    })
    app.mount('#app')
    $(".button").on("click", function() {
      var $button = $(this);
      var oldValue = $button.parent().find("input").val();
      $button.blur();
      if ($button.hasClass("inc")) {
        var newVal = parseFloat(oldValue) + 1;
      } else {
        if (oldValue > 0) {
          var newVal = parseFloat(oldValue) - 1;
        } else {
          newVal = 0;
        }
      }
      $button.parent().find("input").val(newVal);
    });
    $('#reveal-click').click(function() {
      $('#reveal-wrap #hidden-div').slideToggle({
        direction: "up"
      }, 300);
      $(this).toggleClass('clientsClose');
    }); // end click
    $(function() {
      $(".pop-btn").click(function() {
        $(".pop-up").fadeIn("300");
      })
      $(".pop-up,.close").click(function() {
        $(".pop-up").fadeOut("300");
      })
      $(".pop-wrapper").click(function(e) {
        e.stopPropagation();
      })
    })


    // function Outerfunction(newData) {
    //   this.app.set(app.allData, newData)
    //   console.log("Updated Original Data: ", app.allData);
    // }
  </script>
</body>

</html>
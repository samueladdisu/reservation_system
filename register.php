<?php include  'config.php'; ?>
<?php

function cutFromPromo($promo, $price)
{

  global $connection;

  $promo_query = "SELECT * FROM promo WHERE promo_code = '$promo' AND promo_active = 'yes' LIMIT 1";
  $promo_result = mysqli_query($connection, $promo_query);

  confirm($promo_result);

  $resultNum = mysqli_num_rows($promo_result);
  if ($resultNum == 0) {
    return $price;
  }
  $row = mysqli_fetch_assoc($promo_result);
  $PromoId = $row['promo_id'];
  $usage = $row['promo_usage'];
  // echo json_encode($price);

  if ($row['promo_time'] == null && $row['promo_usage'] == null) {
    $Discount = $price * ($row['promo_amount'] / 100);
    return ($price - $Discount);
  } else if ($row['promo_time'] == null && $row['promo_usage'] !== null) {

    if ($row['promo_usage'] == 0) {
      return $price;
    } else {
      $updated_usage = intval($usage - 1);
      $update_promo = "UPDATE promo SET promo_usage = $updated_usage WHERE promo_id = '$PromoId'";
      $promo_result = mysqli_query($connection, $update_promo);
      confirm($promo_result);

      $Discount = $price * ($row['promo_amount'] / 100);
      return ($price - $Discount);
    }
  } else if ($row['promo_time'] !== null && $row['promo_usage'] == null) {

    $expireDate = strtotime($row['promo_time']);
    $today = strtotime(date('Y-m-d H:i:s'));

    if ($today >= $expireDate) {
      return $price;
    } else {
      $Discount = $price * ($row['promo_amount'] / 100);
      return ($price - $Discount);
    }
  } else if ($row['promo_time'] !== null && $row['promo_usage'] !== null) {
    $expireDate = strtotime($row['promo_time']);
    $today = strtotime(date('Y-m-d H:i:s'));
    $usage = $row['promo_usage'];


    if ($today < $expireDate && $usage !== 0) {

      $updated_usage = intval($usage - 1);
      $update_promo = "UPDATE promo SET promo_usage = $updated_usage WHERE promo_id = '$PromoId'";
      $promo_result = mysqli_query($connection, $update_promo);
      confirm($promo_result);

      $Discount = $price * ($row['promo_amount'] / 100);
      return ($price - $Discount);
    } else {
      // The Promo code is expired
      return $price;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./css/style.css">
  <title>register</title>
</head>

<body>
  <header class="header reserve-header">
    <div class="container">
      <nav class="nav-center">

        <div class="logo">
          <img src="./img/black_logo.svg" alt="">
        </div>
        <div class="line">
          <div class="container1">
            <hr class="line1">
            <ul class="justify-list">

              <li>
                <a class="link-text" href="./">Back to Resorts</a>
              </li>
              <li>
                <a class="link-text" href="">Sign Up</a>
              </li>
              <li>
                <a class="link-text" href="">Login</a>
              </li>
            </ul>


            <hr class="line2">
          </div>
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
    </div>
  </header>

  <?php

  // Pusher library setup


  $app_id = $_ENV['FRONT_APP_ID'];
  $app_key = $_ENV['FRONT_KEY'];
  $app_secret = $_ENV['FRONT_SECRET'];
  $app_cluster = 'mt1';

  $pusher = new Pusher\Pusher($app_key, $app_secret, $app_id, ['cluster' => $app_cluster]);



  // pusher setup end
  $cart = $_SESSION['cart'];
  $cartString = json_encode($cart);
  $location = $_SESSION['location'];
  $checkIn =  $_SESSION['checkIn'];
  $checkOut = $_SESSION['checkOut'];
  $total_price = floatval($_SESSION['total']);
  $slocation = $_SESSION['Selectedlocation'];




  $id = array();
  $guestInfoAll = array();
  $roomNum = array();
  $roomAcc = array();
  $roomLoca = array();
  $CinCoutInfo = array();
  $CICOAll  = array();
  $boardeArr = array();



  $GID =  getName(7);

  $res_confirmID = getName(8);
  foreach ($cart as  $val) {
    $id[] = $val->room_id;
    $guestInfo = [$val->adults, $val->teens, $val->kids];
    array_push($guestInfoAll, $guestInfo);
    $roomNum[] = $val->room_number;
    $roomAcc[] = $val->room_acc;
    $roomLoca[] =  $val->room_location;
    $CinCoutInfo = [$val->checkin, $val->checkout];
    array_push($CICOAll, $CinCoutInfo);
    array_push($boardeArr, $val->reservationBoard);
  }
  $id_sql = json_encode($id);
  $id_int = implode(',', $id);

  if (isset($_POST['complete_book'])) {

    foreach ($_POST as $name => $value) {
      $params[$name] = escape($value);
      $_SESSION[$name] = escape($value);
    }


    $_SESSION['fName'] = $params['res_firstname'];
    $_SESSION['lName'] = $params['res_lastname'];
    $_SESSION['email'] = $params['res_email'];




    if (isset($_POST['res_guestNo']) && $_POST['res_guestNo'] != "") {

      if ($_SESSION["promoApp"] == false) {
        $total_price_promo = cutFromPromo($_POST['res_guestNo'], $total_price);
        if ($total_price_promo == $total_price) {
          echo "<script> alert('Sorry! Promo code is expired or wrong');</script>";
        } else {

          $_SESSION['total'] = "$total_price_promo";
          $_SESSION["promoApp"] = true;


          // } else {
          // }
        }
      }
    }


    date_default_timezone_set('Africa/Addis_Ababa');
    $roomID = json_encode($id);
    $guestInfoAlls = json_encode($guestInfoAll);
    $roomNums = json_encode($roomNum);
    $roomAccs =  json_encode($roomAcc);
    $roomLocas = json_encode($roomLoca);
    $CICOAlls  = json_encode($CICOAll);
    $boardeArrs = json_encode($boardeArr);

    $created_at = date('Y-m-d h:i:s');

    $queryDB = "INSERT INTO temp_res(firstName, lastName, phoneNum, email, country, resAddress, city, zipCode, paymentMethod, total, specialRequest, userGID, promoCode, room_id, guestInfo, room_num, room_acc, room_location, CinCoutInfo, temp_board, created_at) 
          VALUES('{$params['res_firstname']}', '{$params['res_lastname']}', '{$params['res_phone']}', '{$params['res_email']}', '{$params['res_country']}', '{$params['res_address']}', '{$params['res_city']}', '{$params['res_zip']}', '{$params['res_paymentMethod']}', '{$total_price}', '{$params['res_specialRequest']}', '$GID', '{$params['res_guestNo']}', '$roomID', '$guestInfoAlls', '$roomNums', '$roomAccs', '$roomLocas', '$CICOAlls', '$boardeArrs', '$created_at')";

    $result = mysqli_query($connection, $queryDB);
    confirm($result);


    // get id of the regestered and send to payment provaider 

    // $querySelect = "SELECT * FROM temp_res WHERE userGID = '$GID'";
    // $result = mysqli_query($connection, $querySelect);
    // confirm($result);
    // $resultNum = mysqli_num_rows($result);
    // if ($resultNum == 1) {
    //   $temprec = mysqli_fetch_assoc($result);


    $_SESSION['Rtemp'] = $GID;



    switch ($params['res_paymentMethod']) {
      case 'telebirr':
        header("Location: ./telebirr.php");
        break;
      case 'amole':
        header("Location: ./amole.php");
        // $_SESSION['currency'] = "USD";
        break;
      case 'chapa_etb':
        header("Location: ./chapa.php");
        $_SESSION['currency'] = "ETB";
        break;
    }
  }

  //   if ($params['res_paymentMethod'] == 'arrival') {
  //     $firstDate = new DateTime($checkIn);
  //     $today = new DateTime();
  //     $diff = $firstDate->diff($today);
  //     $days = $diff->days;

  //     if ($days < 5) {
  //       echo "<script> alert('You can\'t reserve less than 5 days in advance');</script>";
  //     } else {

  //       foreach ($carts  as $value) {
  //         $guestNums = json_encode($value['guestnums']);
  //         $cartStingfy = json_encode($carts);
  //         $nowCI = strtotime($value['Checkin']);
  //         $nowCO = strtotime($value['Checkout']);
  //         if (($nowCI != $oldCI || $nowCO != $oldCO) || ($oldCI == '' && $oldCO == '')) {
  //           $query = "INSERT INTO reservations(res_firstname, res_lastname, res_phone, res_email, res_checkin, res_checkout, res_country, res_address, res_city, res_zipcode, res_paymentMethod, res_roomIDs, res_price, res_location, res_confirmID, res_specialRequest, res_guestNo, 	res_agent, res_cart, res_roomType, res_roomNo) ";
  //           $query .= "VALUES('{$params['res_firstname']}', '{$params['res_lastname']}', '{$params['res_phone']}', '{$params['res_email']}', '{$value['Checkin']}', '{$value['Checkout']}', '{$params['res_country']}', '{$params['res_address']}', '{$params['res_city']}', '{$params['res_zip']}', '{$params['res_paymentMethod']}', '$id_sql',
  //             '{$total_price}', '{$value['room_location']}', '{$res_confirmID}', '{$params['res_specialRequest']}', '{$temp_row['guestInfo']}', 'website', '$cartStingfy', '{$temp_row['room_acc']}', '{$temp_row['room_num']}') ";

  //           $result = mysqli_query($connection, $query);
  //           confirm($result);
  //           $oldCI = strtotime($value['Checkin']);
  //           $oldCO = strtotime($value['Checkout']);
  //         }


  //         $last_record_query = "SELECT * FROM reservations WHERE res_confirmID = '$res_confirmID'";
  //         $last_record_result = mysqli_query($connection, $last_record_query);
  //         confirm($last_record_result);
  //         $row = mysqli_fetch_assoc($last_record_result);

  //         $res_Id = $row['res_id'];

  //         $booked_query = "INSERT INTO booked_rooms(b_res_id, b_roomId, b_roomType, b_roomLocation, b_checkin, b_checkout) ";
  //         $booked_query .= "VALUES ('$res_Id', '{$value['room_id']}', '{$value['room_acc']}', '{$value['room_location']}',  '{$value['Checkin']}', '{$value['Checkout']}')";

  //         $booked_result = mysqli_query($connection, $booked_query);

  //         confirm($booked_result);

  //         $booked_query = "INSERT INTO guest_info(info_res_id, info_adults, info_kids, info_teens, info_room_id, info_room_number, info_room_acc, info_room_location, info_board) ";
  //         $booked_query .= "VALUES ('$res_Id', '{$value['adults']}', '{$value['kids']}',  '{$value['teens']}', '{$value['room_id']}', '{$value['room_number']}', '{$value['room_acc']}', '{$value['room_location']}', '{$value['res_board']}')";
  //         $booked_result = mysqli_query($connection, $booked_query);
  //         confirm($booked_result);

  //         $status_query = "UPDATE `rooms` SET `room_status` = 'booked' WHERE `room_id` = '{$value['room_id']}'";
  //         $result_status = mysqli_query($connection, $status_query);
  //         confirm($result_status);
  //       }
  //     }
  //   } else {

  // }

  ?>
  <div class="container" id="regApp">
    <h1 class="register-title">YOUR DETAILS</h1>
    <p class="register-subtitle">
      Feel out the form below inorder to book a room
    </p>
    <div class="row">
      <form class="row my-form col-lg-8 g-3 mt-lg-n2 " action="" method="post">


        <div class="col-md-6 ">

          <input required type="text" placeholder="First Name" name="res_firstname" value="<?php echo isset($params['res_firstname']) ? $params['res_firstname'] : '';   ?>" class="form-control" id="inputEmail4">
        </div>
        <div class="col-md-6">

          <input required type="text" placeholder="Last Name" value="<?php echo isset($params['res_lastname']) ? $params['res_lastname'] : '';   ?>" name="res_lastname" class="form-control" id="inputPassword4">
        </div>
        <div class="col-md-6">
          <input required type="phone" placeholder="Phone No." value="<?php echo isset($params['res_phone']) ? $params['res_phone'] : '';   ?>" name="res_phone" class="form-control" id="inputAddress">
        </div>
        <div class="col-md-6">

          <input required type="email" placeholder="Email" value="<?php echo isset($params['res_email']) ? $params['res_email'] : '';   ?>" name="res_email" class="form-control" id="inputAddress2">
        </div>

        <div class="col-md-6">

          <input required type="text" placeholder="Country" value="<?php echo isset($params['res_country']) ? $params['res_country'] : '';   ?>" class="form-control" name="res_country" id="inputCity">
        </div>

        <div class="col-md-6">
          <input required type="text" value="<?php echo isset($params['res_address']) ? $params['res_address'] : '';   ?>" placeholder="Address" class="form-control" name="res_address" id="inputCity">
        </div>


        <div class="col-md-6">

          <input type="text" placeholder="Promo Code" value="<?php echo isset($params['res_guestNo']) ? $params['res_guestNo'] : '';   ?>" class="form-control" name="res_guestNo" id="inputCity">
        </div>
        <div class="col-md-6">
          <input required type="text" placeholder="City" value="<?php echo isset($params['res_city']) ? $params['res_city'] : '';   ?>" class="form-control" name="res_city" id="inputCity">
        </div>
        <div class="col-md-6">
          <input type="text" placeholder="Special Request" value="<?php echo isset($params['res_specialRequest']) ? $params['res_specialRequest'] : '';   ?>" class="form-control" name="res_specialRequest" id="inputCity">
        </div>
        <div class="col-md-6">

          <input required type="text" value="<?php echo isset($params['res_zip']) ? $params['res_zip'] : '';   ?>" placeholder="Zip/Postal Code" class="form-control" name="res_zip" id="inputCity">
        </div>
        <div class="col-md-6">
          <label for="inputState" class="form-label payment">Payment Platform</label>
          <select required id="inputState" value="<?php echo isset($params['res_paymentMethod']) ? $params['res_paymentMethod'] : '';   ?>" name="res_paymentMethod" class="form-select">
            <option disabled value="">Select Option</option>
<!--             <option value="amole">Credit Card</option> -->
            <option value="chapa_etb">Amole</option>
            <option value="chapa_etb">Telebirr</option>
            <!-- <option value="telebirr">Telebirr</option> -->
            <option value="chapa_etb">Bank of Abysiniya</option>
            <option value="chapa_etb">CBE Birr</option>
            <!-- <option value="chapa_usd">Pay Pal</option> -->
            <option value="chapa_etb">Wegagen Hello Cash</option>
            <option value="chapa_etb">E-birr</option>
          </select>
        </div>

        <div class="col-12">
          <div class="form-check">
            <input required class="form-check-input" type="checkbox" id="book">
            <label class="form-check-label" for="book">
              I agree with <a href="#"> Booking Term and Conditions </a>
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="news">
            <label class="form-check-label" for="news">
              I would like to receive newsletters and special offers by email
            </label>
          </div>

        </div>
        <div class="col-12">
          <button type="submit" @click="clearCart" name="complete_book" class="btn btn-primary2">Complete Booking</button>
        </div>
      </form>

      <div class="col-lg-3 ">
        <div class="cart-container">

          <?php
          if ($slocation == "Bishoftu") { ?>
            <img src="./img/2.webp" alt="">
          <?php } else if ($slocation == "awash") { ?>
            <img src="./img/awash-cover.webp" alt="">
          <?php } else if ($slocation == "entoto") { ?>
            <img src="./img/Glamping.webp" alt="">
          <?php } else if ($slocation == "Tana") { ?>
            <img src="./img/Tana.webp" alt="">
          <?php } ?>
          <h2 class="cart-title mt-2">Your Stay At Kuriftu</h2>

          <div class="cart-date">
            <div class="u-checkin">
              <h3 class="t-chkin">Check-in</h3>
              <h3><?php echo $_SESSION['checkIn']; ?></h3>
            </div>

            <div class="u-checkin">
              <h3 class="t-chkin">Check-out</h3>
              <h3><?php echo $_SESSION['checkOut']; ?></h3>
            </div>

          </div>
          <div class="cart">

            <div class="upper" v-for="rows in cartCompleted" :key="rows.room_id">
              <h3>{{rows.room_acc}} - {{rows.room_location}}
              </h3>
              <p class="text-muted">
                ${{rows.room_price}} / night
              </p>
            </div>

          </div>

          <hr>

          <div class="footer-btn promo mb-3">
            <div class="price">
              Total: $

              {{totalPtice}}
              <br>
              Rooms: <?php echo $_SESSION['rooms']; ?>

            </div>
            <!-- <p class="text-muted" id="Timer" v-if="min > 10 && sec > 10 ">
              {{ min }}: {{sec}}min
            </p>
            <p class="text-muted" id="Timer" v-else-if="min > 10 && sec < 10 ">
              {{ min }}: 0{{sec}}min
            </p>
            <p class="text-muted" id="Timer" v-else-if="min < 10 && sec > 10 ">
              0{{ min }}: {{sec}}min
            </p>
            <p class="text-muted" id="Timer" v-else-if="min < 10 && sec < 10 ">
              0{{ min }}: 0{{sec}}min
            </p> -->
          </div>

        </div>
      </div>
    </div>

    <div class="bottom-cart">

      <div class="bottom-cart-modal" v-if="toggleModal">
        <div class="cart-header">
          <h3 class="summary-title">Booking Summary</h3>
          <div class="close" @click="openModal">
            <img src="./img/close2.svg" alt="">
            <!-- <i class="bi bi-x"></i> -->
          </div>

        </div>
        <hr>

        <div class="cart-content" v-for="items in cartCompleted" :key="items.room_id">
          <div class="upper">
            <h3>{{ items.room_acc }} - {{ items.room_location}}</h3>

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
            Total: ${{ totalPtice }} <br>
            Rooms: <?php echo $_SESSION['rooms']; ?>
          </div>

          <div @click="openModal">
            <i class="bi bi-chevron-up"></i>
          </div>
        </div>
      </div>
    </div>


    <div class="modal" tabindex="-1" role="dialog" id="TimesUP">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Kuriftu</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>are you still there.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="clearOrder">Cancel</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="TimerExtend()">Yes</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer>
    <div class="container">
      <img src="./img/black_logo.svg" alt="">
      <p>All Copyright &copy; 2022 Kuriftu Resort and Spa. Powered by <a href="https://versavvymedia.com/" target="_blank">Versavvy</a></p>
    </div>

  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <!-- <script src="./js/reserve.js"></script> -->
  <?php include_once './includes/footer.php' ?>
  <!-- <script src="./js/reserve.js">var color = "";</script> -->



  <script>
    const register = Vue.createApp({
      data() {
        return {
          cartCompleted: [],
          arrival: "",
          currSeconds: '30',
          timer: '0',
          min: 0,
          sec: 0,
          days: 559,
          hours: 15,
          minutes: 30,
          seconds: 00,
          dis: '',
          totalPtice: <?php echo $total_price; ?>,
          oneClick: false,
          isPromoApplied: false,
          toggleModal: false
        };
      },
      methods: {

        openModal() {
          this.toggleModal = !this.toggleModal

        },
        fetchPromo() {
          this.oneClick = true
          if (!localStorage.promo) {

            axios.post('book.php', {
              action: 'promoCode',
              data: this.promoCode,
              TotalPrice: <?php echo $total_price; ?>
            }).then(res => {
              console.log(res.data)
              this.totalPtice = res.data.toFixed(2)
              localStorage.total = JSON.stringify(this.totalPtice)
            })
            this.isPromoApplied = true
            localStorage.promo = this.isPromoApplied
          }
          this.isPromoApplied = JSON.parse(localStorage.promo || false)
        },

        TimerExtend() {
          $("#TimesUP").modal("hide");
          this.resetTimer;
        },
        viewCart(CartIn) {
          this.cartCompleted = CartIn
        },
        CheckFrom(availables, selectedCart) {
          var temp = []
          var notFound = []
          selectedCart.forEach(cartItem => {
            availables.forEach(item => {
              newArray = item.filter(data => {
                return data.room_acc == cartItem.room_acc && data.room_id == cartItem.room_id
              })
              if (newArray.length !== 0) {
                temp.push(newArray)
              }

            })
          })
          if (temp.length !== 0) {
            console.log("found", temp)
            selectedCart.forEach(tempdata => {

              checkLefted = temp.filter(data => {
                return tempdata.room_acc == data.room_acc && tempdata.room_id == data.room_id
              })
              if (checkLefted.length !== 0) {
                notFound.push(checkLefted)
              }

            })
            if (notFound.length !== 0) {
              this.resetTimer();
              $("#TimesUP").modal("hide");

            } else {

              console.log("needs update", temp)
              this.cartCompleted = temp
            }

          } else {
            console.log("needs to be update", notFound, temp)
          }



        },
        checkExistance(CheckIn, CheckOut, cart) {


          // console.log("CArt 2",cart2)
          axios
            .post("book.php", {
              action: "fetchall",
              checkIn: CheckIn,
              checkOut: CheckOut,
            })
            .then((response) => {
              console.log(response.data);
              // var cart = 
              console.log("Cart:", <?php echo json_encode($_SESSION['cart'])  ?>);
              // let cartfetched = 
              this.CheckFrom(response.data, <?php echo json_encode($_SESSION['cart'])  ?>);
            });
        },

        clearOrder() {

          var cartClear = <?php echo json_encode($_SESSION['cart']) ?>

          cartClear.forEach(eachID => {
            axios
              .post("book.php", {
                action: "ClearHold",
                RoomId: eachID.room_id,

              })
              .then((response) => {

                sessionStorage.clear();
                window.location.href = "reserve.php?location=<?php echo $slocation; ?>";

              });

          })

        },
        clearCart() {
          console.log("here is hem too")
          localStorage.clear();
        },
        startIdleTimer() {
          if (this.sec >= 6) {
            this.sec--;
          } else if (this.sec == 0) {
            if (this.min > 0) {
              this.min--;
            } else if (this.min == 0) {
              this.clearOrder();
            }
          } else if (this.sec == 5) {
            this.sec--;
            $("#TimesUP").modal("show");
          } else if (this.sec <= 4) {
            this.sec--;
          }
        },
        resetTimer() {
          /* Clear the previous interval */
          clearInterval(this.timer);

          /* Reset the seconds of the timer */
          this.sec = '1800';
          this.min = '0';
          /* Set a new interval */
          this.timer = setInterval(this.startIdleTimer, 1000);
        },
      },

      created() {
        this.viewCart(<?php echo json_encode($_SESSION['cart'])  ?>)

        window.onload = this.resetTimer;
        window.onmousemove = this.resetTimer;
        window.onmousedown = this.resetTimer;
        window.ontouchstart = this.resetTimer;
        window.onclick = this.resetTimer;
        window.onkeypress = this.resetTimer;
      },

      watch: {
        hours(value) {

        },
        minutes: 37,
        seconds: 25,

      }
    });

    register.mount("#regApp");
  </script>


</body>

</html>

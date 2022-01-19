<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./css/reserve.css">
  <title>register</title>
</head>

<body style="background: #E5E5E5;">
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
      </nav>

      <div class="side-socials">
        <img src="./img/facebook.svg" alt="">
        <img src="./img/instagram.svg" alt="">
        <img src="./img/youtube.svg" alt="">
      </div>

    </div>
  </header>

  <?php
  $cart = $_SESSION['cart'];
  $location = $_SESSION['location'];
  $total_price = 0;
  $id = array();

  function getName($n)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
      $index = rand(0, strlen($characters) - 1);
      $randomString .= $characters[$index];
    }

    return $randomString;
  }

  $res_confirmID = getName(8);
  foreach ($cart as  $val) {
    $id[]     = $val->room_id;
    $total_price += $val->room_price;
  }
  $id_sql = json_encode($id);
  $id_int = implode(',', $id);



  if (isset($_POST['complete_book'])) {



    foreach ($_POST as $name => $value) {
      $params[$name] = escape($value);
    }



    $query = "INSERT INTO reservations(res_firstname, res_lastname, res_phone, res_email, res_checkin, res_checkout, res_country, res_address, res_city, res_zipcode, res_paymentMethod, res_roomIDs, res_price, res_location, res_confirmID) ";
    $query .= "VALUES('{$params['res_firstname']}', '{$params['res_lastname']}', '{$params['res_phone']}', '{$params['res_email']}', '{$params['res_checkin']}', '{$params['res_checkout']}', '{$params['res_country']}', '{$params['res_address']}', '{$params['res_city']}', '{$params['res_zip']}', '{$params['res_paymentMethod']}', '$id_sql', '{$total_price}', '{$location}', '{$res_confirmID}') ";

    $result = mysqli_query($connection, $query);
    confirm($result);


    $status_query = "UPDATE `rooms` SET `room_status` = 'booked' WHERE `room_id` IN ($id_int)";
    $result_status = mysqli_query($connection, $status_query);
    confirm($result_status);

    switch ($params['res_paymentMethod']) {
      case 'amole':
        header("Location: ./amole.php");
        break;
      case 'paypal':
        header("Location: ./paypal.php");
        break;
      case 'telebirr':
        header("Location: ./telebirr.php");
        break;
    }
  }

  ?>
  <div class="container ">
    <h1 class="register-title">YOUR DETAILS</h1>
    <p class="register-subtitle">
      Feel out the form below inorder to book a room
    </p>
    <div class="row">
      <form class="row my-form col-lg-6 g-3" action="" method="post">


        <div class="col-md-6">

          <input type="text" placeholder="First Name" name="res_firstname" class="form-control" id="inputEmail4">
        </div>
        <div class="col-md-6">

          <input type="text" placeholder="Last Name" name="res_lastname" class="form-control" id="inputPassword4">
        </div>
        <div class="col-md-6">
          <input type="phone" placeholder="Phone No." name="res_phone" class="form-control" id="inputAddress">
        </div>
        <div class="col-md-6">

          <input type="email" placeholder="Email" name="res_email" class="form-control" id="inputAddress2">
        </div>

        <div class="col-md-6">

          <input type="text" placeholder="Country" class="form-control" name="res_country" id="inputCity">
        </div>
        <div class="col-md-6">
          <input type="text" placeholder="Address" class="form-control" name="res_address" id="inputCity">
        </div>
        <div class="col-md-6">
          <input type="text" placeholder="City" class="form-control" name="res_city" id="inputCity">
        </div>
        <div class="col-md-6">

          <input type="text" placeholder="Zip/Postal Code" class="form-control" name="res_zip" id="inputCity">
        </div>
        <div class="col-md-6">
          <label for="inputState" class="form-label payment">Payment Platform</label>
          <select id="inputState" name="res_paymentMethod" class="form-select">
            <option value="paypal">Pay Pal</option>
            <option value="amole">Amole</option>
            <option value="telebirr">Telebirr</option>
          </select>
        </div>

        <div class="col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="gridCheck">
            <label class="form-check-label" for="gridCheck">
              I agree with <a href="#"> Booking Coditions </a>
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="gridCheck">
            <label class="form-check-label" for="gridCheck">
              I would like to receive newsletters and special offers by email
            </label>
          </div>

        </div>
        <div class="col-12">
          <button type="submit" name="complete_book" class="btn btn-primary2">Complete Booking</button>
        </div>
      </form>

      <div class="col-lg-4 offset-lg-2">
        <div class="cart-container">
          <h2 class="cart-title">Your Stay At Kuriftu</h2>

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
          <div class="cart" v-for="items of cart" :key="items.id">
            <?php

            $cart = $_SESSION['cart'];
            // print_r($cart);
            foreach ($cart as $name => $value) {

              $item[$name] = $value;
              foreach ($item[$name] as $name1 => $val) {


                $items[$name1] = $val;
              } ?>
              <div class="upper">
                <h3><?php echo $items['room_acc']; ?> -
                  <?php echo $items['room_location']; ?></h3>
                <p class="text-muted">
                  $<?php echo $items['room_price']; ?>
                </p>
              </div>
            <?php }
            ?>




          </div>

          <hr>
          <div class="cart-footer-lg" v-if="cart.length != 0">



            <div class="price">
              Total: $ <?php echo $total_price; ?> <br>
              Rooms: <?php echo $_SESSION['rooms']; ?>
            </div>
          </div>

          <div class="footer-btn">

          <input type="text" placeholder="Promo Code" name="res_firstname" class="form-control" id="inputEmail4">
          </div>

        </div>
      </div>
    </div>


  </div>

  <footer class="footer">
    <div class="container">
      <section class="footer-wrapper">
        <div class="footer-link-container">
          <div class="upper">
            <div class="desti">
              <h3 class="desti-title">
                Destination
              </h3>
              <ul class="desti-list">
                <div>
                  <li class="footer-link"><a href="#">Bishoftu</a></li>
                  <li class="footer-link"><a href="#">Entoto</a></li>
                  <li class="footer-link"><a href="#">Awash</a></li>
                </div>

                <div>
                  <li class="footer-link"><a href="#">Water Park</a></li>
                  <li class="footer-link"><a href="#">Lake Tana</a></li>
                  <li class="footer-link"><a href="#"></a></li>
                </div>
              </ul>
            </div>

            <div class="desti">
              <h3 class="desti-title">
                Wellness
              </h3>
              <ul class="desti-list">
                <div>
                  <li class="footer-link"><a href="#">Spa</a></li>
                  <li class="footer-link"><a href="#">Pool</a></li>
                  <li class="footer-link"><a href="#">Massage</a></li>
                </div>

                <div>
                  <li class="footer-link"><a href="#">Manicure </a></li>
                  <li class="footer-link"><a href="#">Pedicure</a></li>
                  <li class="footer-link"><a href="#"></a></li>
                </div>
              </ul>
            </div>
          </div>

          <div class="upper">
            <div class="desti">
              <h3 class="desti-title">
                Experience
              </h3>
              <ul class="desti-list">
                <div>
                  <li class="footer-link"><a href="#">Kayaking</a></li>
                  <li class="footer-link"><a href="#">Archery</a></li>
                  <li class="footer-link"><a href="#">Cycling</a></li>
                </div>

                <div>
                  <li class="footer-link"><a href="#">Paintball </a></li>
                  <li class="footer-link"><a href="#">Horse riding</a></li>
                  <li class="footer-link"><a href="#"></a></li>
                </div>
              </ul>
            </div>

            <div class="desti">
              <h3 class="desti-title">
                Quick Links
              </h3>
              <ul class="desti-list">
                <div>
                  <li class="footer-link"><a href="#">Home</a></li>
                  <li class="footer-link"><a href="#">Entoto</a></li>
                  <li class="footer-link"><a href="#">Our Story</a></li>
                </div>

                <div>
                  <li class="footer-link"><a href="#">Lake Tana </a></li>
                  <li class="footer-link"><a href="#">Awash</a></li>
                  <li class="footer-link"><a href="#"></a></li>
                </div>
              </ul>
            </div>

          </div>
        </div>



        <div class="social">
          <h3 class="desti-title">follow us on</h3>

          <div class="icon-container">
            <img src="./img/facebook.svg" alt="">
            <img src="./img/instagram.svg" alt="">
            <img src="./img/youtube.svg" alt="">
          </div>
        </div>
      </section>

      <hr>
      <div class="lower">

        <img src="./img/Kuriftu_logo.svg" alt="">
        <p>&copy; 2021. All Rights Reserved. Web Design & Development by <a href="https://versavvymedia.com/">Versavvy Media PLC</a> </p>
      </div>


    </div>
  </footer>
</body>

</html>
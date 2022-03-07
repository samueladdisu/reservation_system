<?php include  'config.php'; ?>
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

  // Pusher library setup


  $app_id = '1329709';
  $app_key = '341b77d990ca9f10d6d9';
  $app_secret = '2e226aa040b0bc8c8e94';
  $app_cluster = 'mt1';
  
  $pusher = new Pusher\Pusher($app_key, $app_secret, $app_id, ['cluster' => $app_cluster]);




  // pusher setup end
  $cart = $_SESSION['cart'];
  $location = $_SESSION['location'];
  $checkIn =  $_SESSION['checkIn'];
  $checkOut = $_SESSION['checkOut'];
  $total_price = $_SESSION['total'];
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
  }
  $id_sql = json_encode($id);
  $id_int = implode(',', $id);



  if (isset($_POST['complete_book'])) {

    foreach ($_POST as $name => $value) {
      $params[$name] = escape($value);
    }

    if($params['res_paymentMethod'] == 'arrival'){
      $firstDate = new DateTime($checkIn);
      $today = new DateTime();
      $diff = $firstDate->diff($today);
      $days = $diff->days;
   
      if($days < 5){
        echo "<script> alert('You can\'t reserve less than 5 days in advance');</script>";
        return;
      }
 
    }


    $query = "INSERT INTO reservations(res_firstname, res_lastname, res_phone, res_email, res_checkin, res_checkout, res_country, res_address, res_city, res_zipcode, res_paymentMethod, res_roomIDs, res_price, res_location, res_confirmID, res_specialRequest, res_guestNo, 	res_agent) ";
    $query .= "VALUES('{$params['res_firstname']}', '{$params['res_lastname']}', '{$params['res_phone']}', '{$params['res_email']}', '$checkIn', '$checkOut', '{$params['res_country']}', '{$params['res_address']}', '{$params['res_city']}', '{$params['res_zip']}', '{$params['res_paymentMethod']}', '$id_sql', '{$total_price}', '{$location}', '{$res_confirmID}', '{$params['res_specialRequest']}', '{$params['res_guestNo']}', 'website') ";

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

     // pusher trigger notification

    //  $data = array($params, $id);
     $data = true;

     $pusher->trigger('notifications', 'new_reservation', $data);

     // end
  }

  ?>
  <div class="container" id="regApp">
    <h1 class="register-title">YOUR DETAILS</h1>
    <p class="register-subtitle">
      Feel out the form below inorder to book a room
    </p>
    <div class="row">
      <form class="row my-form col-lg-6 g-3" action="" method="post">


        <div class="col-md-6">

          <input type="text" placeholder="First Name" name="res_firstname" 
          value="<?php echo isset($params['res_firstname'])?$params['res_firstname']: '';   ?>" class="form-control" id="inputEmail4">
        </div>
        <div class="col-md-6">

          <input type="text" placeholder="Last Name" 
          value="<?php echo isset($params['res_lastname'])?$params['res_lastname']: '';   ?>" 
          name="res_lastname" class="form-control" id="inputPassword4">
        </div>
        <div class="col-md-6">
          <input type="phone" placeholder="Phone No."
          value="<?php echo isset($params['res_phone'])?$params['res_phone']: '';   ?>"
          name="res_phone" class="form-control" id="inputAddress">
        </div>
        <div class="col-md-6">

          <input type="email" placeholder="Email" 
          value="<?php echo isset($params['res_email'])?$params['res_email']: '';   ?>"
          name="res_email" class="form-control" id="inputAddress2">
        </div>

        <div class="col-md-6">

          <input type="text" placeholder="Country"
          value="<?php echo isset($params['res_country'])?$params['res_country']: '';   ?>"
          class="form-control" name="res_country" id="inputCity">
        </div>

        <div class="col-md-6">
          <input type="text"
          value="<?php echo isset($params['res_address'])?$params['res_address']: '';   ?>"
          placeholder="Address" class="form-control" name="res_address" id="inputCity">
        </div>


        <div class="col-md-6">

          <input type="text" placeholder="No. of Guests"
          value="<?php echo isset($params['res_guestNo'])?$params['res_guestNo']: '';   ?>"
          class="form-control" name="res_guestNo" id="inputCity">
        </div>
        <div class="col-md-6">
          <input type="text" placeholder="City"
          value="<?php echo isset($params['res_city'])?$params['res_city']: '';   ?>"
          class="form-control" name="res_city" id="inputCity">
        </div>
        <div class="col-md-6">
          <input type="text" placeholder="Special Request"
          value="<?php echo isset($params['res_specialRequest'])?$params['res_specialRequest']: '';   ?>"
          class="form-control" name="res_specialRequest" id="inputCity">
        </div>
        <div class="col-md-6">

          <input type="text"
          value="<?php echo isset($params['res_zip'])?$params['res_zip']: '';   ?>"
          placeholder="Zip/Postal Code" class="form-control" name="res_zip" id="inputCity">
        </div>
        <div class="col-md-6">
          <label for="inputState" class="form-label payment">Payment Platform</label>
          <select id="inputState"
          value="<?php echo isset($params['res_paymentMethod'])?$params['res_paymentMethod']: '';   ?>"
          name="res_paymentMethod" class="form-select">
          <option disabled value="">Select Option</option>
            <option value="paypal">Pay Pal</option>
            <option value="amole">Amole</option>
            <option value="telebirr">Telebirr</option>
            <option value="arrival">Pay on Arrival</option>
          </select>
        </div>
        

        <div class="col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="book">
            <label class="form-check-label" for="book">
              I agree with <a href="#"> Booking Coditions </a>
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
          <div class="cart">
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
                  $<?php echo $items['room_price']; ?> / night
                </p>
              </div>
            <?php }
            ?>




          </div>

          <hr>
          <div class="cart-footer-lg">



            <div class="price">
              Total: $ <?php echo $total_price; ?> <br>
              Rooms: <?php echo $_SESSION['rooms']; ?>
            </div>
          </div>



        </div>
      </div>
    </div>


  </div>

  <?php include_once './includes/footer.php' ?>
  <script src="./js/reserve.js"></script>

</body>

</html>
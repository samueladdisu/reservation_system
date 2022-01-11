<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/reserve.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/vue@3.0.2"></script>
  <title>Document</title>
</head>

<body>

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

  <div id="formApp">
    <div class="container cart-container">
      <div class="cart w-50">
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


          <div class="lower">
            <p class="text-muted">
              {{ guests }}
            </p>


          </div>
        <?php }
        ?>



        <div class="cart-footer-lg">



          <div class="price">
            Total: $<?php echo $_SESSION['total']; ?> <br>
            Rooms: <?php echo $_SESSION['rooms']; ?>
          </div>
        </div>
      </div>

      <form class="paypal-form" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_cart">
        <input type="hidden" name="business" value="merchant@kuriftu.com">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="upload" value="1">
        <INPUT TYPE="hidden" name="charset" value="utf-8">
        <?php

        $cart = $_SESSION['cart'];
        $total_price = 0;
        $quantity = 1;
        $item_name = 1;
        $item_number = 1;
        $amount = 1;
        ?>

        <?php
        foreach ($cart as $val) {
          $id     = $val->room_id;
          $total_price = $val->room_price;
          $occ   =     $val->room_occupancy;
          $acc =            $val->room_acc;
          $location =        $val->room_location;

        ?>
          <input type="hidden" name="item_name_<?php echo $item_name; ?>" value="<?php echo $acc; ?>">
          <input type="hidden" name="item_number_<?php echo $item_number; ?>" value="<?php echo $id; ?>">
          <input type="hidden" name="amount_<?php echo $amount; ?>" value="<?php echo $total_price; ?>">

        <?php
          // $quantity++;
          $item_name++;
          $item_number++;
          $amount++;
        } ?>



        <input type="submit" class="btn btn-primary2" name="submit" value="Complete Booking" alt="PayPal - The safer, easier way to pay online">
      </form>
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
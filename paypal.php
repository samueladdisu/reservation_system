<?php include  'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/style.css">
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
              <!-- {{ guests }} -->
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
        <input type="hidden" name="business" value="merchant2@kuriftu.com">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="upload" value="1">
        <INPUT TYPE="hidden" NAME="return" value="URLspecificToThisTransaction">
        <INPUT TYPE="hidden" name="charset" value="utf-8">
        <?php

        $cart = $_SESSION['cart'];
        $total_price = $_SESSION['total'];
        $quantity = 1;
        $item_name = 1;
        $item_number = 1;
        $amount = 1;
        ?>

        <?php
        foreach ($cart as $val) {
          $id     = $val->room_id;
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
          // $amount++;
        } ?>



        <input type="submit" class="btn btn-primary2" name="submit" value="Complete Booking" alt="PayPal - The safer, easier way to pay online">
      </form>
    </div>







  </div>

  <?php include_once './includes/footer.php' ?>
</body>

</html>
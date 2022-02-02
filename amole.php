<?php include  'config.php'; ?>
<?php include 'security.php' ?>
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

      <form  action="payment_confirmation.php" method="post">
        <?php

        $cart = $_SESSION['cart'];
        $total_price = $_SESSION['total'];
        $quantity = 1;
        $item_name = 1;
        $item_number = 1;
        $amount = 1;
        ?>
        <input type="hidden" name="access_key" value="bf0d90b4542b3b2b91ad73049ad08abc">
        <input type="hidden" name="profile_id" value="0CD052F3-59A9-44AD-B4B3-54053477F7DA">
        <input type="hidden" name="transaction_uuid" value="<?php echo uniqid() ?>">
        <input type="hidden" name="signed_field_names" value="access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency">
        <input type="hidden" name="unsigned_field_names">
        <input type="hidden" name="signed_date_time" value="<?php echo gmdate("Y-m-d\TH:i:s\Z"); ?>">
        <input type="hidden" name="locale" value="en">
        <input type="hidden" value="authorization" name="transaction_type" size="25"><br />
        <input type="hidden" name="reference_number" value="1643727245076" size="25"><br />
        <input type="hidden" name="amount" value="<?php echo $total_price; ?>" size="25"><br />
        <input type="hidden" value="USD" name="currency" size="25"><br />


        <input type="submit" id="submit" name="submit" value="submit" />

      </form>
    </div>







  </div>

  <?php include_once './includes/footer.php' ?>
</body>

</html>
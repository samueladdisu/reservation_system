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
  <title>Telebirr</title>
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

              <!-- <li>
                  <a class="link-text" href="./">Back to Resorts</a>
                </li>
                <li>
                  <a class="link-text" href="">Sign Up</a>
                </li>
                <li>
                  <a class="link-text" href="">Login</a>
                </li> -->
            </ul>


            <hr class="line2">
          </div>
        </div>



      </nav>



    </div>
  </header>

  <div id="formApp">



    <div class="container amole-confirm">
      <div class="card">
        <div class="card-body">
          <?php

          $cart = $_SESSION['cart'];
          // print_r($cart);

          foreach ($cart as $name => $value) {

            $item[$name] = $value;
            foreach ($item[$name] as $name1 => $val) {

              // echo $items['room_location'];
             $items[$name1] = $val;
            } ?>

            <h3 class="card-title"><?php echo $items['room_acc']; ?>
            </h3>
            <p class="card-text">
              <?php
              echo $items['room_location']; ?>
            </p>
            <p class="text-muted">
              $<?php echo $items['room_price']; ?>
            </p>



            <div class="lower">
              <p class="text-muted">
                <!-- {{ guests }} -->
              </p>


            </div>
          <?php }
          ?>



          <div class="card-text">

            <div class="row">
              <div class="col-6">
                <p class="card-text">
                  Check in: <?php echo $_SESSION['checkIn']; ?>
                </p>
              </div>
              <div class="col-6">
                <p class="card-text">
                  Check out: <?php echo $_SESSION['checkOut']; ?>
                </p>
              </div>
            </div>

            <div class="price">
              Total: $<?php echo $_SESSION['total']; ?> <br>
              Rooms: <?php echo $_SESSION['rooms']; ?>
            </div>
          </div>

          <button class="ConfirmBtn btn btn-primary mt-1" style="background: black;" type="submit" id="submit" name="submit" value="Submit">Confirm Order</button>

          <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.0/axios.min.js"></script>
          <!-- <script src="./telebirr.js"></script> -->


          <!-- <form action="payment_confirmation.php" method="post"> -->

          <?php
          $cart = $_SESSION['cart'];
          $total_price = $_SESSION['total'];

          $quantity = 1;
          $item_name = 1;
          $item_number = 1;
          $amount = 1;

          ?>
          <script type="text/javascript">
            const SubmitPay = document.querySelector('#submit')
            
            // console.log(<?php echo $total_price;  ?>);
            SubmitPay.addEventListener('click', async e => {
              e.preventDefault();
              await axios.post('TeleSubmit.php', {
                action: 'submit',
                Money: <?php echo $total_price;  ?>
              }).then(res => {
                console.log(res.data)
                let respo = JSON.parse(res.data)
                console.log(respo.data.toPayUrl)
                window.location.href = respo.data.toPayUrl
              })
            })
          </script>



        </div>
      </div>
    </div>






  </div>

  <?php include_once './includes/footer.php' ?>
</body>

</html>
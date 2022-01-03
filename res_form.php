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
  <script src="https://unpkg.com/vue@3.0.2"></script>
  <title>Document</title>
</head>

<body>

<div id="formApp">
  <table class="table table-bordered table-hover col-12" id="dataTable" width="100%" cellspacing="0">
    <thead>
      <tr>
        <th>Id</th>
        <th>Occupancy</th>
        <th>Accomodation</th>
        <th>Bed</th>
        <th>Price</th>
        <th>Hotel Location</th>
      </tr>
    </thead>
    <tbody>



    </tbody>
  </table>
  

  <form class="row g-3 w-50"style="margin: 0 auto;" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="business" value="merchant@kuriftu.com">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="upload" value="1">
    <?php

    $cart = $_SESSION['cart'];
    $total_price = 0;
    $quantity = 1;
    $item_name = 1;
    $item_number = 1;
    $amount = 1;
    $room_quantity =  sizeof($cart);
    ?>

    <?php 
    foreach ($cart as $val) {
      $id     = $val->room_id;
      $total_price = $val->room_price;
      $occ   =     $val->room_occupancy;
      $acc =            $val->room_acc;
      $bed =        $val->room_bed;
      $location =        $val->room_location;
   
      ?>
        <input type="hidden" name="item_name_<?php echo $item_name; ?>" value="<?php echo $acc; ?>">
        <input type="hidden" name="item_number_<?php echo $item_number; ?>" value="<?php echo $id; ?>">
        <input type="hidden" name="amount_<?php echo $amount; ?>" value="<?php echo $total_price; ?>">
       
      <?php 
      $quantity++;
      $item_name++;
      $item_number++;
      $amount++;
    } ?>



    <input type="submit"  class="btn btn-primary" name="upload" value="Complete Booking" alt="PayPal - The safer, easier way to pay online">
  </form>

</div>

  <script>
    const app = Vue.createApp({

    })

    app.mount('#formApp')
  </script>
</body>

</html>
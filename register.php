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
  <title>register</title>
</head>
<body>

<?php 
  $cart = $_SESSION['cart'];
  foreach ($cart as $val) {
    $id     = $val->room_id;
    $total_price = $val->room_price;
    $occ   =     $val->room_occupancy;
    $acc =            $val->room_acc;
    $bed =        $val->room_bed;
    $location =        $val->room_location;
  }
  if(isset($_POST['complete_book'])){
    $res_firstname = escape($_POST['res_firstname']);
    $res_lastname = escape($_POST['res_lastname']);
    $res_phone = escape($_POST['res_phone']);
    $res_email = escape($_POST['res_email']);
    $res_checkin = escape($_POST['res_checkin']);
    $res_checkout = escape($_POST['res_checkout']);
    $res_country = escape($_POST['res_country']);
    $res_address = escape($_POST['res_address']);
    $res_city = escape($_POST['res_city']);
    $res_zip = escape($_POST['res_zip']);
    $res_paymentMethod = escape($_POST['res_paymentMethod']);
  }

?>
  
<form class="row g-3 w-50" action="" method="post" style="margin: 0 auto;">
    <div class="col-md-6">
      <label for="inputEmail4" class="form-label">First Name</label>
      <input type="text" name="res_firstname" class="form-control" id="inputEmail4">
    </div>
    <div class="col-md-6">
      <label for="inputPassword4" class="form-label">Last Name</label>
      <input type="text" name="res_lastname" class="form-control" id="inputPassword4">
    </div>
    <div class="col-12">
      <label for="inputAddress" class="form-label">Phone No.</label>
      <input type="phone" name="res_phone" class="form-control" id="inputAddress">
    </div>
    <div class="col-12">
      <label for="inputAddress2" class="form-label"> Email</label>
      <input type="email" name="res_email" class="form-control" id="inputAddress2">
    </div>
    <div class="col-md-6">
      <label for="inputEmail4" class="form-label">Check In</label>
      <input type="date" class="form-control" name="res_checkin" value="<?php echo $_SESSION['checkIn']; ?>" />
    </div>
    <div class="col-md-6">
      <label for="inputPassword4" class="form-label">Check Out</label>
      <input type="date" class="form-control" name="res_checkout" value="<?php echo $_SESSION['checkOut']; ?>" />
    </div>
    <div class="col-md-6">
      <label for="inputCity" class="form-label">Country</label>
      <input type="text" class="form-control" name="res_country" id="inputCity">
    </div>
    <div class="col-md-6">
      <label for="inputCity" class="form-label">Address</label>
      <input type="text" class="form-control" name="res_address" id="inputCity">
    </div>
    <div class="col-md-6">
      <label for="inputCity" class="form-label">City</label>
      <input type="text" class="form-control" name="res_city" id="inputCity">
    </div>
    <div class="col-md-6">
      <label for="inputCity" class="form-label">Zip/Postal Code</label>
      <input type="text" class="form-control" name="res_zip" id="inputCity">
    </div>
    <div class="col-md-6">
      <label for="inputState" class="form-label">Payment Method</label>
      <select id="inputState" name="res_paymentMethod" class="form-select">
        <option value="amole">Amole</option>
        <option value="paypal">Pay Pal</option>
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
    </div>
    <div class="col-12">
      <button type="submit" name="complete_book" class="btn btn-primary">Complete Booking</button>
    </div>
  </form>
</body>
</html>
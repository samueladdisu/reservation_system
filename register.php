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
  $location = $_SESSION['location'];
  $total_price = 0;
  $id = array();

  function getName($n) {
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
  if(isset($_POST['complete_book'])){

   

    foreach ($_POST as $name => $value) {
      $params[$name] = escape($value) ; 
    }

    $query = "INSERT INTO reservations(res_firstname, res_lastname, res_phone, res_email, res_checkin, res_checkout, res_country, res_address, res_city, res_zipcode, res_paymentMethod, res_roomIDs, res_price, res_location, res_confirmID) ";
    $query .= "VALUES('{$params['res_firstname']}', '{$params['res_lastname']}', '{$params['res_phone']}', '{$params['res_email']}', '{$params['res_checkin']}', '{$params['res_checkout']}', '{$params['res_country']}', '{$params['res_address']}', '{$params['res_city']}', '{$params['res_zip']}', '{$params['res_paymentMethod']}', '$id_sql', '{$total_price}', '{$location}', '{$res_confirmID}') ";

    $result = mysqli_query($connection, $query);
    confirm($result);

    switch($params['res_paymentMethod']){
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
      <input type="date" class="form-control"  name="res_checkin" value="<?php echo $_SESSION['checkIn']; ?>" readonly/>
    </div>
    <div class="col-md-6">
      <label for="inputPassword4" class="form-label">Check Out</label>
      <input type="date" class="form-control"  name="res_checkout" value="<?php echo $_SESSION['checkOut']; ?>" readonly/>
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
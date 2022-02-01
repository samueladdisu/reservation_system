<?php include  'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thank You - Kuriftu Resorts</title>
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
  <section class="signup-header">

    <div class="container">
      <nav class="nav-center">
        <div class="signup-menu">
          <div class="line1"></div>
          <div class="line2"></div>
        </div>
        <div class="logo">
          <img src="./img/black_logo.svg" alt="">
        </div>

        <div class="book-now">
          <a href="#" class="btn btn-outline-black ">Book Now</a>
        </div>
      </nav>
    </div>
  </section>

  <section class="main-body">
    <h1 class="caps text-center">Thank you for choosing us! </h1>
    <div class="container" id="form-wiget">
  
    <?php 
    
      if(isset($_GET['tx'])){
        $amount = $_GET['amt'];
        $currency = $_GET['cc'];
        $transaction = $_GET['tx'];
        $status = $_GET['st'];
      }else {
        header("Location: ./reserve.php");
      }
    
    
    ?>
      


    </div>
  </section>

  <?php include_once './includes/footer.php' ?>
</body>

</html>
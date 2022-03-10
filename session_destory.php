<?php include  'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script>
    localStorage.cart = [];
    localStorage.total = 0
  </script>
</head>
<body>
<?php 

  $_SESSION['cart']       = null;
  $_SESSION['location']   = null;
  $_SESSION['checkIn']    = null;
  $_SESSION['checkOut']   = null;
  $_SESSION['total']      = 0;

  header("Location: reserve.php");



?>
  
</body>
</html>



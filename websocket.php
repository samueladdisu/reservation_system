<?php include  'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Document</title>
</head>

<body>


  <?php 

    print_r($_SESSION);
  
  
  ?>
  <div id="paypal-button-container"></div>
   
  
  
  <script src="https://www.paypal.com/sdk/js?client-id=ATooqyMl5FTviA1nOpwCcsEOFEZnRshVj4B_nOfoBcGQWWxHzjWJ5Cz9mni3ySLQbXCDqZ6QaP43FLA4&currency=USD"></script>
  <script src="./paypal.js"></script>
</body>

</html>
<?php ob_start(); ?>
<?php include  './db.php'; ?>
<?php include  './functions.php'; ?>
<?php session_start(); ?>
 <thead>
    <tr>
      <th>Id</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Phone</th>
      <th>Email</th>
      <th># of Guest</th>
      <th>Arrival</th>
      <th>Departure</th>
      <th>Country</th>
      <th>Address</th>
      <th>City</th>
      <th>Zip/Postal Code </th>
      <th>Payment Platform</th>
      <th>Room IDs</th>
      <th>Total Price</th>
      <th>Hotel Location</th>
      <th>Reservation Agent</th>
      <th>Confirm Id</th>
    </tr>
  </thead>
  <tbody>

  <?php
   echo $location = $_SESSION['user_location'];

   if($_SESSION['page']){
     $page = $_SESSION['page'];
  } else {
    $page = "";
  }

  if($page == "" || $page == 1){
    $page_1 = 0;
  }else{
    $page_1 = ($page * 10) - 10;
  }

    if($location == "admin"){
      $query = "SELECT * FROM reservations ORDER BY res_id DESC LIMIT $page_1, 10";
    } else {
      $query = "SELECT * FROM reservations WHERE res_location = '$location' ORDER BY res_id DESC LIMIT $page_1, 10";
    }

   
   
    
    $result = mysqli_query($connection, $query);
    confirm($result);
    while ($row = mysqli_fetch_assoc($result)) {
      foreach ($row as $name => $value) {
        if($name == 'res_roomIDs'){
          $db_res[$name] = json_decode($value, true);

        }else{
          $db_res[$name] = escape($value);

        }
        
      }

      echo "<tr>";
      echo "<td>{$db_res['res_id']}</td>";
      echo "<td>{$db_res['res_firstname']}</td>";
      echo "<td>{$db_res['res_lastname']}</td>";
      echo "<td>{$db_res['res_phone']}</td>";
      echo "<td>{$db_res['res_email']}</td>";
      // echo "<td>{$_GET['page']}</td>";
      echo "<td>{$db_res['res_guestNo']}</td>";
      echo "<td>{$db_res['res_checkin']}</td>";
      echo "<td>{$db_res['res_checkout']}</td>";
      echo "<td>{$db_res['res_country']}</td>";
      echo "<td>{$db_res['res_address']}</td>";
      echo "<td>{$db_res['res_city']}</td>";
      echo "<td>{$db_res['res_zipcode']}</td>";
      echo "<td>{$db_res['res_paymentMethod']}</td>";
      echo "<td>";
      foreach ($db_res['res_roomIDs'] as $value) {
        echo $value. ',';
      }
      echo  "</td>";
      echo "<td>{$db_res['res_price']}</td>";
      echo "<td>{$db_res['res_location']}</td>";
      echo "<td>{$db_res['res_agent']}</td>";
      echo "<td>{$db_res['res_confirmID']}</td>";
      echo "</tr>";
    }


    ?>

  </tbody>

 
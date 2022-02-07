<?php ob_start(); ?>
<?php include  './db.php'; ?>
<?php include  './functions.php'; ?>
<?php session_start(); ?>

 <thead>
    <tr>
    <!-- <th><input type="checkbox" name="" id="selectAllboxes" v-model="selectAllRoom" @change="bookAll"></th> -->
      <th>Id</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Phone</th>
      <th># of Guest</th>
      <th>Arrival</th>
      <th>Departure</th>
      <th>Payment Platform</th>
      <th>Room IDs</th>
      <th>Total Price</th>
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
      ?>
         <!-- <td><input type="checkbox" name="checkBoxArray[]" value="<?php echo $db_res['res_id']; ?>" @change="booked(row)" class="checkBoxes"></td> -->
      <?php
      echo "<td>{$db_res['res_id']}</td>";
      echo "<td>{$db_res['res_firstname']}</td>";
      echo "<td>{$db_res['res_lastname']}</td>";
      echo "<td>{$db_res['res_phone']}</td>";
      echo "<td>{$db_res['res_guestNo']}</td>";
      echo "<td>{$db_res['res_checkin']}</td>";
      echo "<td>{$db_res['res_checkout']}</td>";
      echo "<td>{$db_res['res_paymentMethod']}</td>";
      echo "<td>";
      foreach ($db_res['res_roomIDs'] as $value) {
        echo $value. ',';
      }
      echo  "</td>";
      echo "<td>{$db_res['res_price']}</td>";
      echo "<td>{$db_res['res_confirmID']}</td>";
      if($db_res['res_agent'] != 'website' && $db_res['res_paymentStatus'] != 'payed'){

        echo "<td><a href='./reservations.php?source=edit_res&edit_id={$db_res['res_id']}'>Edit</a></td>";
        echo "<td><a href='view_all_reservations.php?delete={$db_res['res_id']}'>Delete</a></td>";
      }
      echo "</tr>";
    }


    ?>

  </tbody>
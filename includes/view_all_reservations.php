<table class="table table-bordered table-hover col-12" id="dataTable" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th>Id</th>
      <th>Room No.</th>
      <th>Bed Type</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Phone no.</th>
      <th>Email</th>
      <th>Guest No.</th>
      <th>Check In</th>
      <th>Check Out</th>
      <th>Price</th>
      <th>Location</th>
      <th>Remark</th>
    </tr>
  </thead>
  <tbody>

    <?php
    $location = $_SESSION['user_role'];

    if($location == "admin"){
      $query = "SELECT * FROM reservations";
    } else {
      $query = "SELECT * FROM reservations WHERE res_location = '$location' ";
    }
    $result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($result)) {
      $res_id = $row['res_id'];
      $res_room_number = $row['res_room_number'];
      $res_bedtype = $row['res_bedtype'];
      $res_firstname = $row['res_firstname'];
      $res_lastname = $row['res_lastname'];
      $res_phone = $row['res_phone'];
      $res_email = $row['res_email'];
      $res_guest = $row['res_guest'];
      $res_checkin = $row['res_checkin'];
      $res_checkout = $row['res_checkout'];
      $res_price = $row['res_price'];
      $res_location = $row['res_location'];
      $res_remark = $row['res_remark'];

      echo "<tr>";
      echo "<td>{$res_id}</td>";
      echo "<td>{$res_room_number}</td>";
      echo "<td>{$res_bedtype}</td>";
      echo "<td>{$res_firstname }</td>";
      echo "<td>{$res_lastname}</td>";
      echo "<td>{$res_phone}</td>";
      echo "<td>{$res_email}</td>";
      echo "<td>{$res_guest}</td>";
      echo "<td>{$res_checkin}</td>";
      echo "<td>{$res_checkout}</td>";
      echo "<td>{$res_price}</td>";
      echo "<td>{$res_remark}</td>";
      echo "</tr>";
    }


    ?>

  </tbody>
</table>

<?php 

  if(isset($_GET['delete'])){
    $the_post_id = escape($_GET['delete']);
    $query = "DELETE FROM posts WHERE post_id = $the_post_id";
    $result = mysqli_query($connection, $query);

    confirm($result);
    header("Location: ./posts.php");
  }



?>
<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>
<?php
// $reseived_data = json_decode(file_get_contents("php://input"));

// $data = array();

// if($reseived_data->action == 'fetchall'){
//   $query = "SELECT * FROM rooms";
//   $result = mysqli_query($connection,$query);
//   confirm($result);

    
//   while ($row = mysqli_fetch_array($result)) {
//    $data[] = $row;


//   }
//   echo json_encode($data);
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <title>Book</title>
</head>

<body>
  <div class="container">
    <form action="" class="mb-5 mt-5" method="POST">

      <div class="form-group">
        <label for="user_role"> Property </label> <br>
        <select name="destination" class="custom-select" required>
          <option value="">Select Destination</option>
          <option value="Bishoftu">Bishoftu</option>
          <option value="Adama">Adama</option>
          <option value="Entoto">Entoto</option>
          <option value="Lake_Tana">Lake Tana</option>
          <option value="Awash">Awash</option>
          <option value="Boston">Boston</option>
        </select>
      </div>

      <input type="date" name="check_in" />


      <input type="date" name="check_out" />


      <input type="submit" name="book" value="book now">
    </form>


    <div class="card-deck">


      <?php

      if (isset($_POST['book'])) {
        $form_checkin = $_POST['check_in'];
        $form_checkout = $_POST['check_out'];
        $destination = $_POST['destination'];

        echo $form_checkin < $form_checkout;

        // $sql = "SELECT * FROM reservations r1 , reservations r2 WHERE r1.res_checkout <= '$form_checkin' AND r2.res_checkin >= '$form_checkout' AND r1.res_id = r2.res_id;";
        $sql = "SELECT * FROM rooms WHERE room_status = 'Not_booked' AND  room_location = '$destination' ";
        $result = mysqli_query($connection, $sql);
        confirm($result);

    
        while ($row = mysqli_fetch_array($result)) {
          $room_id = $row['room_id'];
          $room_occupancy = $row['room_occupancy'];
          $room_acc = $row['room_acc'];
          $room_bed = $row['room_bed'];
          $room_image = $row['room_image'];
          $room_price = $row['room_price'];
          $room_number = $row['room_number'];
          $room_status = $row['room_status'];
          $room_location = $row['room_location'];
      ?>
          <div class="card">
            <img class="card-img-top" src='./room_img/<?php echo $room_image ?>' alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title"><?php echo $room_location; ?></h5>
              <p class="card-text"><?php echo $room_bed; ?></p>
              <p class="card-text"><small class="text-muted"><?php echo $room_price; ?></small></p>
            </div>
          </div>

      <?php

        }
      }


      ?>
    </div>
  </div>
</body>

</html>
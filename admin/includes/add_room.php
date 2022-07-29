<?php

if ($_SESSION['user_role'] == 'RA') {
  header("Location: ./rooms.php");
}
?>
<script>
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href)
  }
</script>
<?php
$incoming = json_decode(file_get_contents("php://input"));
if (isset($_POST['bishoftu_room'])) {
  $room_acc         =  escape($_POST['b_room_acc']);
  $room_number      =  escape($_POST['b_room_number']);
  $room_desc        =  escape($_POST['b_room_desc']);

  $acc_query  = "SELECT * FROM room_type WHERE type_name = '$room_acc'";
  $acc_result = mysqli_query($connection, $acc_query);

  confirm($acc_result);

  while ($row = mysqli_fetch_assoc($acc_result)) {
    $occ = $row['occupancy'];
    $price = $row['d_rack_rate'];
    $img = $row['room_image'];
    $loc = $row['type_location'];
  }


  $query = "INSERT INTO `rooms` (`room_occupancy`, `room_acc`, `room_price`, `room_image`, `room_number`, `room_status`, `room_location`, `room_desc`) VALUES ('$occ', '$room_acc', '$price', '$img', '$room_number', 'Not_booked', '$loc', '$room_desc');";


  $result = mysqli_query($connection, $query);

  confirm($result);
}

if (isset($_POST['awash_room'])) {
  $room_acc         =  escape($_POST['a_room_acc']);
  $room_number      =  escape($_POST['a_room_number']);
  $room_desc        =  escape($_POST['a_room_desc']);

  $acc_query  = "SELECT * FROM awash_price WHERE name = '$room_acc'";
  $acc_result = mysqli_query($connection, $acc_query);

  confirm($acc_result);

  while ($row = mysqli_fetch_assoc($acc_result)) {
    $occ = $row['occupancy'];
    $price = $row['d_bb_we'];
    $img = $row['room_img'];
  }


  $query = "INSERT INTO `rooms` (`room_occupancy`, `room_acc`, `room_price`, `room_image`, `room_number`, `room_status`, `room_location`, `room_desc`) VALUES ('$occ', '$room_acc', '$price', '$img', '$room_number', 'Not_booked', 'awash', '$room_desc');";


  $result = mysqli_query($connection, $query);

  confirm($result);
}

if (isset($_POST['entoto_room'])) {
  $room_acc         =  escape($_POST['e_room_acc']);
  $room_number      =  escape($_POST['e_room_number']);
  $room_desc        =  escape($_POST['e_room_desc']);

  $acc_query  = "SELECT * FROM entoto_price WHERE name = '$room_acc'";
  $acc_result = mysqli_query($connection, $acc_query);

  confirm($acc_result);

  while ($row = mysqli_fetch_assoc($acc_result)) {
    $occ = $row['occupancy'];
    $price = $row['double_occ'];
    $img = $row['room_img'];
  }


  $query = "INSERT INTO `rooms` (`room_occupancy`, `room_acc`, `room_price`, `room_image`, `room_number`, `room_status`, `room_location`, `room_desc`) VALUES ('$occ', '$room_acc', '$price', '$img', '$room_number', 'Not_booked', 'entoto', '$room_desc');";


  $result = mysqli_query($connection, $query);

  confirm($result);
}

if (isset($_POST['tana_room'])) {
  $room_acc         =  escape($_POST['t_room_acc']);
  $room_number      =  escape($_POST['t_room_number']);
  $room_desc        =  escape($_POST['t_room_desc']);

  $acc_query  = "SELECT * FROM tana_price WHERE name = '$room_acc'";
  $acc_result = mysqli_query($connection, $acc_query);

  confirm($acc_result);

  while ($row = mysqli_fetch_assoc($acc_result)) {
    $occ = $row['occupancy'];
    $price = $row['double_occ'];
    $img = $row['room_img'];
  }


  $query = "INSERT INTO `rooms` (`room_occupancy`, `room_acc`, `room_price`, `room_image`, `room_number`, `room_status`, `room_location`, `room_desc`) VALUES ('$occ', '$room_acc', '$price', '$img', '$room_number', 'Not_booked', 'Lake tana', '$room_desc');";


  $result = mysqli_query($connection, $query);

  confirm($result);
}
?>

<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="bishoftu-tab" data-toggle="tab" href="#bishoftu" role="tab" aria-controls="bishoftu" aria-selected="true">Bishoftu</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="awash-tab" data-toggle="tab" href="#awash" role="tab" aria-controls="awash" aria-selected="false">Awash</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="entoto-tab" data-toggle="tab" href="#entoto" role="tab" aria-controls="entoto" aria-selected="false">Entoto</a>
  </li>
  <li>
    <a class="nav-link" id="tana-tab" data-toggle="tab" href="#tana" role="tab" aria-controls="tana" aria-selected="false">Lake Tana</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="bishoftu" role="tabpanel" aria-labelledby="bishoftu-tab">
    <form action="" id="bishoftuRoom" method="POST" class="col-6 mt-4" enctype="multipart/form-data">
      <div class="form-group">
        <label for="room_acc"> Room Type</label>

        <select name="b_room_acc" class="custom-select" required>
          <option value="">Select option</option>
          <?php
          $bishoftu_query = "SELECT * FROM room_type";
          $result = mysqli_query($connection, $bishoftu_query);

          confirm($result);
          while ($row = mysqli_fetch_assoc($result)) {
            $type_name         = $row['type_name'];
          ?>

            <option value='<?php echo $type_name ?>'><?php echo $type_name ?></option>
          <?php
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="post_tags"> Room Number </label>
        <input type="text" class="form-control" name="b_room_number" required>
      </div>

      <div class="form-group">
        <label for="post_content"> Room Description</label>
        <textarea name="b_room_desc" id="" cols="30" rows="10" class="form-control" required></textarea>
      </div>


      <div class="form-group">
        <input type="submit" class="btn btn-primary" name="bishoftu_room" value="Add Room">
      </div>

    </form>
  </div>
  <div class="tab-pane fade" id="awash" role="tabpanel" aria-labelledby="awash-tab">
    <form action="" id="awashRoom" method="POST" class="col-6 mt-4" enctype="multipart/form-data">
      <div class="form-group">
        <label for="room_acc"> Room Type</label>

        <select name="a_room_acc" class="custom-select" required>
          <option value="">Select option</option>
          <?php
          $query = "SELECT * FROM awash_price";

          $result = mysqli_query($connection, $query);

          confirm($result);
          while ($row = mysqli_fetch_assoc($result)) {
            $type_name         = $row['name'];
          ?>

            <option value='<?php echo $type_name ?>'><?php echo $type_name ?></option>
          <?php
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="post_tags"> Room Number </label>
        <input type="text" class="form-control" name="a_room_number" required>
      </div>

      <div class="form-group">
        <label for="post_content"> Room Description</label>
        <textarea name="a_room_desc" id="" cols="30" rows="10" class="form-control" required></textarea>
      </div>


      <div class="form-group">
        <input type="submit" class="btn btn-primary" name="awash_room" value="Add Room">
      </div>

    </form>
  </div>
  <div class="tab-pane fade" id="entoto" role="tabpanel" aria-labelledby="entoto-tab">
    <form action="" id="entotoRoom" method="POST" class="col-6 mt-4" enctype="multipart/form-data">
      <div class="form-group">
        <label for="room_acc"> Room Type</label>

        <select name="e_room_acc" class="custom-select" required>
          <option value="">Select option</option>
          <?php
          $query = "SELECT * FROM entoto_price";

          $result = mysqli_query($connection, $query);

          confirm($result);
          while ($row = mysqli_fetch_assoc($result)) {
            $type_name         = $row['name'];
          ?>

            <option value='<?php echo $type_name ?>'><?php echo $type_name ?></option>
          <?php
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="post_tags"> Room Number </label>
        <input type="text" class="form-control" name="e_room_number" required>
      </div>

      <div class="form-group">
        <label for="post_content"> Room Description</label>
        <textarea name="e_room_desc" id="" cols="30" rows="10" class="form-control" required></textarea>
      </div>


      <div class="form-group">
        <input type="submit" class="btn btn-primary" name="entoto_room" value="Add Room">
      </div>

    </form>
  </div>
  <div class="tab-pane fade" id="tana" role="tabpanel" aria-labelledby="tana-tab">
    <form action="" id="tanaRoom" method="POST" class="col-6 mt-4" enctype="multipart/form-data">
      <div class="form-group">
        <label for="room_acc"> Room Type</label>

        <select name="t_room_acc" class="custom-select" required>
          <option value="">Select option</option>
          <?php
          $query = "SELECT * FROM tana_price";

          $result = mysqli_query($connection, $query);

          confirm($result);
          while ($row = mysqli_fetch_assoc($result)) {
            $type_name         = $row['name'];
          ?>

            <option value='<?php echo $type_name ?>'><?php echo $type_name ?></option>
          <?php
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="post_tags"> Room Number </label>
        <input type="text" class="form-control" name="t_room_number" required>
      </div>

      <div class="form-group">
        <label for="post_content"> Room Description</label>
        <textarea name="t_room_desc" id="" cols="30" rows="10" class="form-control" required></textarea>
      </div>


      <div class="form-group">
        <input type="submit" class="btn btn-primary" name="tana_room" value="Add Room">
      </div>

    </form>
  </div>
</div>
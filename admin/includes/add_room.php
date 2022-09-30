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

  $query_dup = "SELECT * FROM rooms WHERE room_acc = '$room_acc' AND room_number = '$room_number' AND room_location = 'Bishoftu'";

  $result_dup = mysqli_query($connection, $query_dup);
  confirm($result_dup);
  $row = mysqli_num_rows($result_dup);

  if ($row > 0) {
    echo "<script> alert('This room already exits!') </script>";
    // $row2 = mysqli_fetch_assoc($result_dup);

    // var_dump($row2);
  } else {
    // echo "can";
    $acc_query  = "SELECT * FROM room_type WHERE type_name = '$room_acc'";
    $acc_result = mysqli_query($connection, $acc_query);

    confirm($acc_result);

    while ($row = mysqli_fetch_assoc($acc_result)) {
      $occ = $row['occupancy'];
      $price = $row['d_rack_rate'];
      $img = $row['room_image'];
      $loc = $row['type_location'];
      $room_desc = escape($row['room_desc']);
    }


    $query = "INSERT INTO `rooms` (`room_occupancy`, `room_acc`, `room_price`, `room_image`, `room_number`, `room_status`, `room_location`, `room_desc`) VALUES ('$occ', '$room_acc', '$price', '$img', '$room_number', 'Not_booked', '$loc', '$room_desc');";


    $result = mysqli_query($connection, $query);

    confirm($result);
  }
}

if (isset($_POST['awash_room'])) {
  $room_acc         =  escape($_POST['a_room_acc']);
  $room_number      =  escape($_POST['a_room_number']);

  $acc_query  = "SELECT * FROM awash_price WHERE name = '$room_acc'";
  $acc_result = mysqli_query($connection, $acc_query);

  confirm($acc_result);

  while ($row = mysqli_fetch_assoc($acc_result)) {
    $occ = escape($row['occupancy']);
    $price = escape($row['double_occ']);
    $img = escape($row['room_img']);
    $room_desc = escape($row['room_desc']);
  }


  $query = "INSERT INTO `rooms` (`room_occupancy`, `room_acc`, `room_price`, `room_image`, `room_number`, `room_status`, `room_location`, `room_desc`) VALUES ('$occ', '$room_acc', '$price', '$img', '$room_number', 'Not_booked', 'awash', '$room_desc');";


  $result = mysqli_query($connection, $query);

  confirm($result);
}

if (isset($_POST['entoto_room'])) {
  $room_acc         =  escape($_POST['e_room_acc']);

  $room_number      =  escape($_POST['e_room_number']);

  $acc_query  = "SELECT * FROM entoto_price WHERE name = '$room_acc'";
  $acc_result = mysqli_query($connection, $acc_query);

  confirm($acc_result);

  while ($row = mysqli_fetch_assoc($acc_result)) {
    $occ = escape($row['occupancy']);
    $price = escape($row['double_occ']);
    $img = escape($row['room_img']);
    $room_desc = escape($row['room_desc']);
  }


  $query = "INSERT INTO rooms (room_occupancy, room_acc, room_price, room_image, room_number, room_status, room_location, room_desc) VALUES ('$occ', '$room_acc', '$price', '$img', '$room_number', 'Not_booked', 'entoto', '{$room_desc}');";


  $result = mysqli_query($connection, $query);

  confirm($result);
}

if (isset($_POST['tana_room'])) {
  $room_acc         =  escape($_POST['t_room_acc']);
  $room_number      =  escape($_POST['t_room_number']);

  $acc_query  = "SELECT * FROM tana_price WHERE name = '$room_acc'";
  $acc_result = mysqli_query($connection, $acc_query);

  confirm($acc_result);

  while ($row = mysqli_fetch_assoc($acc_result)) {
    $occ = escape($row['occupancy']);
    $price = escape($row['double_occ']);
    $img = escape($row['room_img']);
    $room_desc = escape($row['room_desc']);
  }


  $query = "INSERT INTO `rooms` (`room_occupancy`, `room_acc`, `room_price`, `room_image`, `room_number`, `room_status`, `room_location`, `room_desc`) VALUES ('$occ', '$room_acc', '$price', '$img', '$room_number', 'Not_booked', 'Lake tana', '$room_desc');";


  $result = mysqli_query($connection, $query);

  confirm($result);
}
?>

<?php

if ($_SESSION['user_role'] == 'SA' || ($_SESSION['user_location'] == 'Boston' && $_SESSION['user_role'] == 'RA')) {

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
    <li class="nav-item">
      <a class="nav-link" id="tana-tab" data-toggle="tab" href="#tana" role="tab" aria-controls="tana" aria-selected="false">Lake Tana</a>
    </li>
  </ul>

  <?php } else {

  if ($_SESSION['user_location'] == 'Bishoftu') { ?>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="bishoftu-tab" data-toggle="tab" href="#bishoftu" role="tab" aria-controls="bishoftu" aria-selected="true">Bishoftu</a>
      </li>
    </ul>
  <?php } else if ($_SESSION['user_location'] == 'Entoto') { ?>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="entoto-tab" data-toggle="tab" href="#entoto" role="tab" aria-controls="entoto" aria-selected="false">Entoto</a>
      </li>
    </ul>
  <?php } else if ($_SESSION['user_location'] == "Awash") { ?>
    <ul class="nav nav-tabs" id="myTab" role="tablist">

      <li class="nav-item">
        <a class="nav-link active" id="awash-tab" data-toggle="tab" href="#awash" role="tab" aria-controls="awash" aria-selected="false">Awash</a>
      </li>
    </ul>
  <?php } else if ($_SESSION['user_location'] == "Lake Tana") { ?>

    <ul class="nav nav-tabs" id="myTab" role="tablist">


      <li class="nav-item">
        <a class="nav-link active" id="tana-tab" data-toggle="tab" href="#tana" role="tab" aria-controls="tana" aria-selected="false">Lake Tana</a>
      </li>
    </ul>

<?php }
} ?>






<div class="tab-content" id="myTabContent">


  <?php

  if ($_SESSION['user_role'] == 'SA' || ($_SESSION['user_location'] == 'Boston' && $_SESSION['user_role'] == 'RA')) {

  ?>

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
          <input type="submit" class="btn btn-primary" name="tana_room" value="Add Room">
        </div>

      </form>
    </div>

    <?php } else {

    if ($_SESSION['user_location'] == 'Bishoftu') { ?>
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
            <input type="submit" class="btn btn-primary" name="bishoftu_room" value="Add Room">
          </div>

        </form>
      </div>
    <?php } else if ($_SESSION['user_location'] == 'Entoto') { ?>
      <div class="tab-pane fade show active" id="entoto" role="tabpanel" aria-labelledby="entoto-tab">
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
            <input type="submit" class="btn btn-primary" name="entoto_room" value="Add Room">
          </div>

        </form>
      </div>
    <?php } else if ($_SESSION['user_location'] == "Awash") { ?>
      <div class="tab-pane fade show active" id="awash" role="tabpanel" aria-labelledby="awash-tab">
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
            <input type="submit" class="btn btn-primary" name="awash_room" value="Add Room">
          </div>

        </form>
      </div>
    <?php } else if ($_SESSION['user_location'] == "Lake Tana") { ?>

      <div class="tab-pane fade show active" id="tana" role="tabpanel" aria-labelledby="tana-tab">
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
            <input type="submit" class="btn btn-primary" name="tana_room" value="Add Room">
          </div>

        </form>
      </div>

  <?php }
  } ?>

</div>
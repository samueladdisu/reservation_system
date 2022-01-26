<?php 

  if(isset($_POST['checkBoxArray'])){

    foreach ($_POST['checkBoxArray'] as $checkBoxValue) {
      
      $bulk_options = $_POST['bulkOption'];

      switch($bulk_options){
        case 'booked':
          $query = "UPDATE rooms SET room_status = '$bulk_options' WHERE room_id = $checkBoxValue";
          $book_result = mysqli_query($connection, $query);
          confirm($book_result);
          break;
        case 'Not_booked':
          $query = "UPDATE rooms SET room_status = '$bulk_options' WHERE room_id = $checkBoxValue";
          $notBook_result = mysqli_query($connection, $query);
          confirm($notBook_result);
          break;
        case 'delete':
          $query = "DELETE FROM rooms WHERE room_id = $checkBoxValue";
          $delete_result = mysqli_query($connection, $query);
          confirm($delete_result);
          break;
      }
    }


  }


?>


<form action="" method="post">
  <table class="table table-bordered table-hover col-12" id="dataTable" width="100%" cellspacing="0">
    <div id="bulkContainer" class="col-6 row mb-3">
      <select name="bulkOption" class="custom-select col-6" id="">
        <option value="">Select option</option>
        <option value="booked">Book</option>
        <option value="Not_booked">Not Book</option>
        <option value="delete">Delete</option>
      </select>

     <div class="col-4">
       <input type="submit" name="submit" class="btn btn-success" value="Apply">

     </div>
    </div>
    <thead>
      <tr>
        <th><input type="checkbox" name="" id="selectAllboxes"></th>
        <th>Id</th>
        <th>Occupancy</th>
        <th>Image</th>
        <th>Accomodation</th>
        <th>Price</th>
        <th>Room Number</th>
        <th>Room Status</th>
        <th>Hotel Location</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>

      <?php

      $location = $_SESSION['user_location'];
      if ($location == "admin") {
        $query = "SELECT * FROM rooms ORDER BY room_id DESC";
      } else {
        $query = "SELECT * FROM rooms WHERE room_location = '$location' ORDER BY room_id DESC";
      }
      $result = mysqli_query($connection, $query);

      while ($row = mysqli_fetch_assoc($result)) {
        $room_id = $row['room_id'];
        $room_occupancy = $row['room_occupancy'];
        $room_acc = $row['room_acc'];
        $room_price = $row['room_price'];
        $room_image = $row['room_image'];
        $room_number = $row['room_number'];
        $room_status = $row['room_status'];
        $room_location = $row['room_location'];
        $room_desc = substr($row['room_desc'], 0, 50);
        echo "<tr>";
      ?>

        <td><input type="checkbox" name="checkBoxArray[]" value="<?php echo $row['room_id'] ?>" class="checkBoxes"></td>
      <?php
        echo "<td>{$room_id}</td>";
        echo "<td>{$room_occupancy}</td>";
        echo "<td><img width='100' src='./room_img/{$room_image}'></td>";
        echo "<td>{$room_acc}</td>";
        echo "<td>{$room_price}</td>";
        echo "<td> $room_number</td>";
        echo "<td> $room_status</td>";
        echo "<td> $room_location</td>";
        echo "<td> $room_desc</td>";
        echo "<td><a href='rooms.php?source=edit_room&p_id=$room_id'>Edit</a></td>";
        echo "<td><a href='rooms.php?delete=$room_id'>Delete</a></td>";
        echo "</tr>";
      }


      ?>

    </tbody>
  </table>

</form>



<?php

if (isset($_GET['delete'])) {
  $the_post_id = escape($_GET['delete']);
  $query = "DELETE FROM rooms WHERE room_id = $the_post_id";
  $result = mysqli_query($connection, $query);

  confirm($result);
  header("Location: ./rooms.php");
}

if(isset($_POST['']))

?>
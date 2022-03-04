<table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">

  <thead>
    <tr>

      <th>Id</th>
      <th>Occupancy</th>
      <th>Accomodation</th>
      <th>Price</th>
      <th>Room Number</th>
      <th>Room Status</th>
      <th>Hotel Location</th>
    </tr>
  </thead>
  <tbody class="insert-data">

    <?php
    include  'config.php';

    $location = 'Awash';
    $checkin = "2022-02-27";
    $checkout = "2022-03-01";

    $A_query = "SELECT *, COUNT(room_acc) AS cnt 
    FROM rooms
    GROUP BY room_acc
    HAVING room_status = 'Not_booked'
    AND room_location = '$location'";

    $A_result = mysqli_query($connection, $A_query);
    confirm($A_result);

    $rows = mysqli_num_rows($A_result);

    
    if (!empty($rows)) {

      
      $all = array();
      $booked_avalibale = array();

      while ($avaliable_rooms = mysqli_fetch_assoc($A_result)) {
        echo "<tr>";
     
        foreach ($avaliable_rooms as  $key => $value) {
          echo "<td>";
          if ($key == 'room_desc') {
            $value = "";
          }
          echo $value;
          echo "</td>";
        }
        echo "</tr>";
      }
     
      $BR_query = "SELECT DISTINCT b_roomId
      FROM booked_rooms 
      WHERE b_checkout<= '$checkin' 
      AND b_roomLocation = '$location'
      UNION
      SELECT DISTINCT b_roomId
      FROM booked_rooms
      WHERE b_checkin >= '$checkout'
      AND b_roomLocation = '$location'";
      $result = mysqli_query($connection, $BR_query);
      confirm($result);

      while($row3 = mysqli_fetch_assoc($result)){
       $r_query = "SELECT *, COUNT(room_acc) AS cnt 
       FROM rooms
       GROUP BY room_acc
       HAVING room_id = {$row3['b_roomId']}";
       $r_result = mysqli_query($connection, $r_query);
       confirm($r_result);

       while($row4 = mysqli_fetch_assoc($r_result)){
        
         
         
      echo "<tr>";
     
      foreach ($row4 as  $key => $value) {
        echo "<td>";
        if ($key == 'room_desc') {
          $value = "";
        }
        echo $value;
        echo "</td>";
      }
      echo "</tr>";
         
        }
      }

      
     

    } else {

      $BR_query = "SELECT DISTINCT b_roomId
      FROM booked_rooms 
      WHERE b_checkout<= '$checkin' 
      AND b_roomLocation = '$location'
      UNION
      SELECT DISTINCT b_roomId
      FROM booked_rooms
      WHERE b_checkin >= '$checkout'
      AND b_roomLocation = '$location'";
      $result = mysqli_query($connection, $BR_query);
      confirm($result);

      $BR_rows = mysqli_num_rows($result);
      if(!empty($BR_rows)){
        while($row1 = mysqli_fetch_assoc($result)){
          $S_query = "SELECT * 
          FROM rooms
          WHERE room_id = {$row1['b_roomId']}";
          $S_result = mysqli_query($connection, $S_query);

          confirm($S_result);

          while($row2 = mysqli_fetch_assoc($S_result)){
            echo "<tr>";
            foreach ($row2 as $key => $value) {
              echo "<td>";
              if ($key == 'room_desc') {
                $value = "";
              }
              echo $value;
              echo "</td>";
            }
            echo "</tr>";
          }


        }
      }
    }





    ?>
  </tbody>
</table>
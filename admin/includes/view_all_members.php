<table class="table table-bordered table-hover col-12" id="dataTable" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th>Id</th>
      <th>Membership Id</th>
      <th>Firstname</th>
      <th>Lastname</th>
      <th>Company Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Date of birth</th>
      <th>Reg. Date</th>
      <th>Exp. Date</th>
      <th>Type</th>
      <th>User name</th>
      <th>Is Activated</th>
    </tr>
  </thead>
  <tbody>
  

    <?php

    $query = "SELECT * FROM members ORDER BY m_id DESC";
    $user_result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($user_result)) {
    
    
      echo "<tr>";
      foreach ($row as $key => $value) {
        if($key == "m_pwd" || $key == "m_validationKey"){
          continue;
        }
        echo "<td>";
        echo $params[$key] = escape($value);
        echo "</td>";
      }

      echo "</tr>";
    }


    ?>

  </tbody>
</table>
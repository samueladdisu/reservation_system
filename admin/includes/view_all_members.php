<table class="table table-bordered table-hover col-12" id="dataTable" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th>Id</th>
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
    </tr>
  </thead>
  <tbody>

    <?php

    $query = "SELECT * FROM members ORDER BY m_id DESC";
    $user_result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($user_result)) {
    

      echo "<tr>";
      foreach ($row as $key => $value) {
        echo "<td>";
        if($key == "m_pwd"){
          continue;
        }
        echo $params[$key] = escape($value);
        echo "</td>";
      }

      echo "</tr>";
    }


    ?>

  </tbody>
</table>

<?php


if (isset($_GET['admin'])) {
  $the_user_id = escape($_GET['admin']);
  $query = "UPDATE users SET user_role = 'Admin' WHERE user_id = $the_user_id";
  $result = mysqli_query($connection, $query);

  confirm($result);
  header("Location: ./users.php");
}

if (isset($_GET['author'])) {
  $the_user_id = escape($_GET['author']);
  $query = "UPDATE users SET user_role = 'Subsciber' WHERE user_id = $the_user_id";
  $result = mysqli_query($connection, $query);

  confirm($result);
  header("Location: ./users.php");
}

if (isset($_GET['delete'])) {
  $the_user_id = escape($_GET['delete']);
  $query = "DELETE FROM users WHERE user_id = $the_user_id";
  $result = mysqli_query($connection, $query);

  confirm($result);
  header("Location: ./users.php");
}
?>
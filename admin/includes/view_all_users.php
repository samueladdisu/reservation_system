<table class="table table-bordered table-hover col-12" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th>Id</th>
      <th>Username</th>
      <th>Firstname</th>
      <th>Lastname</th>
      <th>Property</th>
      <th>Role</th>
    </tr>
  </thead>
  <tbody>

    <?php

    if($_SESSION['user_role'] == 'PA'){
      $query = "SELECT * FROM users WHERE user_location = '{$_SESSION['user_location']}' ORDER BY user_id DESC";

    }else{
      $query = "SELECT * FROM users ORDER BY user_id DESC";
    }
    $user_result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($user_result)) {
      $user_id = $row['user_id'];
      $user_name = $row['user_name'];
      $user_password = $row['user_pwd'];
      $user_firstname = $row['user_firstName'];
      $user_lastname =  $row['user_lastName'];
      $user_location = $row['user_location'];
      $user_role = $row['user_role'];

      
      echo "<tr>";
      echo "<td>{$user_id}</td>";
      echo "<td>{$user_name}</td>";
      echo "<td>{$user_firstname}</td>";
      echo "<td>{$user_lastname}</td>";
      echo "<td>{$user_location}</td>";
      echo "<td>{$user_role}</td>";
      echo "<td><a href='users.php?source=edit_user&edit=$user_id'>Edit</a></td>";
      echo "<td><a href='users.php?delete=$user_id'>Delete</a></td>";
      echo "</tr>";
    }
    ?>

</tbody>
</table>

<?php

if (isset($_GET['delete'])) {
  $the_user_id = escape($_GET['delete']);
  $query = "DELETE FROM users WHERE user_id = $the_user_id";
  $result = mysqli_query($connection, $query);

  confirm($result);
  header("Location: ./users.php");
}
?>
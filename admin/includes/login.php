<?php include  '../includes/db.php'; ?>
<?php include  'functions.php'; ?>
<?php session_start(); ?>

<?php 

  if(isset($_POST['login'])){
    $user_name =  escape($_POST['user_name']);
    $user_password = escape($_POST['user_password']);

    $query = "SELECT * FROM users WHERE user_name = '$user_name' ";
    $select_user = mysqli_query($connection, $query);

    if(!$select_user){
      die("QUERY FAILED ". mysqli_error($connection));
    }

    while($row = mysqli_fetch_assoc($select_user)){
      $db_username = $row['user_name'];
      $db_password = $row['user_pwd'];
      $db_firstname = $row['user_firstName'];
      $db_lastname = $row['user_lastName'];
      $db_role = $row['user_role'];
      $db_location = $row['user_location'];
    }

    if($user_name !== $db_username || $user_password !== $db_password){
      
      header("Location: ../index.php");

     
    }else if($user_name === $db_username && $user_password === $db_password){
     
      $_SESSION['username'] = $db_username;
      $_SESSION['firstname'] = $db_firstname;
      $_SESSION['lastname'] = $db_lastname;
      $_SESSION['user_role'] = $db_role;
      $_SESSION['user_location'] = $db_location;
      header("Location: ../dashboard.php");
    }

  }






?>
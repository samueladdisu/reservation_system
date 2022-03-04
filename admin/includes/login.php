<?php include  '../includes/db.php'; ?>
<?php include  'functions.php'; ?>
<?php session_start(); ?>

<?php 

  if(isset($_POST['login'])){
    $user_name =  escape($_POST['user_name']);
    $user_password = escape($_POST['user_password']);

    $query = "SELECT * FROM users WHERE user_name = '$user_name' ";
    $select_user = mysqli_query($connection, $query);

    confirm($select_user);

    $row = mysqli_num_rows($select_user);

    if(!empty($row)){
      while($data = mysqli_fetch_assoc($select_user)){
        // echo $user_password . "=";
        // echo $data['user_pwd'];
        if(password_verify($user_password,$data['user_pwd'])){
          $_SESSION['username'] = $data['user_name'];
          $_SESSION['firstname'] = $data['user_firstName'];
          $_SESSION['lastname'] = $data['user_lastName'];
          $_SESSION['user_role'] = $data['user_role'];
          $_SESSION['user_location'] = $data['user_location'];
          header("Location: ../dashboard.php");
        }else{
          header("Location: ../index.php");
        }
      }
    }else{
      echo "not";
    }

    

  }






?>
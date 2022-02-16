<?php include  'config.php'; ?>

<?php


if (isset($_GET['eid']) && isset($_GET['token']) && isset($_GET['exd'])) {
  // $validation_key = urldecode(base64_decode($_GET['token']));
  date_default_timezone_set("Africa/Addis_Ababa");
  $current_date = date("Y-m-d H:i:s");
  $email =  urldecode(base64_decode($_GET['eid']));
  $expire =  urldecode(base64_decode($_GET['exd']));
  $validation_key = $_GET['token'];

  if($current_date >= $expire){
    echo "link expired";
  }else {
    
      $query1 = "SELECT * FROM members WHERE m_email = '$email' AND m_validationKey = '$validation_key' AND is_active = 1";
      $result1 = mysqli_query($connection, $query1);
      confirm($result1);
    
      $count = mysqli_num_rows($result1);
    
      if ($count == 1) {
        echo "Email already verified";
      } else {
        $query = "UPDATE members SET is_active = 1 WHERE m_email = '$email' AND m_validationKey = '$validation_key'";
    
        $result = mysqli_query($connection, $query);
    
        confirm($result);
    
        echo "Email verified";
      }

  }
}

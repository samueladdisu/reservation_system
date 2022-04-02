<?php include  'config.php'; ?>
<?php




$recieved = json_decode(file_get_contents("php://input"));

date_default_timezone_set("Africa/Addis_Ababa");


if ($recieved->action == "insert") {
  $formData = $recieved->data;

  // Extract From data
  foreach ($formData as $key => $value) {
    $params[$key] = escape($value);
  }

  $day   = $params['day'];
  $month = $params['month'];
  $year  = $params['year'];

  $email_query = "SELECT * FROM members WHERE m_email = '{$params['email']}'";
  $user_query = "SELECT * FROM members WHERE m_username = '{$params['uName']}'";

  $email_result = mysqli_query($connection, $email_query);
  $user_result = mysqli_query($connection, $user_query);


  confirm($email_result);
  confirm($user_result);

  $email_exists = mysqli_num_rows($email_result);
  $user_exists = mysqli_num_rows($user_result);

  if ($email_exists <= 0) {
    if ($user_exists <= 0) {
      $dob = date('Y-m-d', strtotime($day . $month . $year));

      $query = "SELECT * FROM members";
      $result = mysqli_query($connection, $query);
      $id = mysqli_num_rows($result);
      $formattedNumber = "mekur" . sprintf('%06d', $id + 1);
      $encryptePwd = password_hash($params['pwd'], PASSWORD_BCRYPT, ['cost' => 10]);

      $email = base64_encode(urlencode($params['email']));
      $token =  getToken(32);
      $expire_date = date("Y-m-d H:i:s", time() + 60 * 20);
      $expire_date = base64_encode(urlencode($expire_date));
      $expDate = date("Y-m-d", strtotime("+1 year"));

      // RECIPIENT 
      $mail->addAddress($params['email']);

      $mail->Subject = "Verify your email";
      $mail->Body = "
            <h2> Thank you for sign up</h2>
            <a href='http://localhost/reservation_system/activation.php?eid={$email}&token={$token}&exd={$expire_date}'> Click here to verify</a>
            <p> This link is valid for 20 minutes </p>
    ";
      $mail->send();

      $query = "INSERT INTO members(m_num, m_firstname, m_lastname, m_companyName,m_email, m_phone ,m_dob, m_regDate, m_expDate, m_type, m_username, m_pwd, is_active, m_validationKey) ";
      $query .= "VALUES ('$formattedNumber', '{$params['fName']}', '{$params['lName']}', '{$params['cName']}', '{$params['email']}', '{$params['phone']}', '$dob', now(), '$expDate', '{$params['mType']}', '{$params['uName']}', '$encryptePwd', 0, '$token' )";

      $result = mysqli_query($connection, $query);

      confirm($result);
      echo json_encode("Successful");
    } else {
      echo json_encode("user");
    }
  } else {
    echo json_encode("email");
  }
}


if ($recieved->action == "submit") {

  $login_email = $recieved->email;
  $login_pwd   = $recieved->password;

  $query = "SELECT * FROM members WHERE m_email = '$login_email'";
  $result = mysqli_query($connection, $query);

  confirm($result);

  $row = mysqli_fetch_assoc($result);
  //  echo $row['m_email'];
  if (!empty($row['m_email'])) {
    if (password_verify($login_pwd, $row['m_pwd'])) {
      if ($row['is_active'] == 1) {
        $login = $_SESSION['login'] = "success";
        $_SESSION['m_username'] = $row['m_username'];
        echo json_encode("In");
      } else {
        echo json_encode("V");
      }
    } else {
      echo json_encode("P");
    }
  } else {
    echo json_encode("E");
  }
}

if ($recieved->action == 'verify') {

  if (!isset($_COOKIE['_utt_'])) {
    $ver_email = $recieved->email;
    $ver_pwd   = $recieved->pwd;

    $token =  getToken(32);
    $expire_date = date("Y-m-d H:i:s", time() + 60 * 20);
    $expire_date = base64_encode(urlencode($expire_date));
    $email = base64_encode(urlencode($ver_email));

    // RECIPIENT 
    $mail->addAddress($ver_email);

    $query = "UPDATE members SET m_validationKey = '$token' WHERE m_email = '$ver_email' AND is_active = 0";

    $query_con = mysqli_query($connection, $query);
    confirm($query_con);
    $mail->Subject = "Verify your email";
    $mail->Body = "
          <h2> Follow the link to verify</h2>
          <a href='http://localhost/reservation_system/activation.php?eid={$email}&token={$token}&exd={$expire_date}'> Click here to verify</a>
          <p> This link is valid for 20 minutes </p>";
    if ($mail->send()) {
      setcookie('_utt_', getToken(16), time() + 60 * 20, '', '', '', true);
      echo json_encode("check_email");
    }
  } else {
    echo json_encode("20 min");
  }
}


if ($recieved->action == 'recover') {
  $recover_email = $recieved->email;

  $query = "SELECT * FROM members WHERE m_email = '$recover_email' AND is_active = 1";
  $result = mysqli_query($connection, $query);

  confirm($result);

  if (mysqli_num_rows($result) == 1) {
    if (!isset($_COOKIE['_unp_'])) {
  
      $token =  getToken(32);
      $encode_token = base64_encode(urlencode($token));
      $expire_date = date("Y-m-d H:i:s", time() + 60 * 20);
      $expire_date = base64_encode(urlencode($expire_date));
      $email = base64_encode(urlencode($recover_email));
  
      // RECIPIENT 
      $mail->addAddress($recover_email);
  
      $query = "UPDATE members SET m_validationKey = '$token' WHERE m_email = '$recover_email' AND is_active = 1";
  
      $query_con = mysqli_query($connection, $query);
      confirm($query_con);
      $mail->Subject = "Password reset request";
      $mail->Body = "
            <h2> Follow the link to reset password</h2>
            <a href='http://localhost/reservation_system/new_password.php?eid={$email}&token={$encode_token}&exd={$expire_date}'> Click here to create new password</a>
            <p> This link is valid for 20 minutes </p>";
      if ($mail->send()) {
        setcookie('_unp_', getToken(16), time() + 60 * 20, '', '', '', true);
        echo json_encode("new_pwd");
      }
    } else {
      echo json_encode("20");
    }
  } else {
    echo json_encode('User not found');
  }
}

?>
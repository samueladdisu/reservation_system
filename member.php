<?php include  'config.php'; ?>
<?php require_once  __DIR__.'/vendor/autoload.php' ?>
<?php 
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

$recieved = json_decode(file_get_contents("php://input"));

if($recieved->action == "insert"){
  $formData = $recieved->data;

  date_default_timezone_set("Africa/Addis_Ababa");
  

  foreach ($formData as $key => $value) {
    $params[$key] = escape($value);
  }

  $query = "SELECT * FROM members";
  $result = mysqli_query($connection, $query);
  $id = mysqli_num_rows($result);
  $formattedNumber = "mekur" . sprintf('%06d', $id + 1); 
  $encryptePwd = password_hash($params['pwd'], PASSWORD_BCRYPT, ['cost'=>10]);

  $email = base64_encode(urlencode($params['email']));
  $token =  getToken(32);
  $expire_date = date("Y-m-d H:i:s", time() + 60 * 20);
  $expire_date = base64_encode(urlencode($expire_date));

  $mail = new PHPMailer(true);
  try {
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com";
    $mail->Port = "465";
    $mail->SMTPSecure = "ssl";
  
    $mail->Username = "samueladdisu9@gmail.com";
    $mail->Password = "18424325";
  
    $mail->setFrom("samueladdisu9@gmail.com");
    $mail->addReplyTo("no-reply@samuel.com");
  
    // RECIPIENT 
    $mail->addAddress($params['email']);
    $mail->isHTML();
    $mail->Subject = "Verify your email";
    $mail->Body = "
            <h2> Thank you for sign up</h2>
            <a href='http://localhost/reservation_system/activation.php?eid={$email}&token={$token}&exd={$expire_date}'> Click here to verify</a>
            <p> This link is valid for 20 minutes </p>
    ";
    $mail->send();

    $query = "INSERT INTO members(m_num, m_firstname, m_lastname, m_companyName,m_email, m_phone ,m_dob, m_regDate, m_type, m_username, m_pwd, is_active, m_validationKey) ";
    $query .= "VALUES ('$formattedNumber', '{$params['fName']}', '{$params['lName']}', '{$params['cName']}', '{$params['email']}', '{$params['phone']}', '{$params['dob']}', now(), '{$params['mType']}', '{$params['uName']}', '$encryptePwd', 0, '$token' )";
  
    $result = mysqli_query($connection, $query);
  
    confirm($result);
    echo json_encode("Successful");
  } catch (Exception $d) {
    echo json_encode("Message could not be sent. MailerError: {$mail->ErrorInfo}");
  }
 
 


 

 
  
}





?>
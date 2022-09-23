<?php include  'config.php'; ?>
<?php
// // Import PHPMailer classes into the global namespace
// // These must be at the top of your script, not inside a function
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

// //Load Composer's autoloader
// require 'vendor/autoload.php';

// //Create an instance; passing `true` enables exceptions
// $mail = new PHPMailer(true);

// try {
//     //Server settings
//     $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
//     $mail->isSMTP();                                            //Send using SMTP
//     $mail->Host       = 'smtp.sendgrid.net';                     //Set the SMTP server to send through
//     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
//     $mail->Username   = 'apikey';                     //SMTP username
//     $mail->Password   = $_ENV['SEND_GRID_API_KEY'];                               //SMTP password
//     // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
//     $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

//     //Recipients
//     // $mail->setFrom('from@example.com', 'Mailer');
//     $mail->addAddress('samueladdisu7@gmail.com');     //Add a recipient          //Name is optional
//     // $mail->addReplyTo('info@example.com', 'Information');
//     // $mail->addCC('cc@example.com');
//     // $mail->addBCC('bcc@example.com');
//     //Optional name

//     //Content
//     $mail->isHTML(true);                                  //Set email format to HTML
//     $mail->Subject = 'Here is the subject';
//     $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
//     $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

//     $mail->send();
//     echo 'Message has been sent';
// } catch (Exception $e) {
//     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// }


// require_once('vendor/autoload.php');

// $mailchimp = new MailchimpTransactional\ApiClient();
// $mailchimp->setApiKey('0jnBb2ZNxIOJmrWhV-jQwg');

// $response = $mailchimp->users->ping();
// print_r($response);

 

    // $query = "SELECT r.room_id, r.room_acc, r.room_number, res.res_firstname, g.info_adults, g.info_kids, g.info_teens,b.b_checkin, b.b_checkout, r.room_location
    // FROM rooms AS r
    // LEFT JOIN booked_rooms AS b
    // ON r.room_id = b.b_roomId AND '2022-09-27' BETWEEN b_checkin AND b_checkout
    // LEFT JOIN reservations AS res
    // ON res.res_id = b.b_res_id
    // LEFT JOIN guest_info AS g
    // ON g.info_res_id = b.b_res_id AND g.info_room_id = b.b_roomId";

$data = array();

$query = "SELECT r.room_id, r.room_acc, r.room_number, res.res_firstname, g.info_adults, g.info_kids, g.info_teens,b.b_checkin, b.b_checkout, r.room_location
FROM rooms AS r
LEFT JOIN booked_rooms AS b
ON r.room_id = b.b_roomId AND '2022-09-24' BETWEEN b_checkin AND b_checkout
LEFT JOIN reservations AS res
ON res.res_id = b.b_res_id
LEFT JOIN guest_info AS g
ON g.info_res_id = b.b_res_id AND g.info_room_id = b.b_roomId
WHERE r.room_location = 'awash'";


  $result = mysqli_query($connection, $query);
  // $today = date('Y-m-d');

  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
  }

  // var_dump($data);

  $i = 0;

  while ($i < count($data)) {
    for($j = 0; $j < $i; $j++){
      var_dump($data[$j]);
    }

    $i++;
  }
  







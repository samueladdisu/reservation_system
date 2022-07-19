<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

// //Load Composer's autoloader
// require './vendor/autoload.php';

// //Create an instance; passing `true` enables exceptions
// $mail = new PHPMailer(true);

// try {
//   //Server settings
//   $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
//   $mail->isSMTP();                                            //Send using SMTP
//   $mail->Host       = 'smtp.mandrillapp.com';                     //Set the SMTP server to send through
//   $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
//   $mail->Username   = 'ADDIS UPDATES';                     //SMTP username
//   $mail->Password   = 'G-p-dC0zdEdKMmiIxF-85A';                               //SMTP password
//   // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
//   $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

//   //Recipients
//   $mail->setFrom('no-reply@kurifturesorts.com');
//   // $mail->addAddress('samueladdisu7@gmail.com', 'Joe User');     //Add a recipient
//   $mail->addAddress("samueladdisu7@gmail.com", "Samuel");

//   //Content
//   $mail->isHTML(true);                                  //Set email format to HTML
//   $mail->Subject = 'Here is the subject';
//   $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
//   $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

//   $mail->send();
//   echo 'Message has been sent';
// } catch (Exception $e) {
//   echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// }
require_once('../vendor/mailchimp/MailchimpTransactional/vendor/autoload.php');

$mailchimp = new MailchimpTransactional\ApiClient();
$mailchimp->setApiKey('G-p-dC0zdEdKMmiIxF-85A');

$response = $mailchimp->messages->send(["message" => [
  'subject' => 'Lorem Ipsum',
  'from_email' => 'user@example.com',
  'from_name'  => 'Example User',
  'to'   => 'user@example.com',
  'global_merge_vars' => ['name' => 'Chuck Norris'],
  'track_opens' => true,
  'track_clicks' => true
]]);
print_r($response);

<?php include './includes/admin_header.php'; ?>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include './includes/sidebar.php'; ?>
    <!-- End of Sidebar -->

    // Using Awesome https://github.com/PHPMailer/PHPMailer
    <?php
    require 'PHPMailerAutoload.php';
    require __DIR__ . '/vendor/autoload.php';
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    $mail = new PHPMailer;

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.mailgun.org';                     // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'postmaster@sandboxefb3d4b1bf4046be9baaca591cbd83b4.mailgun.org';   // SMTP username
    $mail->Password = '91aeaef9e6bc9c7b8e27fcc1d6a62510-1b8ced53-bdc68d98';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable encryption, only 'tls' is accepted

    $mail->From = 'YOU@YOUR_DOMAIN_NAME';
    $mail->FromName = 'Mailer';
    $mail->addAddress('bar@example.com');                 // Add a recipient

    $mail->WordWrap = 50;                                 // Set word wrap to 50 characters

    $mail->Subject = 'Hello';
    $mail->Body    = 'Testing some Mailgun awesomness';

    if (!$mail->send()) {
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
      echo 'Message has been sent';
    }
    ?>

  </div>
  <!-- /.container-fluid -->

  </div>
  <!-- End of Main Content -->

  <?php include './includes/admin_footer.php'; ?>
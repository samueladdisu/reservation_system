<?php
ob_start();
session_start();
require  './admin/includes/db.php';
require  './admin/includes/functions.php';
require __DIR__ . '/vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$gmail_pwd = $_ENV['GMAIL_PASSWORD'];

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->Host = "smtp.gmail.com";
$mail->Port = "465";
$mail->SMTPSecure = "ssl";

$mail->Username = "samueladdisu9@gmail.com";
$mail->Password = "$gmail_pwd";

$mail->setFrom("samueladdisu9@gmail.com");
$mail->addReplyTo("no-reply@samuel.com");
$mail->isHTML();
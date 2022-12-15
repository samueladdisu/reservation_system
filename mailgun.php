<?php 


require 'vendor/autoload.php';

use Mailgun\Mailgun;
// First, instantiate the SDK with your API credentials

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo $_ENV['MAILGUN_API_KEY'];
echo $_ENV['MAILGUN_DOMAIN'];

// $mg = Mailgun::create($_ENV['MAILGUN_API_KEY']);

// $mg->messages()->send('reservations.kurifturesorts.com', [
//     'from'    => 'no-reply@kurifturesorts.com',
//     'to'      => 'samueladdisu7@gmail.com',
//     'subject' => 'Kuriftu Resort and Spa',
//     'html'    =>  "<h2>You have succesfully reserved a room</h2>
//     <p> Here is your confirmation code  </p>"
//   ]);
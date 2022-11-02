<?php 


require 'vendor/autoload.php';

use Mailgun\Mailgun;
// First, instantiate the SDK with your API credentials
$mg = Mailgun::create('b7a48d55770182bb0d7500b03764acd2-31eedc68-53c4eb17');

$mg->messages()->send('reservations.kurifturesorts.com', [
    'from'    => 'no-reply@kurifturesorts.com',
    'to'      => 'samueladdisu7@gmail.com',
    'subject' => 'Kuriftu Resort and Spa',
    'html'    =>  "<h2>You have succesfully reserved a room</h2>
    <p> Here is your confirmation code  </p>"
  ]);
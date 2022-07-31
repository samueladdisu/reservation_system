<?php
require __DIR__ . '/vendor/autoload.php';



$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use Mailgun\Mailgun;
// First, instantiate the SDK with your API credentials
$mg = Mailgun::create($_ENV['MAILGUN_API_KEY']);
<?php
ob_start();
session_start();
require  '../admin/includes/db.php';
require  '../admin/includes/functions.php';
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(dirname(__FILE__)));
$dotenv->load();

?>
<?php

$content = $_REQUEST;

// $jsonnofityData = json_decode($content, true);
file_put_contents("Lemlem.txt", $content . PHP_EOL . PHP_EOL, FILE_APPEND);





?>
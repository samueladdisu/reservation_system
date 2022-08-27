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

if (isset($_GET['ref'])) {
    $tx_ref = $_GET['ref'];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.chapa.co/v1/transaction/verify/'. $tx_ref);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


    $headers = array();
    $headers[] = 'Authorization: Bearer '.$_ENV['CHAPA_SECK'];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    $result = json_decode($result);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    file_put_contents("chapa.txt", $result->status . PHP_EOL . PHP_EOL, FILE_APPEND);
}





?>
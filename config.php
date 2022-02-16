<?php 
ob_start(); 
session_start();
require  './admin/includes/db.php';
require  './admin/includes/functions.php';
require __DIR__ . '/vendor/autoload.php';



$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

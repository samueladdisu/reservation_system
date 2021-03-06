<?php ob_start(); ?>
<?php include  'db.php'; ?>
<?php include  'functions.php'; ?>
<?php session_start(); ?>

<?php

if (!isset($_SESSION['user_role'])) {
    header("Location: ./index.php");
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php
            if (isset($currentPage)) {
                echo $currentPage;
            } else {
                echo "Dashboard";
            }
            ?> - Kuriftu Reservation System</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <!-- <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    -->
    <!-- Custom styles for this template-->
    <link rel="shortcut icon" href="../../img/kuriftufavicon.svg" type="image/x-icon">

    <link rel="stylesheet" href="./css/t-datepicker.min.css">
    <link rel="stylesheet" href="./css/themes/t-datepicker-green.css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
</head>
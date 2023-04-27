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
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <style>

    .success_tic .page-body {
      max-width: 300px;
      background-color: #FFFFFF;
      margin: 10% auto;
    }

    .success_tic .page-body .head {
      text-align: center;
    }

    .success_tic .close {
      opacity: 1;
      position: absolute;
      right: 0px;
      font-size: 30px;
      padding: 3px 15px;
      margin-bottom: 10px;
    }

    .success_tic .checkmark-circle {
      width: 150px;
      height: 150px;
      position: relative;
      display: inline-block;
      vertical-align: top;
    }

    .checkmark-circle .background {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      background: #17a673;
      position: absolute;
    }

    .success_tic .checkmark-circle .checkmark {
      border-radius: 5px;
    }

    .success_tic .checkmark-circle .checkmark.draw:after {
      -webkit-animation-delay: 300ms;
      -moz-animation-delay: 300ms;
      animation-delay: 300ms;
      -webkit-animation-duration: 1s;
      -moz-animation-duration: 1s;
      animation-duration: 1s;
      -webkit-animation-timing-function: ease;
      -moz-animation-timing-function: ease;
      animation-timing-function: ease;
      -webkit-animation-name: checkmark;
      -moz-animation-name: checkmark;
      animation-name: checkmark;
      -webkit-transform: scaleX(-1) rotate(135deg);
      -moz-transform: scaleX(-1) rotate(135deg);
      -ms-transform: scaleX(-1) rotate(135deg);
      -o-transform: scaleX(-1) rotate(135deg);
      transform: scaleX(-1) rotate(135deg);
      -webkit-animation-fill-mode: forwards;
      -moz-animation-fill-mode: forwards;
      animation-fill-mode: forwards;
    }

    .success_tic .checkmark-circle .checkmark:after {
      opacity: 1;
      height: 75px;
      width: 37.5px;
      -webkit-transform-origin: left top;
      -moz-transform-origin: left top;
      -ms-transform-origin: left top;
      -o-transform-origin: left top;
      transform-origin: left top;
      border-right: 15px solid #fff;
      border-top: 15px solid #fff;
      border-radius: 2.5px !important;
      content: '';
      left: 35px;
      top: 80px;
      position: absolute;
    }

    @-webkit-keyframes checkmark {
      0% {
        height: 0;
        width: 0;
        opacity: 1;
      }

      20% {
        height: 0;
        width: 37.5px;
        opacity: 1;
      }

      40% {
        height: 75px;
        width: 37.5px;
        opacity: 1;
      }

      100% {
        height: 75px;
        width: 37.5px;
        opacity: 1;
      }
    }

    @-moz-keyframes checkmark {
      0% {
        height: 0;
        width: 0;
        opacity: 1;
      }

      20% {
        height: 0;
        width: 37.5px;
        opacity: 1;
      }

      40% {
        height: 75px;
        width: 37.5px;
        opacity: 1;
      }

      100% {
        height: 75px;
        width: 37.5px;
        opacity: 1;
      }
    }

    @keyframes checkmark {
      0% {
        height: 0;
        width: 0;
        opacity: 1;
      }

      20% {
        height: 0;
        width: 37.5px;
        opacity: 1;
      }

      40% {
        height: 75px;
        width: 37.5px;
        opacity: 1;
      }

      100% {
        height: 75px;
        width: 37.5px;
        opacity: 1;
      }
    }
  </style>
</head>
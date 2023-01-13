<?php ob_start(); ?>
<?php include  '../includes/db.php'; ?>
<?php include  '../includes/functions.php'; ?>
<?php session_start(); ?>

<?php

if (!isset($_SESSION['user_role'])) {
  header("Location: ../index.php");
}else {
  header("Location: index.php");
}



?>
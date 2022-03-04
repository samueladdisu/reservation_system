<?php 
 session_start();
$_SESSION['m_username'] = null;
header("Location: ./reserve.php");
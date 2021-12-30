<?php 


// date

// echo date('d'). "<br>";
// echo date('m'). "<br>";
// echo date('Y'). "<br>";
// echo date('l'). "<br>";
// echo date('m/d/Y'). "<br>";

// time

// echo date('h'). "<br>";
// echo date('i'). "<br>";
// echo date('s'). "<br>";
// echo date('a'). "<br>";

//setTime Zone

date_default_timezone_set("Africa/Addis_Ababa");


// echo date('h:i:sa');

$timestamp = mktime(10,14,54,8,11,1997);
// $timestamp = time();

echo date('m/d/Y',$timestamp);
?>
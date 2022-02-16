<?php

function confirm($result){

    global $connection;
    if(!$result){
        die('QUERY FAILED '. mysqli_error($connection));
      }
}
function escape($string){

    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
  }

function getToken($len) {
  $rand_str = md5(uniqid(mt_rand(), true));
  $base64_encode = base64_encode($rand_str);
  $modified_base64_encode = str_replace(array('+', '='), array('', ''), $base64_encode);
  $token = substr($modified_base64_encode, 0, $len);

  return $token;
}
?>
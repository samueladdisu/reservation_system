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

function calculatePrice($ad, $kid, $teen, $single, $double){

  $price = 0;

  if($ad == 1){
    if($kid == 0 && $teen == 0){
      // Single occupancy
      $price = $single;
    }else if($kid == 1 && $teen == 1){
      $price = $double + 10;
    }else if (($kid == 1 && $teen == 0) || ($kid == 0 && $teen == 1)){
      $price = $double;
    }else if ($kid == 2 && $teen == 0){
      $price = $double + 10;
    }else if ($kid == 0 && $teen == 2){
      $price = $double + 38;
    }
  } else if($ad == 2){
    if($kid == 0 && $teen == 0 ){
      $price = $double;
    } else if($kid == 1 && $teen == 1){
      $price = $double + 48;
    }else if ($kid == 2 && $teen == 0){
      $price = $double + 20;
    }else if ($kid = 0 && $teen == 1){
      $price = $double + 38;
    }
  }

  return $price;

}
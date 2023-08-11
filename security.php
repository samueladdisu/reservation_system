<?php

define('HMAC_SHA256', 'sha256');


function sign($params, $location)
{
  if($location == "Bishoftu"){
    define('SECRET_KEY', $_ENV['SECRET_KEY_BIS']);
  }else{
    define('SECRET_KEY', $_ENV['SECRET_KEY']);
  }
  
  return signData(buildDataToSign($params), SECRET_KEY);
}

function signData($data, $secretKey)
{
  return base64_encode(hash_hmac('sha256', $data, $secretKey, true));
}

function buildDataToSign($params)
{
  $signedFieldNames = explode(",", $params["signed_field_names"]);
  foreach ($signedFieldNames as $field) {
    $dataToSign[] = $field . "=" . $params[$field];
  }
  return commaSeparate($dataToSign);
}

function commaSeparate($dataToSign)
{
  return implode(",", $dataToSign);
}

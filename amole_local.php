<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://uatc.api.myamole.com:8076/amole/pay',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'BODY_CardNumber=0911091185&BODY_ExpirationDate=&BODY_PIN=9999&BODY_PaymentAction=01&BODY_AmountX=200&BODY_AmoleMerchantID=BOSTONP&BODY_OrderDescription=YourTransDescription&BODY_SourceTransID=YourUniqueTransID&BODY_VendorAccount=&BODY_AdditionalInfo1=&BODY_AdditionalInfo2=&BODY_AdditionalInfo3=&BODY_AdditionalInfo4=&BODY_AdditionalInfo5=',
  CURLOPT_HTTPHEADER => array(
    'HDR_Signature: 9zqVsmJkYwBIbaJ7NdA-asfyoP0jiU71BbxRo_ALwiWq4vKa5Jnou4-fgTGBpy9YbrKbEt',
    'HDR_IPAddress: 109.70.148.58',
    'HDR_UserName: Kalkidant',
    'HDR_Password: test',
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

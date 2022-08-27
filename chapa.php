<?php include  'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuriftu Resorts - Chapa</title>
</head>

<body>

    <?php

    $curl = curl_init();
    $price = intval($_SESSION['total']);
    $tx_ref = $_SESSION['Rtemp'];

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.chapa.co/v1/transaction/initialize',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'amount' =>  $price, 
            'key' => $_ENV['CHAPA_PUB'], 
            'currency' => 'ETB',
            'email' => $_SESSION['email'],
            'first_name' => $_SESSION['fName'],
            'last_name' => $_SESSION['lName'],
            'tx_ref' =>  $tx_ref,
            // 'callback_url' => 'https://kurifturesorts.com',
            'callback_url' => 'https://www.test.kurifturesorts.com/chapaCompleted?ref='. $tx_ref
        ),
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer '.$_ENV['CHAPA_SECK']
        ),
      ));

    $response = curl_exec($curl);
    $response = json_decode($response);
    $checkout_url = $response->data->checkout_url;
    curl_close($curl);
    var_dump($response);
    // echo $checkout_url;
    header("Location: $checkout_url");
    ?>

</body>

</html>
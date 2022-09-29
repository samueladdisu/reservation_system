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

  function CurrencyConverter()
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.apilayer.com/exchangerates_data/convert?to=ETB&from=USD&amount=1",
      CURLOPT_HTTPHEADER => array(
        "Content-Type: text/plain",
        "apikey: LTihJp3B4eDMs0JZQE1acsH4y4Iq15oh"
      ),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET"
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $result = json_decode($response, true);

    if ($result['success'] == true) {
      return $result['result'];
    } else {
      return 20;
    }
  }

  function converttoETB($price)
  {
    $todaydate = date('y-m-d');

    global $connection;
    $queryRate = "SELECT * FROM convertusd WHERE rate_id = 1";
    $rate_result = mysqli_query($connection, $queryRate);
    confirm($rate_result);
    $row = mysqli_num_rows($rate_result);
    $rate_find = mysqli_fetch_assoc($rate_result);
    if (strtotime($rate_find['dateUpdated']) == strtotime($todaydate)) {
      return $rate_find['rate'] * $price;
    } else {
      $todayrate = CurrencyConverter();
      $rate_value = round($todayrate, 2);
      $rate_query = "UPDATE convertusd SET dateUpdated = '$todaydate', rate = '$rate_value' WHERE rate_id = 1";
      $rate_result = mysqli_query($connection, $rate_query);
      confirm($rate_result);
      return $price * $rate_value;
    }
  }

  $curl = curl_init();
  $price = intval($_SESSION['total']);
  $tx_ref = $_SESSION['Rtemp'];
  $currency = $_SESSION['currency'];

  if ($currency == 'ETB') {
    $price = converttoETB($price);
  }




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
      'currency' => $currency,
      'email' => $_SESSION['email'],
      'first_name' => $_SESSION['fName'],
      'last_name' => $_SESSION['lName'],
      'tx_ref' =>  $tx_ref,
      'callback_url' => 'http://localhost:8080/reservation_system/chapaCompleted?ref='. $tx_ref,
      'return_url' => 'http://localhost:8080/reservation_system/'
    ),
    CURLOPT_HTTPHEADER => array(
      'Authorization: Bearer ' . $_ENV['CHAPA_SECK']
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
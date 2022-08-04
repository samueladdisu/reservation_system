<?php include  'config.php'; ?>
<?php


header('Content-Type:application/json; charset=utf-8');
$received = json_decode(file_get_contents('php://input'));

function http_post_json($url, $jsonStr)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    array(
      'Content-Type: application/json; charset=utf-8',
      'Content-Length: ' . strlen($jsonStr)
    )
  );
  $response = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  return array($httpCode, $response, $jsonStr);
}


function encryptRSA($data, $public)
{
  $pubPem = chunk_split($public, 64, "\n");
  $pubPem = "-----BEGIN PUBLIC KEY-----\n" . $pubPem . "-----END PUBLIC KEY-----\n";
  $public_key = openssl_pkey_get_public($pubPem);
  if (!$public_key) {
    die('invalid public key');
  }
  $crypto = '';
  foreach (str_split($data, 117) as $chunk) {
    $return = openssl_public_encrypt($chunk, $cryptoItem, $public_key);
    if (!$return) {
      return ('fail');
    }
    $crypto .= $cryptoItem;
  }
  $ussd = base64_encode($crypto);
  return $ussd;
}

function getName($n)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $randomString = '';

  for ($i = 0; $i < $n; $i++) {
    $index = rand(0, strlen($characters) - 1);
    $randomString .= $characters[$index];
  }

  return $randomString;
}


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

function getTime()
{
  $milliseconds = round(microtime(true) / 1000);
  return $milliseconds;
}


if ($received->action == 'submit') {

  echo json_encode(CancelLitsener($received->Money));
}
function cancelLitsener($Money)
{
  $ConvertedMoney = converttoETB($Money);

  $appKey = $_ENV['TELE_APP_KEY'];
  $data = [
    'outTradeNo' => getName(10) . $_SESSION['Rtemp'],
    'subject' => 'Booking',
    // 'totalAmount' => $ConvertedMoney,
    'totalAmount' => 1,
    'shortCode' =>  $_ENV['SHORT_CODE'],
    'notifyUrl' => 'https://reservations.kurifturesorts.com/telebirrCompleted/',
    'returnUrl' => 'https://reservations.kurifturesorts.com/',
    'receiveName' => 'KURIFTU',
    'appId' => $_ENV['TELE_APP_ID'],
    'timeoutExpress' => '30',
    'nonce' => getName(16),
    'timestamp' => getTime()
  ];
  $ussdjson = json_encode($data);
  $publicKey = $_ENV['TELE_PUBLIC_KEY'];
  $ussd = encryptRSA($ussdjson, $publicKey);

  $data['appKey'] = $appKey;
  ksort($data);

  $StringA = '';
  foreach ($data as $k => $v) {
    if ($StringA == '') {
      $StringA = $k . '=' . $v;
    } else {
      $StringA = $StringA . '&' . $k . '=' . $v;
    }
  }
  $StringB = hash("sha256", $StringA);
  $sign = strtoupper($StringB);

  $appId = $_ENV['TELE_APP_ID'];
  $requestMessage = [
    'appid' => $appId,
    'sign' => $sign,
    'ussd' => $ussd
  ];

  $api = "https://app.ethiomobilemoney.et:2121/ammapi/payment/service-openup/toTradeWebPay";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $api);


  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);

  curl_setopt($ch, CURLOPT_POST, TRUE);

  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestMessage));

  curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    array('Content-Type:application/json;charset=utf-8')
  );
  $response = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  list($returnCode, $returnContent) = array($httpCode, $response);

  $a["stringA"] = $StringA;
  $a["ussdjson"] = $ussdjson;
  $a["res"] = $response;
  $a["lastreq"] = json_encode($requestMessage);



  return  $response;
}

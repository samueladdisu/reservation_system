<?php include  'config.php'; ?>
<?php

$content = file_get_contents('php://input');

$publicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEArCSJyX99BiuymBFhLLYp5iOdFgO8I2RK0yE/7W7hVcaS0jjc1aQxor7Q0uuS0ClacRTJUYmT3Hf6RvwwwaClAJ6TSNl5uXPek7RPTmBW59Onh+wc07twto7yUHuGS1IryhyLr0vs5TIf2/kxEsXY4EA3KB3OtmgmGdWvdubb4siXCUS7eD49DFCzmYmXPNeDxBNp5Rczmf+IBtLA3nlyT3EImgWF8CSdQj3UZTlEiOOpfYg5NWwepYrCzwLYxbRc0EoZO6jFr+oYfePlvmXPF8Y+ZEcDDINZxL+Raxsmr5qc2LVJpwyuzHTUZ//mHRRdAohhawdSgNbCVFHlQg53JQIDAQAB';

function returnid(array $CHARS)
{
	$IDfromUID = "";
	for ($x = 10; $x <= sizeof($CHARS); $x++) {
		$IDfromUID .= $CHARS[$x];
	}
	return $IDfromUID;
}

function decryptRSA($source, $key)
{
	$pubPem = chunk_split($key, 64, "\n");
	$pubPem = "-----BEGIN PUBLIC KEY-----\n" . $pubPem . "-----END PUBLIC KEY-----\n";
	$public_key = openssl_pkey_get_public($pubPem);
	if (!$public_key) {
		die('invalid public key');
	}
	$decrypted = ''; //decode must be done before spliting for getting the binary String
	$data = str_split(base64_decode($source), 256);
	foreach ($data as $chunk) {
		$partial = ''; //be sure to match padding
		$decryptionOK = openssl_public_decrypt($chunk, $partial, $public_key, OPENSSL_PKCS1_PADDING);
		if ($decryptionOK === false) {
			die('fail');
		}
		$decrypted .= $partial;
	}
	return $decrypted;
}


$nofityData = decryptRSA($content, $publicKey);
$jsonnofityData = json_decode($nofityData, true);
file_put_contents("Lemlem.txt", $jsonnofityData['outTradeNo'] . PHP_EOL . PHP_EOL, FILE_APPEND);

$tansactionchars = str_split($jsonnofityData['outTradeNo']);
$orderNumber = $jsonnofityData['transactionNo'];
$Amount = $jsonnofityData['totalAmount'];

$userId = returnid($tansactionchars);
file_put_contents("Lemlem1.txt", $userId . PHP_EOL . PHP_EOL, FILE_APPEND);

// $UserInfo = getUserInput($userId);



?>
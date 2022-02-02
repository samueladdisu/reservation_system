<?php

define ('HMAC_SHA256', 'sha256');
define ('SECRET_KEY', '233490d0c7a447459833ad37accb6f3183a5b7ccdf5947bd8a40743b2f5ca657bedd031bacf2411b9c6323816865915c9c44abe1aa384f6b9543a77af3351fe6b82d81905a344448bfc8edf1433da35d83cc324b765c4043a614a0bc3a843baf424d9fafd1b14b6682257e41f2e9231472940b99e0024a5f9f77be88e6cbf3c3');

function sign ($params) {
  return signData(buildDataToSign($params), SECRET_KEY);
}

function signData($data, $secretKey) {
    return base64_encode(hash_hmac('sha256', $data, $secretKey, true));
}

function buildDataToSign($params) {
        $signedFieldNames = explode(",",$params["signed_field_names"]);
        foreach ($signedFieldNames as $field) {
           $dataToSign[] = $field . "=" . $params[$field];
        }
        return commaSeparate($dataToSign);
}

function commaSeparate ($dataToSign) {
    return implode(",",$dataToSign);
}

?>

<?php




$cybsResponse = $_REQUEST;
$Response = json_encode($cybsResponse);
$jsonl = json_decode($Response, true);
$decision = $jsonl["decision"];
$reason = $jsonl["reason_code"];
$orderCode = $jsonl["req_reference_number"];
$reqtransaction_id = $jsonl["req_transaction_uuid"];
$Amount = $jsonl["auth_amount"];
$tansactionchars = str_split($reqtransaction_id);


if ($decision == "ACCEPT" && $reason == "100") {
    echo "HEll ya";
} elseif ($reason == "481") {
    echo "held";
} else {
    echo "operation failed";
}

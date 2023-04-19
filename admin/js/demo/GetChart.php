<?php

// include '../../config/db.php';
$received = json_decode(file_get_contents('php://input'));

if ($received->action === "Chart") {
    echo json_encode("hello");
}

if ($received->action === "DonutChart") {
    echo json_encode("hello pies");
}



if ($received->action === "ChartBAR") {
    echo json_encode("hello");
}




if ($received->action === "ChartShop") {

    echo json_encode("hello");
}

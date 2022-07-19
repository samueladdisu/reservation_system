<?php ob_start(); ?>
<?php include  'db.php'; ?>
<?php include  'functions.php'; ?>
<?php session_start(); ?>


<?php

// Excel file name for download 
$fileName = "KURIFTU-Report-" . date('Ymd') . ".xlsx";

// Headers for download 
header("Content-Disposition: attachment; filename=\"$fileName\"");
header("Content-Type: application/vnd.ms-excel");

// Filter the excel data 
function filterData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}


function GetReservation($ID)
{
    global $connection;
    $query = "SELECT * From products WHERE productId=$ID";;
    $res = mysqli_query($connection, $query);
    $res2 = mysqli_fetch_assoc($res);
    return $res2;
}




if (isset($_POST['report'])) {

    $option = array("First Name", "Last Name", "Phone Number", "email", "Guest Info", "Checkin", "Checkout", "Room Number", "Room Type", "Price", "Location", "Group Name", "Agent", "Promo");
    $optionDB = array("res_firstname", "res_lastname", "res_phone", "res_email", "res_cart", "res_checkin", "res_checkout", "res_roomNo", "res_roomType", "res_price", "res_location", "res_groupName", "res_agent", "res_promo");



    $fields =  $option;

    // Excel file name for download 
    $fileName = "KURIFTU-Report-" . date('Y-m-d') . ".xls";

    // Display column names as first row 
    $excelData = implode("\t", array_values($fields)) . "\n";


    $firstDay =  strtotime($_POST['StartDate']);
    $lastdate =  strtotime($_POST['EndDate']);



    for ($i = $firstDay; $i <= $lastdate; $i = $i + 86400) {
        // $L = intval($i);
        $thisDate = date('Y-m-d', $i); // 2010-05-01, 2010-05-02, et

        $query = "SELECT * FROM reservations WHERE res_checkin = '$thisDate'";


        $res = mysqli_query($connection, $query);
        $lineData2 = [$thisDate];
        if (mysqli_num_rows($res) > 0) {

            // Output each row of the data 
            while ($row = mysqli_fetch_assoc($res)) {
                $lineData = array();

                foreach ($optionDB as $Col) {
                    array_push($lineData, $row[$Col]);
                }



                array_walk($lineData, 'filterData');
                $excelData .= implode("\t", array_values($lineData)) . "\n";
                $lineData = array();
            }
        } else {
        }
    }

    // Headers for download 
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=\"$fileName\"");


    // Render excel data 
    echo $excelData;

    exit;
}







?>
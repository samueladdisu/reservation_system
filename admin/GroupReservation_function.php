<?php include './includes/admin_header.php'; ?>
<?php




if (isset($_POST['submit'])) {
    $WeekdayPrc          = escape($_POST['Weekday_Pricing']);
    $type_location      = escape($_POST['type_location']);
    $BreakFast             = escape($_POST['Breakfast']);
    $ExtraBed             = escape($_POST['Extra_Bed']);
    $weekendPrc     = escape($_POST['Weekend_Pricing']);
    $tea            = escape($_POST['Tea_Break']);
    $Lunch             = escape($_POST['Lunch']);
    $Dinner             = escape($_POST['Dinner']);
    $BBQ             = escape($_POST['BBQ']);
    $range           = escape($_POST['Range']);
    $reason          = escape($_POST['reason']);


    $query = "INSERT INTO group_pricing(group_weekday, group_weeends, 	group_breakfast, group_extrabed, group_lunch, group_tea, group_location, group_range, group_reason, group_BBQ, group_dinner) ";

    $query .= "VALUE ('$WeekdayPrc', '$weekendPrc', '$BreakFast', '$ExtraBed', '$Lunch' , '$tea', '$type_location', '$range', '$reason', '$BBQ', '$Dinner' )";

    $result = mysqli_query($connection, $query);

    confirm($result);
    header('Location: ./Group_AddRoom.php');
}

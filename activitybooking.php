<?php
include 'config.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,POST,OPTIONS,DELETE,PUT");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$received_data = json_decode(file_get_contents("php://input"));

// print_r($received_data->action);

// echo ($received_data->fname);
        // $script = <<< JS
        //     alert("Hello World");
        // JS;

        // $script;
        // echo "<script  type=\"text/javascript\">
        //         alert('Hellow World');
        //         </script>
        //     ";

if ($received_data->action == "waterpark") {
    $fname = $received_data->fname;
    $quantity = $received_data->$quantity;
    $reserve_date = $received_data->$reserve_date;
    echo "Something Found";
    if ($received_data->quantity > 10) {
        echo json_encode("quantity_greater_10");
    } else {
        $date = "12-12-2022";
        $dayofweek = date('w', strtotime($date));
        $result    = date('Y-m-d', strtotime(($day - $dayofweek).' day', strtotime($date)));

        if($result == "Monday" || $result == "Tuesday" || $result == "Wednesday" || $result == "Thursday" || $result == "Friday"){
            $adultPay = ;
            $kidPay = ;
        } else if($result == "Saturday" || $result == "Sunday" ){
            $adultPay = ;
            $kidPay = ;
        }



    }

}

if($received_data->action == "entoto"){

   if($received_data->$quantity > 10){
        echo json_encode("quantity_greater_10");
    }else{
        $date = "12-12-2022";
        $dayofweek = date('w', strtotime($date));
        $result    = date('Y-m-d', strtotime(($day - $dayofweek).' day', strtotime($date)));

        
        if($result == "Monday" || $result == "Tuesday" || $result == "Wednesday" || $result == "Thursday" || $result == "Friday"){
       
        } else if($result == "Saturday" || $result == "Sunday" ){
           
        }

    }
}


?>
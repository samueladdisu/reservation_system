<?php

function confirm($result){

    global $connection;
    if(!$result){
        die('QUERY FAILED '. mysqli_error($connection));
      }
}
function escape($string){

    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
  }

?>
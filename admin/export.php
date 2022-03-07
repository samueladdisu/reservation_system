<?php ob_start(); ?>
<?php session_start(); ?>
<?php include  './includes/db.php'; ?>
<?php include  './includes/functions.php'; ?>

<?php 

  $location = $_SESSION['user_location'];
  $role = $_SESSION['user_role'];
  $data = array();


  if(isset($_GET['report'])){
    $report = $_GET['report'];

    switch ($report) {
      case 'rooms':
        $query = "SELECT * FROM rooms";
        break;
      case 'reservation':
        $query = "SELECT * FROM reservations";
        break;
      case 'members':
        $query = "SELECT * FROM members";
        break;
    }

    $result = mysqli_query($connection, $query);
    confirm($result);

    while($row = mysqli_fetch_assoc($result)){
      $data[] = $row;
    }

    $fileName = $report ."-report-".date('d-m-Y'). ".xls";

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename='. $fileName);

    $heading = false;

    if(!empty($data)){
      foreach ($data as $value) {
        if(!$heading){
          echo implode("\t", array_keys($value)). "\n";
          $heading = true;
        }
        echo implode("\t", array_values($value)) . "\n";
      }
    }
    exit();
  }
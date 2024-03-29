<form action="" method="post">
  <div class="form-group">
    <label for="cat_title">Edit Promo Code</label>
    <?php
    if (isset($_GET['edit'])) {
      $type_id = escape($_GET['edit']);
      $query = "SELECT *, DATE_FORMAT(promo_time, '%Y-%m-%dT%H:%i') AS custom_date FROM promo WHERE promo_id = {$type_id}";
      $result = mysqli_query($connection, $query);

      while ($row = mysqli_fetch_assoc($result)) {
        $promo_code = $row['promo_code'];
        $promo_amount = $row['promo_amount'];
    ?>
 
        <input type="text" value="<?php if (isset($promo_code)) {
                                    echo $promo_code;
                                  } ?>" class="form-control" name="promo_code" id="">
 <label for="type_name">Discount Amount(%)</label>
<input type="text" value="<?php if (isset($promo_amount)) {
                                    echo $promo_amount;
                                  } ?>" class="form-control" name="promo_amount" id="">

<div class="form-group">
    <label for="type_name">Expiration Date</label>
    <input type="datetime-local" value="<?php echo $row['custom_date'] ?>" class="form-control" 
    name="promo_time">
  </div>
  <div class="form-group">
    <label for="type_name">Number of Usage</label>
    <input type="text" class="form-control" value="<?php echo $row['promo_usage'] ?>" name="promo_usage" id="">
  </div>
    <?php }
    }
    ?>

  </div>

 
  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="update_category" value="Update Promo">
  </div>
</form>
<?php
// Update category

if (isset($_POST['update_category'])) {
  $promo_code = escape($_POST['promo_code']);
  $promo_amount = escape($_POST['promo_amount']);
  $promo_time = escape($_POST['promo_time']);
  $promo_usage = escape($_POST['promo_usage']);

  $query = "UPDATE `promo` SET `promo_code` = '$promo_code', `promo_amount` = '$promo_amount', `promo_time` = '$promo_time', `promo_usage` = '$promo_usage'  WHERE `promo`.`promo_id` = $type_id;";
  $update = mysqli_query($connection, $query);

  if (!$update) {
    die('query falied' . mysqli_error($connection));
  } else {
    header("Location: promo.php");
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <script src="https://unpkg.com/vue@next"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <title>Reservation</title>
</head>

<body>
  <div class="container" id="app">
  form action="" class="mb-5 mt-5" method="POST">

<div class="form-group">
  <label for="user_role"> Property </label> <br>
  <select name="destination" class="custom-select" required>
    <option value="">Select Destination</option>
    <option value="Bishoftu">Bishoftu</option>
    <option value="Adama">Adama</option>
    <option value="Entoto">Entoto</option>
    <option value="Lake_Tana">Lake Tana</option>
    <option value="Awash">Awash</option>
    <option value="Boston">Boston</option>
  </select>
</div>

<input type="date" name="check_in" />


<input type="date" name="check_out" />


<input type="submit" name="book" value="book now">
</form>
  </div>


</body>

</html>
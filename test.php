<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
  <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" />

  <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
  <title>test</title>
</head>

<body>

  <input type="text" name="daterange" id="date" value="" />

  <script type="text/javascript">
    let start, end
    // let today = new Date().toISOString().slice(0, 10)
    // const getTomorrow = () =>  new Date.setDate(new Date.getDate() + 1);
    // let tomorrow = getTomorrow()

    // const today = new Date().toISOString().slice(0, 10)
    // const tomorrow = new Date(today)
    // tomorrow.setDate(tomorrow.getDate() + 1)
    // console.log(today)
    // console.log(tomorrow)

    var today = new Date();
    const dd = String(today.getDate()).padStart(2, '0');
    const mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    const yyyy = today.getFullYear();

    let tomorrow = new Date(today)
    tomorrow.setDate(tomorrow.getDate() + 1)

    tomorrow = new Date(new Date().getTime() + 24 * 60 * 60 * 1000)
    const td = String(tomorrow.getDate()).padStart(2, '0');
    const tm = String(tomorrow.getMonth() + 1).padStart(2, '0'); //January is 0!
    const ty = tomorrow.getFullYear();

    today = mm + '/' + dd + '/' + yyyy;
    tomorrow = tm + '/' + td + '/' + ty;
    console.log(today)
    console.log(tomorrow)

    $('#date').daterangepicker();
    $('#date').data('daterangepicker').setStartDate(today);
    $('#date').data('daterangepicker').setEndDate(tomorrow);
  </script>
</body>

</html>
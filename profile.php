<?php include  'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

  <link rel="stylesheet" href="./css/style.css">

  <title>Profile - Kuriftu Resorts</title>
</head>

<body>
  <?php

  if (isset($_SESSION['m_username'])) {
    $user_name =  $_SESSION['m_username'];
  } else {
    $user_name = null;
  }

  ?>
  <header class="p-header">
    <div class="container">
      <nav class="nav-center">
        <div class="menu">
          <div class="line1"></div>
          <div class="line2"></div>
        </div>
        <div class="logo">
          <img src="./img/black_logo.svg" alt="">
        </div>
      </nav>
    </div>
  </header>

  <div class="jambotron">
    <div class="container">
      <div class="left">



        <h1> Welcome Back,<?php

                          echo $_SESSION['m_username'];

                          ?> </h1>
        <p> Member ship Id mekur000001 </p>
      </div>

      <div class="right">
        <div class="member-info">
          <div class="tier">
            <h1 class="tier-title"> Gold </h1>
            <p> current tier </p>
          </div>

          <div class="nights">
            <h1 class="nights-title">12</h1>
            <p>nights stayed</p>
          </div>
        </div>
      </div>

    </div>
  </div>


  <div class="container" id="app">

    <h3 class="activity">Activity</h3>

    <div class="profile-cards">
      <div class="profile-card">
        <h4 class="profile-header">
          Entoto
        </h4>
        <div class="date">
          <div class="from-date">
            <p class="date-title">From</p>
            <p>2022-02-24</p>
          </div>
          <div class="to-date">
            <p class="date-title">To</p>
            <p>2022-02-28</p>
          </div>
        </div>
      </div>

      <div class="profile-card">
        <h4 class="profile-header">
          Bishoftu
        </h4>
        <div class="date">
          <div class="from-date">
            <p class="date-title">From</p>
            <p>2022-02-24</p>
          </div>
          <div class="to-date">
            <p class="date-title">To</p>
            <p>2022-02-28</p>
          </div>
        </div>
      </div>

      <div class="profile-card">
        <h4 class="profile-header">
          Entoto
        </h4>
        <div class="date">
          <div class="from-date">
            <p class="date-title">From</p>
            <p>2022-02-24</p>
          </div>
          <div class="to-date">
            <p class="date-title">To</p>
            <p>2022-02-28</p>
          </div>
        </div>
      </div>

      <div class="profile-card">
        <h4 class="profile-header">
          Bishoftu
        </h4>
        <div class="date">
          <div class="from-date">
            <p class="date-title">From</p>
            <p>2022-02-24</p>
          </div>
          <div class="to-date">
            <p class="date-title">To</p>
            <p>2022-02-28</p>
          </div>
        </div>
      </div>
    </div>

    <?php

    // $query = "SELECT res_checkin, res_checkout, res_location
    //           FROM reservation
    //           WHERE res_member = '$user_name'";
    // $result = mysqli_query($connection , $query);

    // while($row = mysqli_fetch_assoc($result)){

    // }




    ?>



  </div>


  <?php include_once './includes/footer.php' ?>
  <script>
    const app = Vue.createApp({

    })

    // app.mount('#app')
  </script>
</body>

</html>
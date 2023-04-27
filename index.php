<?php

include  'config.php';

if (isset($_GET['ref'])) {
    date_default_timezone_set("Africa/Addis_Ababa");
    $ref = $_GET['ref'];

    $clicked_at = date('Y-m-d H:i:s');

    $query = "INSERT INTO visitors(source, clicked_at) VALUES('$ref', '$clicked_at')";
    $result = mysqli_query($connection, $query);
    confirm($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
   
    <title>Kuriftu - Reservation</title>
</head>
<body>
    <header class="reserve-header">
        <nav class="nav-center">

            <div class="logo">
                <img src="./img/black_logo.svg" alt="">
            </div>
            <div class="line">
                <div class="container1">
                    <hr class="line1">
                    <ul class="justify-list">

                        <li>
                            <a class="link-text" href="">Back to Home Page</a>
                        </li>
                        <li>
                            <a class="link-text" href="./signUp.php">Sign Up</a>
                        </li>
                        <li>
                            <a class="link-text" href="./signIn.php">Login</a>
                        </li>
                    </ul>
                    <hr class="line2">
                </div>
            </div>
        </nav>
    </header>

    <section class="Destinations-list">
        <div class="container">
            <h2>Select a Resort</h2>
            <div class="wrapper">

                <div class="single-destination">
                    <img src="./img/awash-cover.webp" alt="">
                    <div class="desc">
                        <div class="desc-wrapper">
                            <h4>Kuriftu Resort & Spa Awash Falls</h4>
                            <p class="location-txt">Awash, Ethiopia </p>

                            <div class="sep-line">
                                <hr class="line3">
                            </div>
                            <div class="details">
                                <p class="text-detail">From<b class="bigger"> $250</b>
                                    <br>Per Night <br>Including Taxes & Fees
                                </p>
                                </p>
                                <a href="./reserve.php?location=awash"> <button class="btn btn-black btn-detail">View Rooms </button></a>

                                <!-- <a href="#"> <button class="btn btn-outline-black btn-detail" disabled>Unavaliable Now </button></a> -->
                            </div>
                        </div>

                    </div>

                </div>
                <div class="single-destination">
                    <img src="./img/2.webp" alt="">
                    <div class="desc">
                        <div class="desc-wrapper">
                            <h4>Kuriftu Resort & Spa Bishoftu</h4>
                            <p class="location-txt">Bishoftu, Ethiopia </p>

                            <div class="sep-line">
                                <hr class="line3">
                            </div>
                            <div class="details">
                                <p class="text-detail">From<b class="bigger"> $150</b>
                                    <br>Per Night<br>Including Taxes & Fees
                                </p>
                                </p>
                                <a href="./reserve.php?location=bishoftu"> <button class="btn btn-black btn-detail">View Rooms </button></a>

                                <!-- <a href="#"> <button class="btn btn-outline-black btn-detail" disabled>Unavaliable Now </button></a> -->
                            </div>
                        </div>

                    </div>

                </div>
                <div class="single-destination">
                    <img src="./img/Glamping.webp" alt="">
                    <div class="desc">
                        <div class="desc-wrapper">
                            <h4>Kuriftu Resort & Spa Entoto</h4>
                            <p class="location-txt">Addis Ababa, Ethiopia </p>

                            <div class="sep-line">
                                <hr class="line3">
                            </div>
                            <div class="details">
                                <p class="text-detail">From<b class="bigger"> $300</b>
                                    <br>Per Night<br>Including Taxes & Fees
                                </p>
                                </p>
                                <a href="./reserve.php?location=entoto"> <button class="btn btn-black btn-detail">View Rooms </button></a>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="single-destination">
                    <img src="./img/Tana.webp" alt="">
                    <div class="desc">
                        <div class="desc-wrapper">
                            <h4>Kuriftu Resort & Spa Lake Tana</h4>
                            <p class="location-txt">Bahirdar, Ethiopia </p>

                            <div class="sep-line">
                                <hr class="line3">
                            </div>
                            <div class="details">
                                <p class="text-detail">From<b class="bigger"> $300</b>
                                    <br>Per Night<br>Including Taxes & Fees
                                </p>
                                </p>
                                <!-- <a href="./reserve.php?location=Tana"> <button class="btn btn-black btn-detail">View Rooms </button></a> -->

                                <a href="#"> <button class="btn btn-outline-black btn-detail" disabled>Unavaliable Now </button></a>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </section>


    <!-- <section class="Destinations-list">
        <div class="container" style="display: grid; place-items: center; height: 60vh">
            <h2>
                Page Under Construction
            </h2>

        </div>

    </section> -->
    <footer>
        <div class="container">
            <img src="./img/black_logo.svg" alt="">
            <p>All Copyright &copy; 2022 Kuriftu Resort and Spa. Powered by <a href="https://versavvymedia.com/" target="_blank">Versavvy</a></p>
        </div>

    </footer>

<<<<<<< HEAD
    <script>
        esk('track', 'Conversion');
    </script>
=======
>>>>>>> f2b5d03ed0a603ccd63b9a431d7d00cbfbe452d8

</body>

</html>
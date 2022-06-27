<?php include  'config.php'; ?>
<?php include 'security.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/vue@3.0.2"></script>
    <title>Document</title>
</head>

<body>

    <header class="header">
        <div class="container">
            <nav class="nav-center">
                <div class="menu">
                    <div class="line1"></div>
                    <div class="line2"></div>
                </div>
                <div class="logo">
                    <img src="./img/Kuriftu_logo.svg" alt="">
                </div>
            </nav>

            <div class="side-socials">
                <img src="./img/facebook.svg" alt="">
                <img src="./img/instagram.svg" alt="">
                <img src="./img/youtube.svg" alt="">
            </div>

        </div>
    </header>

    <div id="formApp">
        <div class="container cart-container">
            <div class="cart w-50">
                <?php

                $cart = $_SESSION['cart'];
                // print_r($cart);
                foreach ($cart as $name => $value) {

                    $item[$name] = $value;
                    foreach ($item[$name] as $name1 => $val) {


                        $items[$name1] = $val;
                    } ?>
                    <div class="upper">
                        <h3><?php echo $items['room_acc']; ?> -
                            <?php echo $items['room_location']; ?></h3>
                        <p class="text-muted">
                            $<?php echo $items['room_price']; ?>
                        </p>
                    </div>


                    <div class="lower">
                        <p class="text-muted">
                            <!-- {{ guests }} -->
                        </p>


                    </div>
                <?php }
                ?>



                <div class="cart-footer-lg">



                    <div class="price">
                        Total: $<?php echo $_SESSION['total']; ?> <br>
                        Rooms: <?php echo $_SESSION['rooms']; ?>
                    </div>
                </div>
            </div>

            <button class="ConfirmBtn" type="submit" id="submit" name="submit" value="Submit">Confirm Order</button>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.0/axios.min.js"></script>
            <!-- <script src="./telebirr.js"></script> -->


            <!-- <form action="payment_confirmation.php" method="post"> -->

            <?php
            $cart = $_SESSION['cart'];
            $total_price = $_SESSION['total'];
 
            $quantity = 1;
            $item_name = 1;
            $item_number = 1;
            $amount = 1;






            ?>
            <script type="text/javascript">
                const SubmitPay = document.querySelector('#submit')
                SubmitPay.addEventListener('click', async e => {
                    e.preventDefault();
                    await axios.post('TeleSubmit.php', {
                        action: 'submit',
                        Money: <?php echo $total_price;  ?>
                    }).then(res => {
                        console.log(res.data)
                        let respo = JSON.parse(res.data)
                        console.log(respo.data.toPayUrl)
                        window.location.href = respo.data.toPayUrl




                    })
                })
            </script>


        </div>







    </div>

    <?php include_once './includes/footer.php' ?>
</body>

</html>
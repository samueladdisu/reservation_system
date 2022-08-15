<?php include  'config.php'; ?>
<?php require_once  __DIR__ . '/vendor/autoload.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Sign Up - Kuriftu Resorts</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <header class="header reserve-header">
        <div class="container">
            <nav class="nav-center">

                <div class="logo">
                    <img src="./img/black_logo.svg" alt="">
                </div>
                <div class="line">
                    <div class="container1">
                        <hr class="line1">
                        <ul class="justify-list">

                            <li>
                                <a class="link-text" href="./">Back to Resorts</a>
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


                <?php

                if (isset($_SESSION['m_username'])) {
                    $user_name =  $_SESSION['m_username'];
                ?>
                    <div class="profile">
                        <div @click="showDropdown" class="profile-icon">
                            <h1 class="profile-name">
                                SA
                            </h1>

                        </div>

                        <div v-if="dropdown" class="drop-down">
                            <ul>
                                <li><a href="./profile.php"> <i class="fa-solid fa-user"></i> Profile</a></li>
                                <li> <a href="./logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log out</a></li>
                            </ul>
                        </div>
                    </div>

                <?php
                } else {
                    $user_name = null;
                ?>



                <?php
                }

                ?>


            </nav>



        </div>
    </header>

    <section class="main-body">
        <h1 class="caps text-center">Become a member </h1>
        <div class="container" id="form-wiget">

            <form @submit.prevent="submitForm" class="signup-form">
                <div class="form-group">

                    <div class="inner-form">
                        <label class="label">First Name</label>
                        <input type="text" placeholder="First Name" v-model="form.fName" required>
                        <!-- <p>{{ fNError }}</p> -->

                    </div>

                    <div class="inner-form">
                        <label class="label">Last Name</label>
                        <input type="text" placeholder="Last Name" v-model="form.lName" required>
                        <p></p>
                    </div>



                </div>

                <div class="form-group">
                    <div class="inner-form">
                        <label class="label">Email</label>
                        <input type="email" placeholder="Email" v-model="form.email" required>
                        <!-- <p>{{ emailError }}</p> -->
                    </div>
                    <div class="inner-form">
                        <label class="label">Phone</label>
                        <input type="text" placeholder="Phone" v-model="form.phone" required>

                    </div>


                </div>

                <div class="form-group">
                    <div class="inner-form">
                        <!-- <input type="date" v-model="form.dob" required> -->

                        <label class="label">Date of Birth</label>
                        <br>
                        <div class="dob-cont">

                            <select name="day" v-model="form.day" class="dob">
                                <option value="">Day</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                                <option value="31">31</option>
                            </select>

                            <select name="month" v-model="form.month" class="dob">
                                <option value="">Month</option>
                                <option value="Jan">January</option>
                                <option value="Feb">February</option>
                                <option value="Mar">March</option>
                                <option value="Apr">April</option>
                                <option value="May">May</option>
                                <option value="Jun">June</option>
                                <option value="Jul">July</option>
                                <option value="Aug">August</option>
                                <option value="Sep">September</option>
                                <option value="Oct">October</option>
                                <option value="Nov">November</option>
                                <option value="Dec">December</option>
                            </select>

                            <select name="year" v-model="form.year" class="dob">
                                <option value="">Year</option>
                                <option value="2015">2015</option>
                                <option value="2014">2014</option>
                                <option value="2013">2013</option>
                                <option value="2012">2012</option>
                                <option value="2011">2011</option>
                                <option value="2010">2010</option>
                                <option value="2009">2009</option>
                                <option value="2008">2008</option>
                                <option value="2007">2007</option>
                                <option value="2006">2006</option>
                                <option value="2005">2005</option>
                                <option value="2004">2004</option>
                                <option value="2003">2003</option>
                                <option value="2002">2002</option>
                                <option value="2001">2001</option>
                                <option value="2000">2000</option>
                                <option value="1999">1999</option>
                                <option value="1998">1998</option>
                                <option value="1997">1997</option>
                                <option value="1996">1996</option>
                                <option value="1995">1995</option>
                                <option value="1994">1994</option>
                                <option value="1993">1993</option>
                                <option value="1992">1992</option>
                                <option value="1991">1991</option>
                                <option value="1990">1990</option>
                                <option value="1989">1989</option>
                                <option value="1988">1988</option>
                                <option value="1987">1987</option>
                                <option value="1986">1986</option>
                                <option value="1985">1985</option>
                                <option value="1984">1984</option>
                                <option value="1983">1983</option>
                                <option value="1982">1982</option>
                                <option value="1981">1981</option>
                                <option value="1980">1980</option>
                                <option value="1979">1979</option>
                                <option value="1978">1978</option>
                                <option value="1977">1977</option>
                                <option value="1976">1976</option>
                                <option value="1975">1975</option>
                                <option value="1974">1974</option>
                                <option value="1973">1973</option>
                                <option value="1972">1972</option>
                                <option value="1971">1971</option>
                                <option value="1970">1970</option>
                                <option value="1969">1969</option>
                                <option value="1968">1968</option>
                                <option value="1967">1967</option>
                                <option value="1966">1966</option>
                                <option value="1965">1965</option>
                                <option value="1964">1964</option>
                                <option value="1963">1963</option>
                                <option value="1962">1962</option>
                                <option value="1961">1961</option>
                                <option value="1960">1960</option>
                                <option value="1959">1959</option>
                                <option value="1958">1958</option>
                                <option value="1957">1957</option>
                                <option value="1956">1956</option>
                                <option value="1955">1955</option>
                                <option value="1954">1954</option>
                                <option value="1953">1953</option>
                                <option value="1952">1952</option>
                                <option value="1951">1951</option>
                                <option value="1950">1950</option>
                                <option value="1949">1949</option>
                                <option value="1948">1948</option>
                                <option value="1947">1947</option>
                                <option value="1946">1946</option>
                                <option value="1945">1945</option>
                                <option value="1944">1944</option>
                                <option value="1943">1943</option>
                                <option value="1942">1942</option>
                                <option value="1941">1941</option>
                                <option value="1940">1940</option>
                                <option value="1939">1939</option>
                                <option value="1938">1938</option>
                                <option value="1937">1937</option>
                                <option value="1936">1936</option>
                                <option value="1935">1935</option>
                                <option value="1934">1934</option>
                                <option value="1933">1933</option>
                                <option value="1932">1932</option>
                                <option value="1931">1931</option>
                                <option value="1930">1930</option>
                            </select>
                        </div>

                    </div>
                    <div class="inner-form">
                        <label class="label">Membership Type</label>
                        <select v-model="form.mType" required>
                            <option disabled value="">Choose Membership Type</option>
                            <option value="vip">VIP</option>
                            <option value="normal"> Normal</option>
                        </select>
                    </div>

                </div>

                <div class="form-group">
                    <div class="inner-form">
                        <label class="label">User Name</label>
                        <input type="text" placeholder="User Name" v-model="form.uName" required>
                        <!-- <p>User name is required!</p> -->
                    </div>
                    <div class="inner-form">
                        <label class="label">Company Name</label>
                        <input type="text" placeholder="Company Name" v-model="form.cName">
                        <p></p>
                    </div>


                </div>


                <div class="form-group">
                    <div class="inner-form">
                        <label class="label">Password</label>
                        <div class="input-container">
                            <img src="./img/view.svg" @click="showPwd" alt="">
                            <input type="password" ref="pwd" placeholder="Password" v-model="form.pwd" @blur="checkPwd">
                        </div>
                        <p v-if="pwdError">{{ pwdError }}</p>
                    </div>
                    <div class="inner-form">
                        <label class="label">Confirm Password</label>
                        <div class="input-container">
                            <img src="./img/view.svg" alt="">
                            <input type="password" placeholder="Confirm Password" ref="cPwd" v-model="cPwd" @blur="confirmPwd" required>
                        </div>
                        <p>{{ cPwdError }}</p>
                    </div>

                </div>

                <button class="btn btn-secondary" data-bs-toggle="modal" :data-bs-target="modal">
                    Sign Up
                </button>
                <p class="bottom-form">
                    Already have an account? <a href="https://reservations.kurifturesorts.com/signIn.php">Sign in</a>
                </p>

            </form>



            <!-- Modal -->
            <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Sign up Successful Please Verify Your email
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="container">
            <img src="./img/black_logo.svg" alt="">
            <p>All Copyright &copy; 2022 Kuriftu Resort and Spa. Powered by <a href="https://versavvymedia.com/" target="_blank">Versavvy</a></p>
        </div>

    </footer>
    <?php include_once './includes/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/signup.js" type="module"></script>
</body>

</html>
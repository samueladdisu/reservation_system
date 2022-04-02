<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$gmail_pwd = $_ENV['GMAIL_PASSWORD'];

if (isset($_POST['create_member'])) {



  foreach ($_POST as $key => $value) {
    $form[$key] = $value;
  }

  $dob =  date("Y-m-d", strtotime($form['day']. $form['month']. $form['year']));

  $m_query = "SELECT * FROM members";
  $m_result = mysqli_query($connection, $m_query);
  confirm($m_result);


  while ($row = mysqli_fetch_assoc($m_result)) {
    if ($form['m_email'] === $row['m_email']) {
      $email = $row['m_email'];
      break;
    }

    if ($form['m_username'] === $row['m_username']) {
      $username = $row['m_username'];
    }
  }

  if (!$email) {
    if (!$username) {
      $id = mysqli_num_rows($m_result);
      $formattedNumber = "mekur" . sprintf('%06d', $id + 1);
      $encryptePwd = password_hash($form['m_pwd'], PASSWORD_BCRYPT, ['cost' => 10]);

      date_default_timezone_set("Africa/Addis_Ababa");

      $regDate = date("Y-m-d", strtotime("today"));
      $expDate = date("Y-m-d", strtotime("+1 year"));


      $query = "INSERT INTO members(m_num, m_firstname, m_lastname, m_companyName, m_email, m_phone, m_dob, m_regDate, m_expDate, m_type, m_username, m_pwd, is_active) VALUES('$formattedNumber', '{$form['m_firstname']}', '{$form['m_lastname']}', '{$form['m_companyName']}', '{$form['m_email']}', '{$form['m_phone']}', '$dob', '$regDate', '$expDate', '{$form['m_type']}', '{$form['m_username']}', '$encryptePwd', 1)";
      $result = mysqli_query($connection, $query);
      confirm($result);

      $mail = new PHPMailer(true);

      try {
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.gmail.com";
        $mail->Port = "465";
        $mail->SMTPSecure = "ssl";

        $mail->Username = "samueladdisu9@gmail.com";
        $mail->Password = "$gmail_pwd";

        $mail->setFrom("samueladdisu9@gmail.com");
        $mail->addReplyTo("no-reply@samuel.com");

        // RECIPIENT 
        $mail->addAddress($form['m_email']);
        $mail->isHTML();
        $mail->Subject = "Verify your email";
        $mail->Body = "
                <h2> Thank you for sign up</h2>
                <h3> below your credentials make sure you changed your password </h3>
                <p>User name:  {$form['m_username']}</p>
                <p>Password:  {$form['m_pwd']}</p>
        ";
        $mail->send();
      } catch (Exception $d) {
        echo "Message could not be sent. Mailer Error: $mail->ErrorInfo";
      }

      header("Location: members.php");
    } else {
      echo "<script> alert('User Name already exists')</script>";

      // header("Refresh: 0");
    }
  } else {
    echo "<script> alert('Email already exists')</script>";

    // header("Refresh: 0");
  }
}



?>





<form action="" method="POST" class="col-10 row" enctype="multipart/form-data">


  <div class="form-group col-6">
    <label> First Name*</label>
    <input type="text" class="form-control" value="<?php echo isset($form['m_firstname']) ? $form['m_firstname'] : "";  ?>" name="m_firstname" >
  </div>

  <div class="form-group col-6">
    <label> Last Name*</label>
    <input type="text" class="form-control" value="<?php echo isset($form['m_lastname']) ? $form['m_lastname'] : "";  ?>" name="m_lastname">
  </div>

  <div class="form-group col-6">
    <label> Company Name</label>
    <input type="text" class="form-control" value="<?php echo isset($form['m_companyName']) ? $form['m_companyName'] : "";  ?>" name="m_companyName">
  </div>

  <div class="form-group col-6">
    <label for="post_status">Email*</label>
    <input type="text" class="form-control" value="<?php echo isset($form['m_email']) ? $form['m_email'] : "";  ?>" name="m_email" >
  </div>

  <div class="form-group col-6">
    <label for="post_status">Phone*</label>
    <input type="text" class="form-control" value="<?php echo isset($form['m_phone']) ? $form['m_phone'] : "";  ?>" name="m_phone" >
  </div>

  <div class="form-group col-6">
    <label for="post_status">Date of Birth*</label>
    <div class="form-group row">
      <select name="day" class="custom-select ml-2 col-3">
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

      <select name="month" class="custom-select ml-2 col-3">
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

      <select name="year" class="custom-select ml-2 col-3">
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

  <div class="form-group col-6">
    <label for="post_status">Member Ship Type*</label>
    <select name="m_type" value="<?php echo isset($form['m_type']) ? $form['m_type'] : "";  ?>" class="custom-select" id="">
      <option value="normal">Normal</option>
      <option value="vip">VIP</option>

    </select>
  </div>
  <div class="form-group col-6">
    <label for="post_status"> User Name*</label>
    <input type="text" class="form-control" value="<?php echo isset($form['m_username']) ? $form['m_username'] : "";  ?>" name="m_username">
  </div>



  <div class="form-group col-6">
    <label for="post_tags"> Password*</label>
    <input type="password" class="form-control" name="m_pwd">
  </div>

  <div class="form-group col-6">
    <label for="post_tags">Confirm Password*</label>
    <input type="password" class="form-control" name="m_">
  </div>
  <div class="form-group col-6">
    <input type="submit" class="btn btn-primary" name="create_member" value="Add User">
  </div>
</form>
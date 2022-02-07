<?php include  'config.php'; ?>
<?php 

$recieved = json_decode(file_get_contents("php://input"));

if($recieved->action == "insert"){
  $formData = $recieved->data;

 

  foreach ($formData as $key => $value) {
    $params[$key] = escape($value);
  }

  $query = "SELECT * FROM members";
  $result = mysqli_query($connection, $query);
  $id = mysqli_num_rows($result);
  $formattedNumber = "mekur" . sprintf('%06d', $id + 1); 
  $encryptePwd = password_hash($params['pwd'], PASSWORD_BCRYPT, ['cost'=>10]);

  $query = "INSERT INTO members(m_num, m_firstname, m_lastname, m_companyName,m_email, m_phone ,m_dob, m_regDate, m_type, m_username, m_pwd) ";
  $query .= "VALUES ('$formattedNumber', '{$params['fName']}', '{$params['lName']}', '{$params['cName']}', '{$params['email']}', '{$params['phone']}', '{$params['dob']}', now(), '{$params['mType']}', '{$params['uName']}', '$encryptePwd' )";

  $result = mysqli_query($connection, $query);

  confirm($result);
 

  echo json_encode($params);
  
}





?>
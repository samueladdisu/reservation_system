<?php
if (isset($_POST['create_member'])) {
  
}



?>





<form action="" method="POST" class="col-10 row" enctype="multipart/form-data">


  <div class="form-group col-6">
    <label> First Name*</label>
    <input type="text" class="form-control" name="m_firstname" required>
  </div>

  <div class="form-group col-6">
    <label> Last Name*</label>
    <input type="text" class="form-control" name="m_lastname">
  </div>
 
  <div class="form-group col-6">
    <label> Company Name</label>
    <input type="text" class="form-control" name="m_companyName">
  </div>

  <div class="form-group col-6">
    <label for="post_status">Email*</label>
    <input type="text" class="form-control" name="m_email" required>
  </div>

  <div class="form-group col-6">
    <label for="post_status">Phone*</label>
    <input type="text" class="form-control" name="m_phone" required>
  </div>

  <div class="form-group col-6">
    <label for="post_status">Date of Birth*</label>
    <input type="date" class="form-control" name="m_dob" required>
  </div>

  <div class="form-group col-6">
    <label for="post_status">Member Ship Type*</label>
    <select name="m_type" class="custom-select" id="">
      <option value="normal">Normal</option>
      <option value="vip">VIP</option>

    </select>
  </div>
  <div class="form-group col-6">
    <label for="post_status"> User Name*</label>
    <input type="text" v-model="uname" class="form-control" name="m_username">
  </div>

 

  <div class="form-group col-6">
    <label for="post_tags"> Password*</label>
    <input type="password" class="form-control" name="m_pwd">
  </div>

  <div class="form-group col-6">
    <label for="post_tags">Confirm Password*</label>
    <input type="password" class="form-control" name="m_cpwd">
  </div>
  <div class="form-group col-6">
    <input type="submit" class="btn btn-primary" name="create_member" value="Add User">
  </div>
</form>
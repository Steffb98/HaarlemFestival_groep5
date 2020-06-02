<!DOCTYPE html>
<?php
session_start();
require('../Controller/EditAccountController.php');

if($loggedInUser->NewAccount == 0){
  include_once('SideBars.php');
}

$loggedInUser = $_SESSION['LoggedInUser'];
?>
<html>
<head>
  <title>CMS Edit Account</title>
  <link rel="stylesheet" href="../CSS/EditAccountStyle.css">
</head>
<body>
  <section class="EditAccount">
    <h2><?php if($loggedInUser->NewAccount == 1){echo 'Please complete your account before being a part of our volunteergroup';} else{echo 'Edit account';} ?></h2>
    <form method="post">
      <div><span>First name*</span><input type="text" name="FirstName" value="<?php echo $loggedInUser->FirstName;?>" required></div>
      <div><span>Last name*</span><input type="text" name="LastName" value="<?php echo $loggedInUser->LastName;?>" required></div>
      <div><span>Email*</span><input type="email" name="Email" value="<?php echo $loggedInUser->Email;?>" required></div>
      <div><span>Password</span><input type="password" name="Password" value=""></div>
      <p><?php if(isset($_SESSION['EditAccountErr'])){echo $_SESSION['EditAccountErr'];} ?></p>
      <input type="submit" name="EASubmit" value="Submit">
      <?php if($loggedInUser->NewAccount == 0){echo '<input type="submit" name="EACancel" value="Cancel">';}?>
    </form>
  </section>
</body>

</html>

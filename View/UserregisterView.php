<!DOCTYPE html>
<?php
session_start();
require_once("../Controller/IndexController.php");
$indexObject = new IndexController();
//If there was an unsuccesfull registration attempt, the error will be received here
$regError = $indexObject->CheckSession("regError");

require '../Controller/UserController.php'
?>
<html lang="en" dir="ltr">
<head>
  <!-- method that gets all metatags -->
  <?php $indexObject->SetMetaTags('User register', 'UserloginStyle') ?>
</head>
<body>
  <!-- displaying the navbar -->
  <div id="usernavbar">
    <?php include_once('NavbarView.php'); ?>
  </div>
  <div class="section" id="sectionregister">
    <form class="regformcontainer" id="registercontainer" method="POST">
      <h1 class="userformregistertitle">Register</h1>
      <!-- if there was an error while trying to register, it will be displayed here -->
      <p id=ErrorMessage><?php echo $regError ?></p>
      <!-- Ask the user for input -->
      <i class="fas fa-user"></i><input type="Text" name="regFirstName" placeholder="First Name" class="userformtextbox" required></br>
      <i class="fas fa-user"></i><input type="Text" name="regLastName" placeholder="Last Name" class="userformtextbox" required></br>
      <i class="fas fa-envelope-square"></i><input type="Email" name="regEmail" placeholder="Email" class="userformtextbox" required></br>
      <i class="fas fa-lock"></i><input type="Password" name="regPassword1" placeholder="Password" class="userformtextbox" required></br>
      <i class="fas fa-lock"></i><input type="Password" name="regPassword2" placeholder="Password again" class="userformtextbox" required></br>
      <!-- The captcha is shown here -->
      <div class="g-recaptcha" data-sitekey="6LdxIM0UAAAAAHfHp_E27iTCcYCWRLtvgVf5ygA6" name="captcha" onclick="../Controller/captchaCheck"></div>
      <!-- this button will call the function to check if the register information is correct or not in the user controller. -->
      <input type="Submit" name="reg_submit" class="formbutton" id="registerformbutton" value="Register"></br>
      <!-- the user can access the login page with this button -->
      <p class="backtologin" onclick="location.href='UserloginView.php'">Existing user? Sign in</p>
    </form>
  </div>
  <!-- the footer is displayed here -->
  <div id="userfooter">
    <?php include_once('FooterView.php') ?>
  </div>
</body>
</html>

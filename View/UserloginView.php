<!DOCTYPE html>
<?php
session_start();
require_once("../Controller/IndexController.php");
$indexObject = new IndexController();
//Checking if the user has already logged in before. if this is the case, the user is redirected to the user order page.
if (isset($_SESSION['User_ID'])) {
  $userID = $_SESSION['User_ID'];
  header("location:UserordersView.php?");
}

//If there was an unsuccesfull login attempt or a succesfull register attempt, the messages will be received here.
$loginError = $indexObject->CheckSession("lgnError");
$registerMsg = $indexObject->CheckSession("regSucces");

require '../Controller/UserController.php';
?>
<html lang="en" dir="ltr">
<head>
  <!-- method that gets all metatags -->
  <?php $indexObject->SetMetaTags('User Login', 'UserloginStyle') ?>
</head>
<body>
  <!-- displaying the navbar -->
  <div id="usernavbar">
    <?php include_once('NavbarView.php'); ?>
  </div>

  <div class="section" id="sectionlogin">
    <form class="formcontainer" id="logincontainer" method="POST" >
      <h1 class="userformlogintitle">Login</h1>
      <!-- if there was an error while trying to log in, it will be displayed here -->
      <p id=ErrorMessage><?php echo $loginError ?></p>
      <!-- if there was a succesfull registration confirmed, a message will be displayed here -->
      <p id=regSucces><?php echo $registerMsg ?></p>
      <!-- Ask the user for input -->
      <i class="fas fa-envelope-square"></i><input type="Email" name="LoginEmail" placeholder="Email" class="userformtextbox" id="userloginformnametb" required></br>
      <i class="fas fa-lock"></i><input type="Password" name="LoginPassword" placeholder="Password" class="userformtextbox" id="userloginformpasswordtb" required></br>
      <!-- this button will call the function to check if the login information is correct or not in the user controller -->
      <input type="Submit" name="login_submit" class="formbutton" value="Login">
      <!-- the user can access the register page with this button -->
      <button type="button" name="button" class="formbutton" onclick="location.href='UserregisterView.php'">Register</button></br>
      <a class="forgotpw" href="#forgotpassword">Forgot password?</a>
    </form>
  </div>
  <!-- the footer is displayed here -->
  <div id="userfooter">
    <?php include_once('FooterView.php') ?>
  </div>
</body>
</html>

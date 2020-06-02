<!DOCTYPE html>
<?php
session_start();
require('../Controller/LoginController.php');
?>
<html>
<head>
  <title>CMS Login</title>
  <link rel="stylesheet" href="../CSS/LoginStyle2.css">
  <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
  <?php if(isset($_SESSION['Login'])){$loginValues = $_SESSION['Login'];} ?>
  <form class="LoginForm" method="post">
    <h1>Login for volunteers</h1>
    <div class="Piet">
      <label for="Email">Email </label>
      <input id="Email" type="email" name="Email" placeholder="Email" value="<?php if(isset($loginValues)){ echo $loginValues[0];} ?>">
    </div>
    <div class="Piet">
      <label for="Password">Password </label>
      <input id="Password" type="password" name="Password" placeholder="Password" value="<?php if(isset($loginValues)){ echo $loginValues[1];} ?>">
    </div>

    <div class="g-recaptcha" data-sitekey="6LdyIM0UAAAAAJ_ByieR-T8Crr2IebsOM2T0h3zP" name="captcha" onclick="../Controller/captchaCheck" require></div>
    <div class="Remember">
      <label class="container">Remember Me
        <input type="checkbox" Name="Remember"c>
        <span class="checkmark"></span>
      </label>
    </div>
    <input type="submit" name="SignIn" value="Sign in">
    <p><?php if(isset($_SESSION['loginERR'])){echo $_SESSION['loginERR'];} ?></p>
    <a href="#">Forgot password?</a>
  </form>
</body>
<script>

</script>
</html>

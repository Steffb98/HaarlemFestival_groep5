<?php
session_start();
session_destroy();
setcookie('RememberMe', NULL, -1, '/'); 
header("location: LoginView.php");
?>

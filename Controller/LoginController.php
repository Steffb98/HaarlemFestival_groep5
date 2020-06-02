<?php
$login = new Login();
require_once("../DAL/LoginDAL.php");
require_once("../DAL/VolunteerDAL.php");

//if login cookie is placed, get the user information, and log in
if(isset($_COOKIE['RememberMe'])){
  if($_COOKIE['RememberMe'] != NULL){
    $_SESSION['LoggedInUser'] = CMS_GetEditVolunteers($_COOKIE['RememberMe']);
    header("Location: DashboardView.php");
  }
}
//if sign in is pressed, do function
if(isset($_POST['SignIn'])){
  $login->Login2();
}

class Login{

  function Login2(){
    global $login;
    //check if mail is a valid email adress, do the same for passwd
    $checkEmail = $login->CheckEmail($_POST['Email']);
    $checkPassword = $login->CheckPassword($_POST['Password']);
    $captchaRespons = $_POST['g-recaptcha-response'];

    //if these are valid, get the result if these values are searched in the DB
    if($checkEmail == true && $checkPassword == true){
      $result = SearchUser($_POST['Email'], hash('sha512',$_POST['Password']));

      //if there is a result, logged in user session is the result
      if ($result != NULL){
        //if captcha gives a positive response
        if (strlen($captchaRespons) != 0){
          $_SESSION['LoggedInUser'] = $result;

          //if 'REMEMBER ME' is set, set a cookie
          if(isset($_POST['Remember'])){
            if($_POST['Remember'] == 'on'){
              setcookie('RememberMe', $result->VolunteerID, time() + (86400 * 30), "/");
            }
          }
          //go to dashboard and set the values to '';
          header("Location: DashboardView.php");
          $_SESSION['Login'] = array('', '');
          $login->UserNotFound('');
        }
        else{//generate err msg
          $login->UserNotFound("I'm not a robot check must be done.");
        }
      }
      else{//generate err msg
        $login->UserNotFound("Emailadress or password is invalid");
      }
    }
    else{//generate err msg
      $login->UserNotFound("Emailadress or password contains invalid characters)");
    }
  }
  //you guessed it, check if valid email
  function CheckEmail($email){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
      return true;
    }
    else{
      return false;
    }
  }
  //speaking voor zich i think.
  function CheckPassword($password){
    if(preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/i", $password)){
      return true;
    }
    return false;
  }
  function UserNotFound($string){
    $_SESSION['Login'] = array($_POST['Email'], $_POST['Password']);
    $_SESSION['loginERR'] = $string;
  }
}
?>

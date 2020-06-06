<?php require "../DAL/UserDAL.php";
  require_once '../Model/TicketModel.php';
  //session_destroy();

class UserController
{
  public $object;

  //a constructor is used to initiate the DAL layer for this class.
  function __construct()
  {
    $this->object = new UserDAL();
  }

  //this function returns the purchased tickets for the logged in user from the database
  public function GetTicketsWithUserID($userID){
    return $this->object->GetUserOrderInfoDB($userID);
  }

  //This function checks if a password meets some basic requirements
  function CheckPassword($pw) {
    //if the length of a password is less than 8, an error is show to the user
    if (strlen($pw) < 8) {
      $regError = "Your password must contain at least 8 characters!";
      $_SESSION['regError'] = $regError;
      header('location:UserregisterView.php');
      return false;
    }
    //if the password doesnt contain a number, an error is shown to the user
    elseif (!preg_match("#[0-9]+#", $pw)) {
      $regError = "Your password must contain at least 1 number!";
      $_SESSION['regError'] = $regError;
      header('location:UserregisterView.php');
      return false;
    }
    //if the password doesnt contain a capital letter, an error is shown to the user
    elseif (!preg_match("#[A-Z]+#", $pw)) {
      $regError = "Your password must contain at least 1 capital letter!";
      $_SESSION['regError'] = $regError;
      header('location:UserregisterView.php');
      return false;
    }
    //if the password doesnt contain a lowercase letter, an error is shown to the user
    elseif (!preg_match("#[a-z]+#", $pw)) {
      $regError = "Your password must contain at least 1 lowercase letter!";
      $_SESSION['regError'] = $regError;
      header('location:UserregisterView.php');
      return false;
    }
    //if these 4 requirements are met, the function returns true (which means that the password is good)
    else {
      return true;
    }
  }

  function GiveRegError($err, $fn, $ln, $email){
    $_SESSION['regError'] = $err;
    $_SESSION['regFN'] = $fn;
    $_SESSION['regLN'] = $ln;
    $_SESSION['regEmail'] = $email;
    header('location:UserregisterView.php');
  }
}

$userDALObject = new UserDAL();
$userControllerObject = new UserController();

//When the button to log in is clicked, this function is called.
if (isset($_POST['login_submit']))
{
  $loginError = '';
  $email=$_POST['LoginEmail'];
  $pw=$_POST['LoginPassword'];

  //Checking if the email and password are in the database and belong to eachother
  $user = $Object->CheckIfLoginExistsDB($email, hash('sha512', $pw));

  //If the database returns a user, the user is redirected to the user order page and the userid is saved in a session
  if (!empty($user)) {
    $userID = $user->getUserID();
    $_SESSION['User_ID'] = $userID;
    header("location:UserordersView.php");
  }
  //if the database returns nothing, no user was found with this combination of email and password, and the user will be shown an errormessage.
  else{
    $loginError = 'This email and password combination does not exist';
    $_SESSION['lgnEmail'] = $email;
    $_SESSION['lgnError'] = $loginError;
    header('location:UserloginView.php');
  }
}

//This function is called when the user has tried to register
if (isset($_POST['reg_submit'])) {
  $regError = '';
  $fn=$_POST['regFirstName'];
  $ln=$_POST['regLastName'];
  $email=$_POST['regEmail'];
  $pw1=$_POST['regPassword1'];
  $pw2=$_POST['regPassword2'];
  $captcha = $_POST['g-recaptcha-response'];
  //Checking if the captcha was succesfully passed
  if (!strlen($captcha)  == 0) {
    //if the passwords match eachother..
    if ($pw1==$pw2) {
      //a function below is called to check if the password meet the requirements
      if ($userControllerObject->CheckPassword($pw1)) {
        //if the password meets the reqs, a DAL function is called to check if the email does not already exists in the database.
        $resultEmail = $userDALObject->CheckEmailDB($email);
        if (empty($resultEmail)) {
          //if the email does not already exists, the user is entered in the database
          $userDALObject->InsertUserDB($fn, $ln, $email, hash('sha512', $pw1), date("Y/m/d"));
          //a session is made to tell the user he has registered succesfully when the user is redirected to the login page
          $_SESSION['regSucces'] = 'You have registered succesfully!';
          header('location:UserloginView.php');
        }
        //if the email already exists in the database, an error is shown
        else {
          $userControllerObject->GiveRegError('This Email already exists.', $fn, $ln, $email);
        }
      }
    }
    //if the passwords do not match, an error is shown
    else {
      $userControllerObject->GiveRegError("The passwords don't match!", $fn, $ln, $email);
    }
  }
  //if the captcha is not completed succesfully, and error is shown
  else {
    $userControllerObject->GiveRegError('Please confirm you are not a robot.', $fn, $ln, $email);
  }
}
?>

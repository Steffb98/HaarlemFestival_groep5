<?php
//require some files
require_once '../DAL/EditAccountDAL.php';
require_once 'ActivityAEController.php';
$validate = new ActivityAE;
require_once '../DAL/LoginDAL.php';


$EA = new EditAccount;
$loggedInUser = $_SESSION['LoggedInUser'];

//if cancel button is pressed, return the dashboard
if(isset($_POST['EACancel'])){
  header('location: DashboardView.php');
}

//
if(isset($_POST['EASubmit'])){
  $EA->Submit($_POST['FirstName'], $_POST['LastName'], $_POST['Email'], $_POST['Password']);
}

class EditAccount{
  function Submit($firstName, $lastName, $email, $password){
    global $validate;
    global $loggedInUser;
    global $EA;

    //make an error variable,
    //make an checker variable,
    //while $checker is true, enter every if, if the value is not valid, set the checker to false, generate err msg,
    //and break out of the loop, this way not every if statement has to be walked through->efficient
    //if the checker is false(invalid input), put the error msg in a session,
    //return the values into the input boxes so the user won't have to type it again.
    //if the checker is true(all valid inputs), empty the inputs, empty the err, reload page and add the valid inputs to the DB
    $err = '';
    $checker = true;
    while ($checker==true) {
      if(!$validate->ValidateInput($firstName)){$checker = false; $err='Invalid first name'; break;}
      if(!$validate->ValidateInput($lastName)){$checker = false; $err='Invalid last name'; break;}
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){$checker = false; $err='Invalid email'; break;}
      if($password != ''){
        if(!$EA->CheckPassword($password)){$checker = false; $err='Password should contain:</br>- 1 uppercase letter</br>- 1 lowercase letter</br>- no special characters</br>- at least 8 characters'; break;}
      }
      break;
    }

    if($checker == false){
      $_SESSION['EditAccountErr'] = $err;
    }
    //check if password is also set for change, if so change the password to.
    else{
      if($password != ''){
        CMS_EditAccount($firstName, $lastName, $email, $loggedInUser->VolunteerID, 0, hash('sha512',$password));
        $_SESSION['LoggedInUser'] = SearchUser($email, hash('sha512',$password));
      }
      else{
        CMS_EditAccount2($firstName, $lastName, $email, $loggedInUser->VolunteerID, 0);
        $_SESSION['LoggedInUser'] = SearchUser($email, $loggedInUser->Password);
      }
      header("Location: DashboardView.php");
      $_SESSION['EditAccountErr'] = '';
    }
  }
  //password validation
  function CheckPassword($password){
    if(preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/i", $password)){
      return true;
    }
    return false;
  }
}
?>

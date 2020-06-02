<?php

require_once '../DAL/NewMessageDAL.php';

$newMessage = new NewMessage();

//if new message is pressed, do method/function/idk
if(isset($_POST['NMSubmit'])){
  $newMessage->SendMessage();
}

class NewMessage{

  function SendMessage(){
    global $newMessage;
    //get the LoggedInUser
    $loggedInUser = $_SESSION['LoggedInUser'];

    $subject = $_POST['Subject'];
    $text = $_POST['Text'];
    //validate the messages
    $checker = $newMessage->CheckMessage($subject, $text);

    //if checker is true, send inputs to the DB, empty the textfields
    if($checker == true){
      CMS_NewMessage($loggedInUser->VolunteerID, $subject, date("Y-m-d G:i:s"), $text);
      $_SESSION['NewMessageErr'] = '';
      $_SESSION['NewMessageData'] = array('', '');
      header('location: MessageView.php');
    }
    //if checker is false, generate err msg and place typed in text in textbox because user friendly much :)
    else{
      $_SESSION['NewMessageErr'] = 'Invalid character(s) used, do not use: [ $ = @ # | < > ^ * ]';
      $_SESSION['NewMessageData'] = array($subject, $text);
    }
  }


  //method for checking message + subject
  function CheckMessage($subject, $text){
    if(preg_match('/[$=@#|<>^*]/', $subject)){
      return false;
    }
    else if(preg_match('/[$=@#|<>^*]/', $text)){
      return false;
    }
    else{
      return true;
    }
  }
}

?>

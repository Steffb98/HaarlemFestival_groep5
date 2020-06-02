<?php
require_once '../DAL/IndexDAL.php';

class IndexController
{
  public $Object;

  function __construct()
  {
    $this->Object = new IndexDAL();
  }
  public function getInfoText()
  {
    return $result = $this->Object->getInfoTextDB();
  }

  function CheckSession($session)
  {
    if (!empty($_SESSION[$session])) {
      $var = $_SESSION[$session];
      unset($_SESSION[$session]);
    }
    else{
      $var = "";
    }
    return $var;
  }

  public function getUpdate($size, $recent){
    $maxID;
    if ($recent == 0) {
      $maxID = $this->Object->getMaxTextInfoIDDB($size)["MAX(UpdateID)"];
    }
    else {
      $maxID = $this->Object->getSecondMaxTextInfoIDDB($size)["UpdateID"];
    }
    return $this->Object->getUpdateDB($maxID);
  }

  function SetMetaTags($title, $css)
  {
    echo'<meta charset="utf-8">
    <title>'.$title.'</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/6b90be84c7.js" crossorigin="anonymous"></script>
    <script src="https://apis.google.com/js/platform.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <link rel="stylesheet" type="text/css" href="../CSS/'.$css.'.css">';
  }
}
?>

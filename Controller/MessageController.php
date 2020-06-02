<?php

require_once '../DAL/MessageDAL.php';

$getUpdates = new GetMessage();
$getUpdates->GetMessage2();

class GetMessage{
//get all message if S is not set, else, only filter the messages where filter
  function GetMessage2(){
    if (isset($_GET['S'])){
      $_SESSION['Messages'] = CMS_GetMessage($_GET['S']);
    }
    else{
      $_SESSION['Messages'] = CMS_GetMessage();
    }
  }

  //cool test function :)
  // function GetMessage()
  // {
  //   $messageArray = array();
  //
  //   for ($i=0; $i < mt_rand(2, 8) ; $i++) {
  //     $message = new stdClass();
  //     $message->Id = $i;
  //     $timestamp = mt_rand(1, time());
  //     $message->Date = date("D, d", $timestamp)."th ".date("M", $timestamp);
  //     $message->Writer = $this->GenerateWriter();
  //     $message->Topic = $this->GenerateText(2, 10);
  //     $message->Text = $this->GenerateText(2, 1000);
  //     array_push($messageArray, $message);
  //   }
  //
  //   $_SESSION['messages'] = $messageArray;
  // }
  //
  // public function GenerateText(int $min, int $max){
  //   $sentence = "";
  //   $arrayWords = array("close","then","tax","pack","he","material", "manner","perhaps","pool","child","those","plan", "kept","organization","ball","army","influence","ourselves","pink","anyway","heat","roll",
  //   "along","perfectly","young","tail","serve","nearest","has","would","baseball","treated","hold","stopped","lack","finally","blood","supply","highway","desert","solution","escape");
  //
  //   for ($i=0; $i < mt_rand($min, $max); $i++) {
  //     $sentence = $sentence.$arrayWords[array_rand($arrayWords)]." ";
  //   }
  //   return $sentence.".";
  // }
  //
  // public function GenerateWriter(){
  //   $arrayWords = array("Kimberly van Gelder", "Jaap van Dalen", "Steff Burgering", "Cheyen Alberts");
  //   return $arrayWords[array_rand($arrayWords)];
  // }
}

?>

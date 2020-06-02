<?php
require_once '../DAL/UpdateDAL.php';

class GetUpdates
{
  //get updates nothing more, nothing less
  public function GetUpdates2(){
    $updateList = CMS_GetUpdates();
    $_SESSION['Updates'] = $updateList;
  }

  //fun testing!!
  // public function GetUpdates()
  // {
  //   $updateArray = array();
  //
  //   for ($i=0; $i < mt_rand(2, 8) ; $i++) {
  //     $update = new stdClass();
  //     $timestamp = mt_rand(1, time());
  //     $update->Date = date("D, d", $timestamp)."th ".date("M", $timestamp);
  //     $update->title = $this->GenerateText(2, 10);
  //     $update->text = $this->GenerateText(25, 5000);
  //     $update->image = $this->GenerateImage();
  //     array_push($updateArray, $update);
  //   }
  //
  //   $_SESSION['updates'] = $updateArray;
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
  // public function GenerateImage(){
  //   $image = "Random".mt_rand(1, 7).".png";
  //   return $image;
  // }
}
?>

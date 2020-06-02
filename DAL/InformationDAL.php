<?php
require_once '../DAL/DbConn.php';

$mysqli = Singleton::getInstance();

function CMS_GetInformation($filter){
  global $mysqli;
  $stmt = $mysqli->stmt_init();
  $stmt->prepare('SELECT TextID, Page, InfoText, PageDetail FROM Information WHERE PageDetail = ?');
  $stmt->bind_param("i", $filter);
  $stmt->execute();
  $stmt = $stmt->get_result();

  $InformationArray = array();
  if($stmt != ''){
    while ($item=mysqli_fetch_object($stmt)){
      array_push($InformationArray, $item);
    }
  }
  return $InformationArray;
}

function CMS_ChangeInformation($textID, $text){
  global $mysqli;
  $stmt = $mysqli->stmt_init();
  $stmt->prepare('UPDATE Information SET InfoText = ? WHERE TextID = ?');
  $stmt->bind_param("si", $text, $textID);
  $stmt->execute();
  $stmt = $stmt->get_result();
}

?>

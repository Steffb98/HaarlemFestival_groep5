<?php
require_once '../DAL/DbConn.php';

$mysqli = Singleton::getInstance();
//get all updates, nothing special
function CMS_GetUpdates(){
  global $mysqli;
  $updateList = array();

  $updateQuery = $mysqli->query('SELECT UpdateID, Date, Sort, Text FROM UpdateWebsite ORDER BY Date DESC');

  if($updateQuery != ''){
    while ($update=mysqli_fetch_object($updateQuery)){
      array_push($updateList, $update);
    }
  }
  return $updateList;

}

?>

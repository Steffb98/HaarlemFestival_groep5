<?php
require_once ('DbConn.php');
$mysqli = Singleton::getInstance();

class IndexDAL
{
  function __construct()
  {
  }

  public function getInfoTextDB()
  {
    global $mysqli;
    $sql = "SELECT InfoText FROM Information";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $infoArray = array();
    if($stmt != ''){
      while ($info=mysqli_fetch_array($result)){
        array_push($infoArray, $info);
      }
    }
    return $infoArray;
  }

  public function getMaxTextInfoIDDB($size)
  {
    global $mysqli;
    $sql = "SELECT MAX(UpdateID) FROM UpdateWebsite WHERE Size = ?";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("i",$size);
    $stmt->execute();
    return mysqli_fetch_assoc($stmt->get_result());
  }

  public function getSecondMaxTextInfoIDDB($size)
  {
    global $mysqli;
    $sql = "SELECT DISTINCT UpdateID FROM UpdateWebsite WHERE Size = ? ORDER BY UpdateID DESC LIMIT 1,1";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("i",$size);
    $stmt->execute();
    return mysqli_fetch_assoc($stmt->get_result());
  }

  public function getUpdateDB($ID){
    global $mysqli;
    $sql = "SELECT * FROM UpdateWebsite WHERE UpdateID = ?";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("i",$ID);
    $stmt->execute();
    return mysqli_fetch_assoc($stmt->get_result());
  }
}
?>

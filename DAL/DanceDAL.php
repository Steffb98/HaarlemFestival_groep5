<<?php
require_once ('DbConn.php');
$mysqli = Singleton::getInstance();

class DanceDAL
{
  function __construct()
  {}

    public function getDanceDJDB($DJID)
    {
      global $mysqli;
      $sql = "SELECT * FROM DJ WHERE DJID = ?";
      $stmt = $mysqli->stmt_init();
      $stmt->prepare($sql);
      $stmt->bind_param("i",$DJID);
      $stmt->execute();
      return mysqli_fetch_assoc($stmt->get_result());
    }


    public function getDJSessionsDB()
    {
      global $mysqli;
      $sql = "SELECT * FROM DJSessions JOIN DJ ON DJSessions.DJID=DJ.DJID WHERE DJ.Name NOT LIKE '%access%'";
      $stmt = $mysqli->stmt_init();
      $stmt->prepare($sql);
      $stmt->execute();
      return $stmt->get_result();
    }

    Public function getDJSessionsAllDaysDB()
    {
      global $mysqli;
      $sql = "SELECT * FROM DJSessions JOIN DJ ON DJSessions.DJID=DJ.DJID WHERE DJ.Name LIKE '%access%'";
      $stmt = $mysqli->stmt_init();
      $stmt->prepare($sql);
      $stmt->execute();
      return $stmt->get_result();
    }

    public function getDJNameDB($DJID)
    {
      global $mysqli;
      $sql = "SELECT Name FROM DJ WHERE DJID = ?";
      $stmt = $mysqli->stmt_init();
      $stmt->prepare($sql);
      $stmt->bind_param("i",$DJID);
      $stmt->execute();
      return mysqli_fetch_assoc($stmt->get_result());
    }

    public function getLocationDB($locationID)
    {
      global $mysqli;
      $sql = "SELECT Venue FROM Location WHERE LocationID = ?";
      $stmt = $mysqli->stmt_init();
      $stmt->prepare($sql);
      $stmt->bind_param("i",$locationID);
      $stmt->execute();
      return mysqli_fetch_assoc($stmt->get_result());
    }

    public function get_AddressDanceDB($hall){
      global $mysqli;
      $sql = "SELECT Address FROM Location WHERE Venue = ?";
      $stmt = $mysqli->stmt_init();
      $stmt->prepare($sql);
      $stmt->bind_param("s",$hall);
      $stmt->execute();
      return $stmt->get_result();
    }

    public function get_DanceIDDB($name)
    {
      global $mysqli;
      $sql = "SELECT DJID FROM DJ WHERE name = ?";
      $stmt = $mysqli->stmt_init();
      $stmt->prepare($sql);
      $stmt->bind_param("s",$name);
      $stmt->execute();
      $result = $stmt->get_result();
      return $row = mysqli_fetch_assoc($result);
    }

}

?>

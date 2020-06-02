<?php
require_once ('DbConn.php');
$mysqli = Singleton::getInstance();

class JazzDAL
{
  function __construct()
  {}
  public function getBandSessionsDB()
  {
    global $mysqli;
    $sql = "SELECT * FROM BandSessions JOIN Band ON BandSessions.BandID=Band.BandID WHERE Band.Name NOT LIKE '%access%'";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->execute();
    return $stmt->get_result();
  }

  public function getJazzId($name)
  {
    global $mysqli;
    $sql = "SELECT BandID FROM Band WHERE name = ?";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s",$name);
    $stmt->execute();
    $result = $stmt->get_result();
    return $row = mysqli_fetch_assoc($result);
  }

  public function getBandSessionDB($sessionID)
  {
    global $mysqli;
    $sql = "SELECT * FROM BandSessions WHERE BSessionID = ?";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("i",$sessionID);
    $stmt->execute();
    $result = $stmt->get_result();
    $sessionArray = array();
    while ($session=mysqli_fetch_object($result)){
      array_push($sessionArray, $session);
    }
    return $sessionArray;
  }

  public Function getBandNameDB($id)
  {
    global $mysqli;
    $sql = "SELECT Name FROM Band WHERE BandID = ?";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    return mysqli_fetch_assoc($stmt->get_result());
  }

  public Function getHallDB($locationID)
  {
    global $mysqli;
    $sql = "SELECT Venue FROM Location WHERE LocationID = ?";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("i",$locationID);
    $stmt->execute();
    return mysqli_fetch_assoc($stmt->get_result());
  }

  public function getJazzbandDB($bandID)
  {
    global $mysqli;
    $sql = "SELECT * FROM Band WHERE BandID = ?";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("i",$bandID);
    $stmt->execute();
    return mysqli_fetch_assoc($stmt->get_result());
  }

  public function get_AddressJazzDB($hall){
    global $mysqli;
    $sql = "SELECT Address FROM Location WHERE Venue = ?";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s",$hall);
    $stmt->execute();
    return $stmt->get_result();
  }

  public function GetBandIDSearchDB($search){
    global $mysqli;
    $stmt = $mysqli->stmt_init();
    $stmt->prepare("SELECT BandID, Name FROM Band WHERE Name LIKE ?");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    return $stmt->get_result();
  }

  public function getBandSessionsWithBandID($bandID){
    global $mysqli;
    $sql = "SELECT * FROM BandSessions WHERE BandID = ?";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("i", $bandID);
    $stmt->execute();
    return $stmt->get_result();
  }

  public function GetEarliestDate(){
    global $mysqli;
    $stmt = $mysqli->stmt_init();
    $stmt->prepare("SELECT MIN(StartTime) as EarliestDate FROM BandSessions");
    $stmt->execute();
    return var_dump(mysqli_fetch_object($stmt->get_result()));
  }
}
?>

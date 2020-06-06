<?php
require_once ('DbConn.php');
$mysqli = Singleton::getInstance();

class ticketDAL
{
  function __construct()
  {}

  public function getSessionIDBD($type,$id,$date,$time)
  {
    $data = date("Y-m-d",strtotime($date)).date(" G:i:s",strtotime($time));
    global $mysqli;
    if($type == "food")
    {
      $sql = "SELECT RSessionID as SessionID FROM RestaurantSessions WHERE RestaurantID = ? AND StartTime = ?";
    }
    else if ($type == "jazz")
    {
      $sql = "SELECT BSessionID as SessionID FROM BandSessions WHERE BandID = ? AND StartTime = ?";
    }
    else if ($type == "dance")
    {
      $sql = "SELECT DSessionID as SessionID FROM DJSessions WHERE DJID = ? AND StartTime = ?";
    }
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("is",$id,$data);
    $stmt->execute();
    $result = $stmt->get_result();
    return $row = mysqli_fetch_assoc($result);
  }
  public function getOrderID()
  {
    global $mysqli;
    $sql = "SELECT max(OrderID) as OrderID FROM OrderCart";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    return $row = mysqli_fetch_assoc($result);
  }
  public function getTicketInDB($OrderID,$specialText,$User_ID,$price,$amount,$SessionID,$type)
  {
    global $mysqli;
    $newOrderID = $OrderID +1;
    $vat = $price * 0.21;
    if($type == "food")
    {
      $reservationfee = 10;
      $sql = "INSERT INTO OrderCart (OrderID, RSessionID, Amount, UserID, RequestText, ReservationFee, TotalPrice, VAT )
      VALUES(?,?,?,?,?,?,?,?)";
    }
    else if ($type == "jazz")
    {
      $reservationfee = 0;
      $sql = "INSERT INTO OrderCart (OrderID, BSessionID, Amount, UserID, RequestText, ReservationFee, TotalPrice, VAT )
      VALUES(?,?,?,?,?,?,?,?)";
    }
    else if ($type == "dance")
    {
      $reservationfee = 0;
      $sql = "INSERT INTO OrderCart (OrderID, DSessionID, Amount, UserID, RequestText, ReservationFee, TotalPrice, VAT )
      VALUES(?,?,?,?,?,?,?,?)";
    }
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("iiiisiii",$newOrderID,$SessionID,$amount,$User_ID,$specialText,$reservationfee,$price,$vat);
    $stmt->execute();
  }
}
?>

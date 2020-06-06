<?php
require_once '../DAL/ticketDAL.php';

class ticketController
{
  public $Object;

  function __construct()
  {
    $this->Object = new ticketDAL();
  }

  public function ticketinDB($OrderID,$specialText,$User_ID,$price,$amount,$SessionID,$type)
  {
    return $this->Object->getTicketInDB($OrderID,$specialText,$User_ID,$price,$amount,$SessionID,$type);
  }

  public function getSessionID($type,$id,$date,$time)
  {
     if($type == "jazz" || $type == "dance")
     {
       //get the start date of the event
       $timeArray = array();
       $timeArray = explode(" - ",$time);
       $time = $timeArray[0];
     }
    return $this->Object->getSessionIDBD($type,$id,$date,$time);
  }

  public function orderID()
  {
    return $this->Object->getOrderID();
  }


}
?>

<?php
require_once '../DAL/DanceDAL.php';

$danceObject = new DanceDAL();


Class DanceController
{
  public $Object;

  function __construct()
  {
    $this->Object = new DanceDAL();
  }

  public function getDanceDJ($DJID)
  {
    return $this->Object->getDanceDJDB($DJID);
  }

  public function getDJSessions()
  {
    return $this->Object->getDJSessionsDB();
  }

  public function getDJName($DJID)
  {
    return $this->Object->getDJNameDB($DJID);
  }

  public function getLocation($locationID)
  {
    return $this->Object->getLocationDB($locationID);
  }

  public function getDJSessionsAllDays()
  {
    return $this->Object->getDJSessionsAllDaysDB();
  }

  public function get_AddressDance($hall) {
    return $this->Object->get_AddressDanceDB($hall);
  }

  public function get_DanceID($name) {
    return $this->Object->get_DanceIDDB($name);
  }
}













?>

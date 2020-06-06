<?php
require_once '../Model/UserModel.php';

class TicketModel
{
  private $orderID;
  private $name;
  private $totalPrice;
  private $amountOfTickets;
  private $user;
  private $startTime;
  private $endTime;
  private $address;
  private $venue;
  private $eventID;
  private $sessionID;
  private $locationID;
  private $IMG;

  function __construct($orderID, $sessionID, $amount, $totalPrice, $firstName, $lastName)
  {
    $this->orderID = $orderID;
    $this->sessionID = $sessionID;
    $this->amountOfTickets = $amount;
    $this->totalPrice = $totalPrice;
    $this->user = new UserModel($firstName, $lastName);
  }

  public function getOrderID()
  {
      return $this->orderID;
  }

  public function setOrderID($orderID)
  {
      $this->orderID = $orderID;
  }
  public function getName()
  {
      return $this->name;
  }

  public function setName($name)
  {
      $this->name = $name;
  }
  public function getTotalPrice()
  {
      return $this->totalPrice;
  }

  public function setTotalPrice($totalPrice)
  {
      $this->totalPrice = $totalPrice;
  }
  public function getAmountOfTickets()
  {
      return $this->amountOfTickets;
  }

  public function setAmountOfTickets($amountOfTickets)
  {
      $this->amountOfTickets = $amountOfTickets;
  }
  public function getUser()
  {
      return $this->user;
  }

  public function setUser($user)
  {
      $this->user = $user;
  }
  public function getStartTime()
  {
      return $this->startTime;
  }

  public function setStartTime($startTime)
  {
      $this->startTime = $startTime;
  }
  public function getEndTime()
  {
      return $this->endTime;
  }

  public function setEndTime($endTime)
  {
      $this->endTime = $endTime;
  }
  public function getAddress()
  {
      return $this->address;
  }

  public function setAddress($address)
  {
      $this->address = $address;
  }
  public function getVenue()
  {
      return $this->venue;
  }

  public function setVenue($venue)
  {
      $this->venue = $venue;
  }

  public function getEventID()
  {
      return $this->eventID;
  }

  public function setEventID($eventID)
  {
      $this->eventID = $eventID;
  }

  public function getSessionID()
  {
      return $this->sessionID;
  }

  public function setSessionID($sessionID)
  {
      $this->sessionID = $sessionID;
  }

  public function getLocationID()
  {
      return $this->locationID;
  }

  public function setLocationID($locationID)
  {
      $this->locationID = $locationID;
  }

  public function getIMG()
  {
      return $this->IMG;
  }

  public function setIMG($IMG)
  {
      $this->IMG = $IMG;
  }
}

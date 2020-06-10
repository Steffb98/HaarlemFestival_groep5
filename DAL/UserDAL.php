<?php
//First of all the connection to the database is made
//Every query with userinput is first bound to a parameter to prevent SQLinjection
require_once 'DbConn.php';
require_once '../Model/UserModel.php';
require_once '../Model/TicketModel.php';
$mysqli = Singleton::getInstance();

class UserDAL{
  function __construct()
  {
  }
  //This function checks if an email and password combination exists in the database
  public function CheckIfLoginExistsDB($email, $pw){
    global $mysqli;
    $stmt = $mysqli->stmt_init();
    $stmt->prepare("SELECT * FROM User WHERE EmailAddress = ? and Password = ?");
    $stmt->bind_param("ss", $email, $pw);
    $stmt->execute();
    $stmt = $stmt->get_result();

    if ($stmt != '') {
      foreach ($stmt as $user) {
        return new UserModel($user["FirstName"], $user["LastName"],$user["EmailAddress"], $user["Password"], $user["RegistrationDate"], $user["UserID"]);
        break;
      }
    }
    else{
      return null;
    }
  }

  //this function checks if an email already exists in the database
  public function CheckEmailDB($email){
    global $mysqli;
    $stmt = $mysqli->stmt_init();
    $stmt->prepare("SELECT * FROM User WHERE EmailAddress = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt = $stmt->get_result();

    if ($stmt != '') {
      foreach ($stmt as $user) {
        return new UserModel($user["FirstName"], $user["LastName"],$user["EmailAddress"], $user["Password"], $user["RegistrationDate"], $user["UserID"]);
        break;
      }
    }
    else{
      return null;
    }
  }

  //this function inserts a user in the database
  public function InsertUserDB($fn, $ln, $email, $pw, $date){
    global $mysqli;
    $sql = "INSERT INTO User (FirstName, LastName, EmailAddress, Password, RegistrationDate) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("sssss", $fn, $ln, $email, $pw, $date);
    $stmt->execute();
  }

  //This function gets information from the database about a specific ticket (Amount of tickets, OrderID of the purchase, what sessionID belongs
  //to the ticket, the total price of the ticket(s) and the first and last name of the logged in user)
  public function GetUserOrderInfoDB($userID){
    global $mysqli;
    $stmt = $mysqli->stmt_init();
    $stmt->prepare("SELECT OrderCart.Amount, OrderCart.OrderID, OrderCart.RSessionID, OrderCart.DSessionID, OrderCart.BSessionID, OrderCart.TotalPrice,
      User.FirstName, User.LastName
      FROM User AS User JOIN OrderCart AS OrderCart ON User.UserID=OrderCart.UserID
      WHERE OrderCart.UserID = ?");
      $stmt->bind_param("i", $userID);
      $stmt->execute();
      $result = $stmt->get_result();

      $ticketArray = array();

      foreach ($result as $tmpTicket) {
        $ticket;
        //if the restaurantsessionid is set the ticket is for a restaurant and the correct info will be called from the database
        if ($tmpTicket['RSessionID'] != NULL) {
          $ticket = new TicketModel($tmpTicket['OrderID'], $tmpTicket['RSessionID'], $tmpTicket['Amount'], $tmpTicket['TotalPrice'], $tmpTicket['FirstName'], $tmpTicket['LastName']);
          $ticket = $this->GetSessionInfoRestaurantDB($ticket);
          $ticket = $this->GetTicketLocationResDB($ticket);
        }
        //if the DJid is set the ticket is for a DJ and the correct info will be called from the database
        elseif($tmpTicket['DSessionID'] != NULL){
          $ticket = new TicketModel($tmpTicket['OrderID'], $tmpTicket['DSessionID'], $tmpTicket['Amount'], $tmpTicket['TotalPrice'], $tmpTicket['FirstName'], $tmpTicket['LastName']);
          $ticket = $this->GetSessionInfoDJDB($ticket);
          $ticket = $this->GetTicketLocationDB($ticket);
          $ticket = $this->GetNameAndIMGDJDB($ticket);
        }
        //if the bandsessionid is set the ticket is for a band and the correct info will be called from the database
        elseif($tmpTicket['BSessionID'] != NULL){
          $ticket = new TicketModel($tmpTicket['OrderID'], $tmpTicket['BSessionID'], $tmpTicket['Amount'], $tmpTicket['TotalPrice'], $tmpTicket['FirstName'], $tmpTicket['LastName']);

          $ticket = $this->GetSessionInfoJazzDB($ticket);
          $ticket = $this->GetTicketLocationDB($ticket);
          $ticket = $this->GetNameAndIMGJazzDB($ticket);
        }
        array_push($ticketArray, $ticket);
      }
      return $ticketArray;
    }

    //This function gets some more info about a specific restaurant ticket
    public function GetSessionInfoRestaurantDB($ticket){
      $sessionID = $ticket->getSessionID();
      global $mysqli;

      $stmt = $mysqli->stmt_init();
      $stmt->prepare("SELECT RestaurantID, StartTime FROM RestaurantSessions WHERE RSessionID = ?");
      $stmt->bind_param("i", $sessionID);
      $stmt->execute();
      $result = mysqli_fetch_object($stmt->get_result());
      $ticket->setLocationID($result->RestaurantID);
      $ticket->setStartTime($result->StartTime);
      $ticket->setEventID($result->RestaurantID);
      return $ticket;
    }

    //This function gets some more info about a specific Dj ticket
    public function GetSessionInfoDJDB($ticket){
      $sessionID = $ticket->getSessionID();
      global $mysqli;

      $stmt = $mysqli->stmt_init();
      $stmt->prepare("SELECT LocationID, StartTime, EndTime, DJID FROM DJSessions WHERE DSessionID = ?");
      $stmt->bind_param("i", $sessionID);
      $stmt->execute();
      $result = mysqli_fetch_object($stmt->get_result());

      $ticket->setLocationID($result->LocationID);
      $ticket->setStartTime($result->StartTime);
      $ticket->setEndTime($result->EndTime);
      $ticket->setEventID($result->DJID);
      return $ticket;
    }

    //This function gets some more info about a specific band ticket
    public function GetSessionInfoJazzDB($ticket){
      $sessionID = $ticket->getSessionID();
      global $mysqli;

      $stmt = $mysqli->stmt_init();
      $stmt->prepare("SELECT LocationID, StartTime, EndTime, BandID FROM BandSessions WHERE BSessionID = ?");
      $stmt->bind_param("i", $sessionID);
      $stmt->execute();
      $result = mysqli_fetch_object($stmt->get_result());;
      $ticket->setLocationID($result->LocationID);
      $ticket->setStartTime($result->StartTime);
      $ticket->setEndTime($result->EndTime);
      $ticket->setEventID($result->BandID);
      return $ticket;
    }

    //If a specific ticket is for a Dj/band, the address and venue is received from the location table
    public function GetTicketLocationDB($ticket){
      $locationID = $ticket->getLocationID();
      global $mysqli;
      $stmt = $mysqli->stmt_init();
      $stmt->prepare("SELECT Address, Venue FROM Location WHERE LocationID = ?");
      $stmt->bind_param("i", $locationID);
      $stmt->execute();
      $result = mysqli_fetch_object($stmt->get_result());

      $ticket->setAddress($result->Address);
      $ticket->setVenue($result->Venue);

      return $ticket;
    }

    //If a specific ticket is for a restaurant, the location, name and image is received from the restaurant table
    public function GetTicketLocationResDB($ticket){
      $restaurantID = $ticket->getEventID();
      global $mysqli;
      $stmt = $mysqli->stmt_init();
      $stmt->prepare("SELECT Location, Name, IMG FROM Restaurant WHERE RestaurantID = ?");
      $stmt->bind_param("i", $restaurantID);
      $stmt->execute();
      $result = mysqli_fetch_object($stmt->get_result());

      $ticket->setAddress($result->Location);
      $ticket->setName($result->Name);
      $ticket->setVenue($result->Name);
      $ticket->setIMG($result->IMG);

      return $ticket;
    }
    //if the ticket is for a band, the name and img are received from the band table
    public function GetNameAndIMGJazzDB($ticket){
      $eventID = $ticket->getEventID();
      global $mysqli;
      $stmt = $mysqli->stmt_init();
      $stmt->prepare("SELECT Name, IMG FROM Band WHERE BandID = ?");
      $stmt->bind_param("i", $eventID);
      $stmt->execute();
      $result = mysqli_fetch_object($stmt->get_result());

      $ticket->setName($result->Name);
      $ticket->setIMG($result->IMG);

      return $ticket;
    }

    //if the ticket is for a dj, the name and img are received from the dj table
    public function GetNameAndIMGDJDB($ticket){
      global $mysqli;
      $eventId = $ticket->getEventID();
      $stmt = $mysqli->stmt_init();
      $stmt->prepare("SELECT Name, IMG FROM DJ WHERE DJID = ?");
      $stmt->bind_param("i", $eventId);
      $stmt->execute();
      $result = mysqli_fetch_object($stmt->get_result());

      $ticket->setName($result->Name);
      $ticket->setIMG($result->IMG);

      return $ticket;
    }
  }
  ?>

<?php
//First of all the connection to the database is made
//Every query with userinput is first bound to a parameter to prevent SQLinjection
require_once ('DbConn.php');
require_once ('../Model/UserModel.php');
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

      $infoArray = array();
      //Every ticket that is found with this userid is returned in an array
      while ($item=mysqli_fetch_array($result)){
        array_push($infoArray, $item);
      }
      return $infoArray;
    }

    //This function gets some more info about a specific ticket (in case of DJ/Band: LocationID, starttime, endtime and the id of the band/dj
    //in case of restaurant the restaurantid and starttime)
    public function GetSessionInfoDB($RID, $DID, $BID){
      $ID;
      global $mysqli;
      $stmt = $mysqli->stmt_init();
      //if the ticket is for a jazzband, the information is received from the bandsession table
      if ($RID == NULL && $DID == NULL) {
        $stmt->prepare("SELECT LocationID, StartTime, EndTime, BandID FROM BandSessions WHERE BSessionID = ?");
        $ID = $BID;
      }
      //if the ticket is for a DJ, the information is received from the DJsession table
      elseif ($RID == NULL && $BID == NULL) {
        $stmt->prepare("SELECT LocationID, StartTime, EndTime, DJID FROM DJSessions WHERE DSessionID = ?");
        $ID = $DID;
      }
      //if the ticket is for a restaurant, the information is received from the restaurantsession table
      elseif ($DID == NULL && $BID == NULL) {
        $stmt->prepare("SELECT RestaurantID, StartTime FROM RestaurantSessions WHERE RSessionID = ?");
        $ID = $RID;
      }
      $stmt->bind_param("i", $ID);
      $stmt->execute();
      return mysqli_fetch_assoc($stmt->get_result());
    }

    //If a specific ticket is for a Dj/band, the address and venue is received from the location table
    public function GetTicketLocationDB($locationID){
      global $mysqli;
      $stmt = $mysqli->stmt_init();
      $stmt->prepare("SELECT Address, Venue FROM Location WHERE LocationID = ?");
      $stmt->bind_param("i", $locationID);
      $stmt->execute();
      return mysqli_fetch_assoc($stmt->get_result());
    }

    //If a specific ticket is for a restaurant, the location, name and image is received from the restaurant table
    public function GetTicketLocationResDB($restaurantID){
      global $mysqli;
      $stmt = $mysqli->stmt_init();
      $stmt->prepare("SELECT Location, Name, IMG FROM Restaurant WHERE RestaurantID = ?");
      $stmt->bind_param("i", $restaurantID);
      $stmt->execute();
      return mysqli_fetch_assoc($stmt->get_result());
    }

    //if the ticket is for a band/dj, the name and image are received from the respective tables
    public function GetNameAndIMGDB($DID, $BID){
      global $mysqli;
      $ID;
      $stmt = $mysqli->stmt_init();
      //if the ticket is for a jazzband, the information is received from the band table
      if ($DID == null){
        $stmt->prepare("SELECT Name, IMG FROM Band WHERE BandID = ?");
        $ID = $BID;
      }
      elseif ($BID == null) {
        //if the ticket is for a DJ, the information is received from the Dj table
        $stmt->prepare("SELECT Name, IMG FROM DJ WHERE DJID = ?");
        $ID = $DID;
      }
      $stmt->bind_param("i", $ID);
      $stmt->execute();
      return mysqli_fetch_assoc($stmt->get_result());
    }
  }
  ?>

<!DOCTYPE html>
<?php
session_start();
require '../Controller/UserController.php';
require '../Controller/IndexController.php';
//the userid of the user currently logged in is received here
$userID = $_SESSION['User_ID'];
$userObject = new UserController();
$indexObject = new IndexController();
?>
<html lang="en" dir="ltr">
<head>
  <!-- method that gets all metatags -->
  <?php $indexObject->SetMetaTags('User orders', 'UserorderStyle') ?>
</head>
<body>
  <!-- displaying the navbar -->
  <div id="navbar">
    <?php include_once('NavbarView.php'); ?>
  </div>
  <h3 class="UserOrderText" id="Yourtickets">Your tickets</h3>
  <!-- The 'cardholder' where all the users tickets are displayed. -->
  <div class="cardholder">
    <?php
    //Get all orders with this userid
    $userTickets = $userObject->GetUserOrderInfo($userID);
    ?><p class="UserOrderText" id="NoTicketText"><?php
    //If the user does not have any tickets yet, a message is displayed with information on where to purchase tickets
    if (empty($userTickets)) {
      echo "You currently do not have any tickets purchased. If you would like to purchase tickets, please visit the event pages.";
    }
    ?></p><?php
    //loop through all tickets with this userid
    foreach ($userTickets as $rowUserOrder) {
      //get locationID, times and bandID. All IDs are given as arguments so that the controller can tell which database method should be called
      //Its programmed this way because otherwise I had to create 3 seperate methods in the usercontroller, which would create duplicate code.
      $rowTicketInfo = $userObject->GetTicketInfo($rowUserOrder['RSessionID'], $rowUserOrder['DSessionID'], $rowUserOrder['BSessionID']);

      //defining these two variables outside the ifstatement so we can use them later
      $rowLocation;
      $rowNameIMG;
      if (isset($rowTicketInfo['RestaurantID'])) {
        //if the ticket is for a restaurant this will get the location, because the img is already here with $rowlocation
        //These are seperate methods because the database is designed to have the location of restaurants in a different table than sessions for bands/Djs
        $rowLocation = $userObject->GetTicketLocationRes($rowTicketInfo['RestaurantID']);
      }
      else {
        //if the ticket is jazz or dance we'll get the location and the name/img
        //Bandsessions/DJsessions are called with the same method because the location of both the sessions is found in the location database table
        $rowLocation = $userObject->GetTicketLocation($rowTicketInfo['LocationID']);
        //if the ticket is for a DJ or band, one of these methods is called. These are again seperate methods because the information is found in
        //seperate tables

        if (isset($rowTicketInfo['DJID'])) {
          $rowNameIMG = $userObject->GetNameAndIMG($rowTicketInfo['DJID'], null);
        }
        else if (isset($rowTicketInfo['BandID'])) {
          $rowNameIMG = $userObject->GetNameAndIMG(null, $rowTicketInfo['BandID']);
        }


      }
      ?>
      <div class="UserOrder">
        <!--Here is where we fill the ticket while we're still loopin through it -->
        <img src="../Assets/<?php
        //if the image is rowlocation is set, which means it's a restaurant, the picture is displayed for the restaurant. If the rowlocation is empty
        //the image is from a band/DJ, then the row with name/img is used
        if (isset($rowLocation['IMG'])) { echo $rowLocation['IMG'];}
        else{ echo $rowNameIMG['IMG']; }?>" class="OrderTicketPicture">
        <h1 class="UserOrderText" id="NameArtist"><?php
        //The same is done here for the name of the restaurant/band/dj
        if (isset($rowLocation['Name'])){ echo $rowLocation['Name']; }
        else{ echo $rowNameIMG['Name']; }?></h1>
        <div id="OrderNumberandNameText">
          <!-- here is where the ordernumber and name of the user who purchased the tickets is displayed -->
          <p class="UserOrderText"><?php echo "Order number: ".$rowUserOrder['OrderID']; ?></p></br></br>
          <p class="UserOrderText"><?php echo "Name: ".$rowUserOrder['FirstName']." ".$rowUserOrder['LastName']; ?></p>
        </div>
        <div id="DateandTimeText">
          <!-- this is where the date and the time of the ticket is displayed -->
          <p class="UserOrderText"><?php echo "Date: ".date('d-m-Y', strtotime($rowTicketInfo['StartTime'])) ?></p></br></br>

          <p class="UserOrderText">
            <?php
            //if the endtime is not set, the ticket is for a restaurant so there will be no endtime displayed.
            if (!isset($rowTicketInfo['EndTime'])) {
              echo "Starttime: ".date('H:i', strtotime($rowTicketInfo['StartTime']));
            }
            //if the endtime is set, the ticket is for a band/dj and the starttime until endtime is displayed
            else {
              echo "Time: ".date('H:i', strtotime($rowTicketInfo['StartTime']))." - ".date('H:i', strtotime($rowTicketInfo['EndTime']));
            } ?></p>
          </div>
          <div id="PriceandAmountText">
            <!-- Here the price and amount of tickets are displayed -->
            <p class="UserOrderText"><?php echo "Price: €".$rowUserOrder['TotalPrice']; ?></p></br></br>
            <p class="UserOrderText"><?php echo "Amount of tickets: ".$rowUserOrder['Amount']; ?></p>
          </div>
          <div id="LocationText">

            <?php
            $address; $postalCode; $city;
            //The database is set up to always have the address first, then the postal code and the city is last. They're seperated by commas
            //if the row is called address (from the database) the ticket is for a restaurant, if the row is called location it concers a band/dj
            if (isset($rowLocation['Address'])) {
              $loc = explode(",", $rowLocation['Address']);
              $address = $loc[1];
              $postalCode = $loc[2];
              $city = $loc[3];
            }
            else {
              $loc = explode(",", $rowLocation['Location']);
              $address = $loc[0];
              $postalCode = $loc[1];
              $city = $loc[2];
            }
            ?>
            <!-- here the name of the restaurant/band/dj is displayed -->
            <p class="UserOrderText"><?php if (isset($rowTicketInfo['RestaurantID'])) { echo "Venue: ".$rowLocation['Name']; }
            else { echo "Venue: ".$rowLocation['Venue']; }
            ?></p></br></br>
            <!-- this is where the location is displayed -->
            <p class="UserOrderText"><?php echo "Address: ".$address; ?></p></br></br>
            <p class="UserOrderText"><?php echo "Postal code: ".$postalCode; ?></p></br></br>
            <p class="UserOrderText"><?php echo "City: ".$city?></p>
          </div>
        </div>
      <?php } ?>
    </div>
    <!-- the footer is displayed here -->
    <div id="footer">
      <?php include_once('FooterView.php') ?>
    </div>
  </body>
  </html>

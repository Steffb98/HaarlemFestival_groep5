<!DOCTYPE html>
<?php
session_start();
session_destroy();
require '../Controller/UserController.php';
require '../Controller/IndexController.php';
//the userid of the user currently logged in is received here
$userID = $_SESSION['User_ID'];
$userObject = new UserController();
$indexObject = new IndexController();
//All tickets belonging to the logged in user are received here
$tickets = $userObject->GetTicketsWithUserID($userID);
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
  <div class="cardholder"><p class="UserOrderText" id="NoTicketText"><?php
    //If the user does not have any tickets, a message is displayed with information on where to purchase tickets
    if (empty($tickets)) {
      echo "You currently do not have any tickets purchased. If you would like to purchase tickets, please visit the event pages.";
    }
    ?></p>
    <!-- looping through all tickets -->
     <?php foreach ($tickets as $ticket) { ?>
      <div class="UserOrder">
        <img src="../Assets/<?php
        //the imagelink is received here, which will display the correct image
        echo $ticket->getIMG(); ?>" class="OrderTicketPicture">
        <h1 class="UserOrderText" id="NameArtist"><?php
        //the name of the artist/restaurant is displayed here
         echo $ticket->getName(); ?>
        <div id="OrderNumberandNameText">
          <!-- here is where the ordernumber and name of the user who purchased the tickets is displayed -->
          <p class="UserOrderText"><?php echo "Order number: ".$ticket->getOrderID(); ?></p></br>
          <p class="UserOrderText"><?php echo "Name: ".$ticket->getUser()->getFirstName()." ".$ticket->getUser()->getLastName(); ?></p></br>
        </div>
        <div id="DateandTimeText">
          <!-- this is where the date and the time of the ticket is displayed -->
          <p class="UserOrderText"><?php echo "Date: ".date('d-m-Y', strtotime($ticket->getStartTime())) ?></p></br>

          <p class="UserOrderText">
            <?php
            //Checking if the endtime for a ticket is empty, which means this ticket is for a restaurant
            if (empty($ticket->getEndTime())) {
              echo "Starttime: ".date('H:i', strtotime($ticket->getStartTime()));
            }
            //if the endtime is not empty, the ticket is for a band/dj and the starttime until endtime is displayed
            else {
              echo "Time: ".date('H:i', strtotime($ticket->getStartTime()))." - ".date('H:i', strtotime($ticket->getEndTime()));
            } ?></p>
          </div>
          <div id="PriceandAmountText">
            <!-- The price and amount of tickets are displayed here -->
            <p class="UserOrderText"><?php echo "Price: €".$ticket->getTotalPrice(); ?></p></br>
            <p class="UserOrderText"><?php echo "Amount of tickets: ".$ticket->getAmountOfTickets(); ?></p></br>
          </div>
          <div id="LocationText">

            <?php
            $address; $postalCode; $city;
            //The database is set up to always have the address first, then the postal code and the city is last. They're seperated by commas
            //this will seperate the strings when a comma is found, and put those string in seperate variables to be used later
            $loc = explode(",", $ticket->getAddress());
            $address = $loc[1];
            $postalCode = $loc[2];
            $city = $loc[3];
            ?>
            <!-- here the venue of the restaurant/band/dj is displayed -->
            <p class="UserOrderText"><?php echo "Venue: ".$ticket->getVenue();
            ?></p></br>
            <!-- this is where the location is displayed -->
            <p class="UserOrderText"><?php echo "Address: ".$address; ?></p></br>
            <p class="UserOrderText"><?php echo "Postal code: ".$postalCode; ?></p></br>
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

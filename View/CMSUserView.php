<!DOCTYPE html>
<?php
session_start();
include_once('SideBars.php');
require('../Controller/CMSUserController.php');

$loggedInUser = $_SESSION['LoggedInUser'];
if($loggedInUser->Function == 1){
  header('location: DashboardView.php');
}
?>
<html>
<head>
  <title>CMS Users</title>
  <link rel="stylesheet" href="../CSS/CMSUserStyle.css">
</head>
<body>
  <form method="get" class="Search">
    <input type="text" value="<?php if(isset($_GET['S'])){echo $_GET['S'];}?>" placeholder="<?php if(isset($_GET['S'])){echo $_GET['S'];} else{echo 'Search users';}?>" name="S">
    <button type="submit"><i class="fa fa-search"></i></button>
  </form>
  <div class="Table">
    <div class="Head">
      <p id="Name">Name</p>
      <p id="Email">Email</p>
      <p id="Ticket">Registered</p>
      <p id="UserId">UserId</p>
    </div>
    <div class="Body">
      <?php foreach ($_SESSION['CMS_UserList'] as $key => $user) { ?>
        <div>
          <form method="get">
            <input type="hidden" name="UserId" value="<?php echo $user->UserId; ?>"/>
            <input type="submit" name="Name" class="Name" value="<?php echo $user->FirstName, " ", $user->LastName; ?>"/>
          </form>
          <p id="Email"><?php echo $user->EmailAddress; ?></p>
          <p id="Ticket"><?php echo $user->RegistrationDate; ?></p>
          <p id="UserId"><?php echo $user->UserId; ?></p>
        </div>
      <?php } ?>
    </div>
  </div>

  <table class="TicketTable">
    <thead>
      <tr>
        <th>Ticket Info</th>
        <th>Event</th>
      </tr>
    </thead>
    <tbody>
      <?php if(isset($_SESSION['CMS_TicketList'])) {foreach ($_SESSION['CMS_TicketList'] as $key => $ticket) { ?>
        <tr class="Card">
          <td>
            <div id="Name"><span>Name: </span><?php echo $ticket->Name; ?></div>
            <div id="Bought"><span>Order ID: </span><?php echo $ticket->OrderID; ?></p></div>
            <div id="Ticket"><span>Ticket ID: </span><?php echo $ticket->OrderRegelID; ?></p></div>
            <div id="Ticket"><span>Amount: </span><?php echo $ticket->Amount; ?></p></div>
            <?php if ($ticket->Restaurant == "YES"): ?>
              <div>
                <a id="Edit" href="CMSUserView.php?OrdID=<?php echo $ticket->OrderRegelID."&ResID=".$ticket->SessionID?>" value="03">Edit Ticket</a>
              </div>
            <?php endif; ?>
          </td>
          <td>
            <div id="Title"><?php echo $ticket->Description."</br>".date("d-m-Y", strtotime($ticket->StartTime))."</br>".date("G:i", strtotime($ticket->StartTime)); ?></p></div>
          </td>
        </tr>
      <?php }} ?>
    </tbody>
  </table>
  <div id="Popup">
    <h1 id="Form_H1">Change ticket</h1>
    <button onclick="ClosePanel()">X</button>
    <form method="post">
      <label for="FormSession">Session</label>
      <select id="FormSession" name="CSessions"></select>
      <input type="submit" name="S" value="Change">
      <input type="submit" name="D" value="Delete Reservation">
      <input id="FormHidden" type="hidden" name="Ord" value="<?php if(isset($_GET['OrdID'])){echo $_GET['OrdID'];}?>">
    </form>
  </div>
</body>

<script>
var popup = document.getElementById("Popup");
var button = document.getElementById("Edit");
var formHeader = document.getElementById("Form_H1");
var formSession = document.getElementById("FormSession");
var formRestaurant = document.getElementById("Form_Restaurant");
var formHidden = document.getElementById("FormHidden");

if(/OrdID/.test(window.location.href)){

  popup.style.display = "block";

  <?php if(isset($_SESSION['EditSession'])){$sessions = $_SESSION['EditSession'];
    foreach ($sessions as $key) {?>
      var opt = document.createElement('option');
      opt.value = <?php echo $key->RSessionID ?>;
      opt.innerHTML = <?php echo "'".date("d-m-Y G:i", strtotime($key->StartTime))."'"; ?>;
      formSession.appendChild(opt);
      formHeader.innerHTML = <?php echo "'".$key->Name."'"; ?>;
      <?php }
    }?>
  }

  function ClosePanel(){
    popup.style.display = "none";
  }


  </script>

  </html>

<!DOCTYPE html>
<?php
session_start();
include_once('SideBars.php');
require('../Controller/MessageController.php');

?>
<html>
<head>
  <title>CMS Messages</title>
  <link rel="stylesheet" href="../CSS/MessageStyle.css">
</head>
<body>
  <form method="get" class="Search">
    <input type="text" placeholder="Search in inbox" name="S">
    <button type="submit"><i class="fa fa-search"></i></button>
  </form>
  <ul class="MessageHolder">
    <?php $messages = $_SESSION['Messages'];
    foreach ($messages as $key) {?>
      <li>
        <a class="Message" href="MessageView.php?M=<?php echo $key->MessageId;?>">
          <p id="Name"><?php if (strlen($key->Name) >= 18){echo substr($key->Name ,0,18).'...';}
          else{echo $key->Name;}?></p>
          <p id="Topic"><?php if (strlen($key->Subject) >= 28){echo substr($key->Subject ,0,28).'...';}
          else{echo $key->Subject;}?></p>
          <p id="Message"><?php if (strlen($key->Text) >= 60){echo substr($key->Text ,0,60).'...';}
          else{echo $key->Text;}?></p>
        </a>
      </li>
    <?php } ?>
  </ul>


  <?php
  if(isset($_GET["M"])){
    foreach ($messages as $key) {
      if($key->MessageId == $_GET["M"])
      {?>
        <div class="card">
          <p id="Name"><?php echo $key->Name; ?></p>
          <p id="MessageDate"><?php echo date("d-m-Y, G:i", strtotime($key->Date)); ?></p>
          <p id="Topic"><?php echo $key->Subject; ?></p>
          <p id="Message"><?php echo $key->Text; ?></p>
        </div>
      <?php }
    }
  }
  $loggedInUser = $_SESSION['LoggedInUser'];
  if($loggedInUser->Function == 3){?>
    <a id="NewMessage" href="NewMessageView.php"><i class="fas fa-plus"></i></a><?php } ?>
</body>
</html>

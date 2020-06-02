<!DOCTYPE html>
<?php
session_start();
include_once('SideBars.php');
require('../Controller/DashboardController.php');
require('../controller/UpdateController.php');
require('../controller/ActivityController.php');
require('../controller/MessageController.php');

$getUpdate = new GetUpdates();
$getUpdate->GetUpdates2();

$getActivity = new GetActivity();
$getActivity->GetActivity2();

$getMessage = new GetMessage();
$getMessage->GetMessage2();

?>
<html>
<head>
  <title>CMS Dashboard</title>
  <link rel="stylesheet" href="../CSS/ActivityStyle.css">
  <link rel="stylesheet" href="../CSS/DashboardStyle.css">
</head>
<body>
  <h1 id="ActivityDiv">Upcoming Activity</h1>
  <?php $days = $_SESSION['days'];
  if($days != NULL){
    foreach ($days as $key1) {
      if ($key1 != NULL){  ?>
        <div class="card" id="ActivityCard">
          <h2><?php if($key1 != NULL){echo date("l d F", strtotime($key1[0]->Time));} ?></h2>
          <?php foreach ($key1 as $key){?>
            <div class="TimeActivity">
              <a><?php echo date("H:i",strtotime($key->Time)); ?></a>
              <i class="far fa-circle"></i>
              <div id="Description">
                <a><?php echo $key->Description; ?></a>
                <a id="DLocation"><?php echo "<br/>", "Aanwezig bij: ", $key->Location; ?></a>
              </div>
            </div>
          <?php } ?>
        </div>
      <?php }
      break;
    }
  }
  else{?>
    <div class="card" id="ActivityCard">
      <h2>no activities yet</h2>
    </div>
  <?php } ?>

  <?php $updates = $_SESSION['Updates'];
  foreach ($updates as $key) {?>
    <h1 id="UpdateDiv">Latest Update</h1>
    <section class="card" id="UpdateCard">
      <h2><?php if($key->Sort == 0){echo "News:";} else{echo "Update:";} ?></h2>
        <p id="Date"><?php echo date("d-m-Y", strtotime($key->Date)); ?></p>
        <p><?php echo $key->Text; ?></p>
      </section>
      <?php break;
    }

    $messages = $_SESSION['Messages'];
    foreach ($messages as $key) {?>
      <h1 id="MessageDiv">Latest Message</h1>
      <div class="card" id="MessageCard">
        <h2><?php echo $key->Name; ?></h2>
        <p id="Topic"><?php echo $key->Subject; ?></p>
        <p id="Date"><?php echo date("d-m-Y, h:m", strtotime($key->Date)); ?></p>
        <p id="Message"><?php echo $key->Text; ?></p>
      </div>
      <?php break;
    }?>
  </body>
  </html>

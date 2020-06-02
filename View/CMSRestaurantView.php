<!DOCTYPE html>
<?php
session_start();
include_once('SideBars.php');
require('../Controller/CMSRestaurantController.php');
if($loggedInUser->Function != 3){
  header('location: DashboardView.php');
}
?>
<html>
<head>
  <title>CMS Restaurant Schedule</title>
  <link rel="stylesheet" href="../CSS/CMSRestaurantStyle.css">
</head>
<body>
  <form method="get" class="Search">
    <input type="text" value="<?php if(isset($_GET['S'])){echo $_GET['S'];}?>" placeholder="<?php if(isset($_GET['S'])){echo $_GET['S'];} else{echo 'Search activities';}?>" name="S">
    <button type="submit"><i class="fa fa-search"></i></button>
  </form>
  <div class="ScrollTable" id="RestaurantTable">
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Adress</th>
          <th>Stars</th>
          <th>Price</th>
          <th>Type</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $RestaurantList = $_SESSION['ScheduleRestaurant'];
        foreach ($RestaurantList as $key){ ?>
          <tr>
            <td><?php echo $key->Name; ?></td>
            <td><?php echo $key->Location; ?></td>
            <td><?php echo $key->Stars; ?></td>
            <td><?php echo $key->Price; ?></td>
            <td id="TypeFood"><?php echo $key->Kitchen; ?></td>
            <td><a href="CMSRestaurantView.php?EventId=<?php echo $key->RestaurantID;?>"><i class="fas fa-edit"></i></a></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>



  <?php if (isset($_GET['EventId'])): ?>
    <div id="EditPopup">
      <h1>change information: <?php $editR = $_SESSION['ChangeRestaurant']; echo $editR->Name;?> </h1>
      <form method="post">
        <p>Name: <input type="text" name="Name" value="<?php echo $editR->Name ?>"/></p>
        <p>Kitchen: <input type="text" name="Kitchen" value="<?php echo $editR->Kitchen ?>"/></p>
        <p>Stars: <input type="text" name="Stars" value="<?php echo $editR->Stars ?>"/></p>
        <p>Fish: <input type="checkbox" name="Fish" <?php if($editR->Fish){echo "Checked";} ?>/></p>
        <p>text: <input type="text" name="Text" value="<?php echo $editR->Text ?>"/></p>
        <p>Price: <input type="text" name="Price" value="<?php echo $editR->Price ?>"/></p>
        <p>Location: <textarea name="Location" cols="20" rows="3"><?php echo $editR->Location;  ?></textarea></p>
        <?php if($_SESSION['RestaurantChangeErr'] != ''){echo "<p> <i class='fas fa-exclamation'></i> ".$_SESSION['RestaurantChangeErr']."</p>";}?>
        <input type="submit" name="Submit" value="Submit">
        <input type="submit" name="Submit" value="Delete">
        <input type="submit" name="Submit" value="Cancel">
        <input type="hidden" name="RestaurantID" value="<?php echo $_GET['EventId']; ?>">
        <div class="Sessions">
          <?php $sessions = $_SESSION['ChangeRestaurantSessions'];
          for ($i=0; $i < Count($sessions); $i++) {?>
            <p id="SessionNumber">Session <?php echo ($i + 1);?>: <?php echo date("D d-m", strtotime($sessions[$i]->StartTime)); ?></p>
            <p>date: <input name="Date<?php echo $sessions[$i]->RSessionId;?>" type="date" min="2020-07-26" max="2020-07-29" value="<?php echo date('Y-m-d',strtotime($sessions[$i]->StartTime));?>"/></p>
            <p>Time: <input name="Time<?php echo $sessions[$i]->RSessionId;?>" type="time" value="<?php echo date('G:i',strtotime($sessions[$i]->StartTime));?>"/></p>
            <p>Duration: <input name="Duration<?php echo $sessions[$i]->RSessionId;?>" type="number" value="<?php echo $sessions[$i]->Duration;?>"/></p>
            <p>MaxSeats: <input name="MaxSeats<?php echo $sessions[$i]->RSessionId;?>" type="number" value="<?php echo $sessions[$i]->MaxSeats;?>"/></p>
          <?php } ?>
        </div>
      </form>
    </div>
  <?php endif; ?>

  <?php if(isset($_SESSION['RestaurantaValues'])){$aValues = $_SESSION['RestaurantaValues'];}?>
  <div id="NewEventPopup">
    <h1>Add restaurant</h1>
    <form method="post">
      <div>
        <label for="NewName">Restaurant name</label>
        <input type="text" id="NewName" value="<?php if(isset($aValues)){echo $aValues[0];} ?>" name="NewName">
      </div>
      <div>
        <label for="NewStreet">Street name</label>
        <input type="text" id="NewStreet" value="<?php if(isset($aValues)){echo $aValues[1];} ?>" name="NewStreet">
      </div>
      <div>
        <label for="NewPostalCode">Postal Code</label>
        <input type="text" id="NewPostalCode" value="<?php if(isset($aValues)){echo $aValues[2];} ?>" name="NewPostalCode">
      </div>
      <div>
        <label for="NewText">Text</label>
        <textarea type="text" id="NewText" name="NewText"><?php if(isset($aValues)){echo $aValues[3];} ?></textarea>
      </div>
      <div>
        <label for="NewKitchen">Kitchen</label>
        <input type="text" id="NewKitchen" value="<?php if(isset($aValues)){echo $aValues[4];} ?>" name="NewKitchen">
      </div>
      <div>
        <label for="NewStars">Stars</label>
        <input type="text" id="NewStars" value="<?php if(isset($aValues)){echo $aValues[5];} ?>" name="NewStars">
      </div>
      <div>
        <label for="NewPrice">Price</label>
        <input type="text" id="NewPrice" value="<?php if(isset($aValues)){echo $aValues[6];} ?>" name="NewPrice">
      </div>
      <div>
        <label for="NewFish">Fish</label>
        <input type="checkbox" id="NewFish" name="NewFish" <?php if(isset($aValues)){if($aValues[7] == 1){echo "Checked";}} ?>>
      </div>
      <?php if(isset($_SESSION['RestaurantAErr'])){if($_SESSION['RestaurantAErr'] != ''){echo "<p> <i class='fas fa-exclamation'></i> ".$_SESSION['RestaurantAErr']."</p>";}}?>
      <input type="submit" name="ASubmit" value="Submit">
      <input type="submit" name="ASubmit" value="Cancel">
    </form>
  </div>
</body>
<script type="text/javascript">
editPopup = document.getElementById("EditPopup");
NewEventPopup = document.getElementById("NewEventPopup")

if(/EventId/.test(window.location.href)){
  editPopup.scrollIntoView();
  NewEventPopup.style.top="105vw";
}
else{
  editPopup.style.opacity="0";
  editPopup.style.pointerEvents="none";
}
</script>
</html>

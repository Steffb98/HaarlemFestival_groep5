<!DOCTYPE html>
<?php
session_start();
include_once('SideBars.php');
require('../Controller/ScheduleController.php');
if($loggedInUser->Function != 3){
  header('location: DashboardView.php');
}
?>
<html>
<head>
  <title>CMS Schedule</title>
  <link rel="stylesheet" href="../CSS/ScheduleStyle.css">
</head>
<body>
  <div class="ChooseEvent">
    <button onclick="javascript:OpenJazzTable();" id="Jazz" type="button" name="button">Jazz</button>
    <button onclick="javascript:OpenDanceTable();" id="Dance" type="button" name="button">Dance</button>
  </div>
  <div class="ScrollTable" id="DanceTable">
    <table id="DanceTable">
      <thead>
        <tr>
          <th>Artist</th>
          <th>Date</th>
          <th>Time</th>
          <th>Location</th>
          <th>Price</th>
          <th>Seats</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php $DanceList = $_SESSION['ScheduleDance'];
        foreach ($DanceList as $key){ ?>
          <tr>
            <td><?php echo $key->Name; ?></td>
            <td><?php echo date("d-m-Y",strtotime($key->StartTime)); ?></td>
            <td><?php echo date("H:i",strtotime($key->StartTime))."-".date("H:i",strtotime($key->EndTime)) ?></td>
            <td><?php echo $key->Venue; ?></td>
            <td><?php echo "€".$key->Price.",-"; ?></td>
            <td><?php echo $key->MaxSeats; ?></td>
            <td><a href="<?php echo "ScheduleView.php?EventId=".$key->DSessionId."&Event=Dance";?>" class="fas fa-edit"></a></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <div class="ScrollTable" id="JazzTable">
    <table id="DanceTable">
      <thead>
        <tr>
          <th>Artist</th>
          <th>Date</th>
          <th>Time</th>
          <th>Location</th>
          <th>Price</th>
          <th>Seats</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php $JazzList = $_SESSION['ScheduleJazz'];
        foreach ($JazzList as $key){ ?>
          <tr>
            <td><?php echo $key->Name; ?></td>
            <td><?php echo date("d-m-Y",strtotime($key->StartTime)); ?></td>
            <td><?php echo date("H:i",strtotime($key->StartTime))."-".date("H:i",strtotime($key->EndTime)) ?></td>
            <td><?php echo $key->Venue; ?></td>
            <td><?php echo "€".$key->Price.",-"; ?></td>
            <td><?php echo $key->MaxSeats; ?></td>
            <td><a href="<?php echo "ScheduleView.php?EventId=".$key->BSessionId."&Event=Jazz";?>" class="fas fa-edit"></a></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>


  <?php if(isset($_GET['EventId'])){?>
    <div id="EditPopup">
      <h1>change information: <?php $editEvent = $_SESSION['ScheduleEditEvent']; echo $editEvent->Name;?> </h1>
      <form method="post">
        <div>
          <label for="EditStartDate">Start Date</label>
          <input type="date" id="EditStartDate" name="StartDate" value="<?php echo date("Y-m-d",strtotime($editEvent->StartTime)); ?>" min="2020-07-26" max="2020-07-29">
          <label for="EditStartTime">Start Time</label>
          <input type="time" id="EditStartTime" name="StartTime" value="<?php echo date("H:i",strtotime($editEvent->StartTime)); ?>" required>
        </div>
        <div>
          <label for="EditEndDate">End Date</label>
          <input type="date" id="EditEndDate" name="EndDate" value="<?php echo date("Y-m-d",strtotime($editEvent->EndTime)); ?>" min="2020-07-26" max="2020-07-29">
          <label for="EditEndTime">End Time</label>
          <input type="time" id="EditEndTime" name="EndTime" value="<?php echo date("H:i",strtotime($editEvent->EndTime)); ?>" required>
        </div>
        <div>
          <?php $editEventFilter = $_SESSION['ScheduleEditEventFilters']; ?>
          <label for="EditLocation">Location</label>
          <select id="EditLocation" class="" name="EditLocation">
            <?php foreach ($editEventFilter as $key){
              echo "<option value=".$key->LocationID; if($key->Venue == $editEvent->Venue){echo " Selected=Selected";} echo ">".$key->Venue."</option>";
            } ?>
          </select>
        </div>
        <div>
          <label for="EditPrice">Price</label>
          <input type="text" name="Price" id="EditPrice" value="<?php echo $editEvent->Price; ?>" required>
        </div>
        <label for="EditSeats">Seats</label>
        <input type="text" name="Seats" id="EditSeats" value="<?php echo $editEvent->MaxSeats; ?>" required>
        <div>
        </div>
        <div>
          <p><?php if(isset($_SESSION['ScheduleCERR'])){echo $_SESSION['ScheduleCErr'];} ?></p>
          <input type="submit" name="SubmitChanges" value="Change">
          <input type="submit" onclick="Alert(<?php echo $editEvent->Name;?>)" name="SubmitChanges" value="Delete">
          <input type="submit" name="SubmitChanges" value="Cancel">
          <input type="hidden" name="Id" value="<?php echo $editEvent->SessionId ?>">
        </div>
      </form>
    </div>
  <?php }
  if(isset($_SESSION['ScheduleNValues'])){$nValues = $_SESSION['ScheduleNValues'];}?>
  <div id="NewEventPopup">
    <h1>New Event</h1>
    <form method="post">
      <div>
        <label for="NewArtist">Artist</label>
        <?php $artists = GetArtists(); ?>
        <select id="NewArtist" name="NewArtist">
          <?php foreach ($artists as $key){
            echo "<option value=".$key->ID."-".$key->Type; if(isset($nValues)){if($nValues[0] == $key->ID."-".$key->Type){echo " Selected=Selected";}} echo ">".$key->Name."</option>";
          } ?>
        </select>
      </div>
      <div>
        <label for="NewStartDate">Start Date</label>
        <input type="date" id="NewStartDate" name="NewStartDate" value="<?php if(isset($nValues)){if($nValues[1] != ''){ echo date("Y-m-d", strtotime($nValues[1]));}} ?>" min="2020-07-26" max="2020-07-29">
        <label for="NewStartTime">Start Time</label>
        <input type="time" id="NewStartTime" name="NewStartTime" value="<?php if(isset($nValues)){if($nValues[2] != ''){ echo date("H:i", strtotime($nValues[2]));}} ?>" required>
        </div>
        <div>
          <label for="NewEndDate">End Date</label>
          <input type="date" id="NewEndDate" name="NewEndDate" value="<?php if(isset($nValues)){if($nValues[3] != ''){ echo date("Y-m-d", strtotime($nValues[3]));}} ?>" min="2020-07-26" max="2020-07-29">
          <label for="NewEndTime">End Time</label>
          <input type="time" id="NewEndTime" name="NewEndTime" value="<?php if(isset($nValues)){if($nValues[4] != ''){ echo date("H:i", strtotime($nValues[4]));}} ?>" required>
          </div>
          <div>
            <?php GetEventLocation();
            $editEventFilter = $_SESSION['ScheduleEditEventFilters']; ?>
            <label for="NewLocation">Location</label>
            <select id="NewLocation" class="" name="NewLocation">
              <?php foreach ($editEventFilter as $key){
                echo "<option value=".$key->LocationID; if(isset($nValues)){if($nValues[5] == $key->LocationID){echo " Selected=Selected";}} echo ">".$key->Venue."</option>";
              } ?>
            </select>
          </div>
          <div>
            <label for="NewPrice">Price</label>
            <input type="text" name="NewPrice" id="NewPrice" value="<?php if(isset($nValues)){echo $nValues[6];} ?>" placeholder="use ' . ' for seperation" required>
          </div>
          <div>
            <label for="NewSeats">Seats</label>
            <input type="text" name="NewSeats" id="NewSeats" value="<?php if(isset($nValues)){echo $nValues[7];} ?>" required>
          </div>
          <div>
            <p><?php if(isset($_SESSION['ScheduleNERR'])){echo $_SESSION['ScheduleNERR'];} ?></p>
            <input type="submit" name="SubmitNew" value="Submit">
            <input type="submit" name="SubmitNew" value="Cancel">
          </div>
        </form>
      </div>
    </body>
    <script>
    var jazzTable = document.getElementById("JazzTable");
    var danceTable = document.getElementById("DanceTable");
    var editPopup = document.getElementById("EditPopup");

    function OpenJazzTable(){
      jazzTable.style.pointerEvents = "auto";
      jazzTable.style.opacity = "1";

      danceTable.style.pointerEvents = "none";
      danceTable.style.opacity = "0";
    }

    function OpenDanceTable(){
      danceTable.style.pointerEvents = "auto";
      danceTable.style.opacity = "1";

      jazzTable.style.pointerEvents = "none";
      jazzTable.style.opacity = "0";
    }

    function OpenEditPopup(SessionId){
      editPopup.style.pointerEvents = "auto";
      editPopup.style.opacity = "1";
      var editBand = document.getElementById("EditBand");
      editBand.options[editBand.options.length] = new Option('', 'Value1');
      editPopup.scrollIntoView();
    }

    if(/Dance/.test(window.location.href)){
      danceTable.style.pointerEvents = "auto";
      danceTable.style.opacity = "1";
      editPopup.scrollIntoView();
    }

    if(/Jazz/.test(window.location.href)){
      jazzTable.style.pointerEvents = "auto";
      jazzTable.style.opacity = "1";
      editPopup.scrollIntoView();
    }

    </script>
    </html>

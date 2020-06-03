<!DOCTYPE html>
<?php
session_start();
include_once('SideBars.php');
require('../Controller/ActivityAEController.php');
$activityAE = new ActivityAE;
//check user rank, this is present in all files,
//in this case, the logged in user must be rank 3 to access ActivityAEView page
if($loggedInUser->Function != 3){
  header('location: DashboardView.php');
}
?>
<html>
<head>
  <title>CMS Edit Activity</title>
  <link rel="stylesheet" href="../CSS/ActivityAEStyle.css">
  <script src="https://kit.fontawesome.com/ddad9acd2b.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400&display=swap" rel="stylesheet">
  <link rel="shortcut icon" type="image/png" href="../Assets/favicon.png"/>
</head>
<body>
  <form method="get" class="Search">
    <input type="text" value="<?php if(isset($_GET['S'])){echo $_GET['S'];}?>" placeholder="<?php if(isset($_GET['S'])){echo $_GET['S'];} else{echo 'Search activities';}?>" name="S">
    <button type="submit"><i class="fa fa-search"></i></button>
  </form>
  <div class="scrolltable">
    <table class="ActivityTable">
      <thead>
        <tr>
          <th>Activity Description</th>
          <th>Details</th>
        </tr>
      </thead>
      <tbody>
        <?php
        //get the array with activities
        $activityArray = $_SESSION['ActivityAEActivities'];
        //foreach activity create a table row
        foreach ($activityArray as $key) { ?>
          <tr>
            <!-- insert the required information into the textfields of html or something along those lines -->
            <td <?php if(isset($_GET['ActID'])){if($_GET['ActID'] == $key->getActivityId()){echo "style=background-color:#e2e2e2";}} ?>><?php echo $key->getDescription() ?></td>
              <td>
                <div class="DetailSection">
                  <p><span>Date:  </span><?php echo date("D, F j Y" , strtotime($key->getTime())); ?></p>
                  <p><span>Time:  </span><?php echo date("G:i" , strtotime($key->getTime())); ?></p>
                  <p><span>Volunteers still Required:  </span><?php echo $key->getVolunteersRequired()." (".$key->getAmountOfVolunteers().")"; ?></p>
                </div>
                <div class="ButtonSection">
                  <button id="Edit" onclick="OpenEditPanel(<?php echo $key->getActivityId(); ?>)" value="nogniks">Edit</button>
                  <a id="Assign" href="ActivityAEView.php?ActID=<?php echo $key->getActivityId(); ?>" onclick="OpenAssignPanel()" value="nogniks">Assign Volunteers</a>
                </div>
              </td>
            </tr>
            <?php
          }
          ?>
        </tbody>
      </table>
    </div>

    <!-- section for creating a new activity-->
    <section class="NewActivity">
      <h2>NewActivity</h2>
      <form method="post">
        <?php
        if(isset($_SESSION['ActivityAENAErr'])) {$NewActivityErr = $_SESSION['ActivityAENAErr'];}
        if(isset($_SESSION['ActivityAENAData'])){$NewActivityData= $_SESSION['ActivityAENAData'];}
        ?>
        <p>Activity Description <input type="text" name="AcDescription" value="<?php if(isset($NewActivityData)){echo $NewActivityData[0];} ?>" required></p>
        <p>Date <input type="text" name="AcDate" placeholder="dd-mm-yyyy" value="<?php if(isset($NewActivityData)){echo $NewActivityData[1];} ?>" required></p>
        <p>StartTime <input type="text" name="AcStartTime" placeholder="hh-mm" value="<?php if(isset($NewActivityData)){echo $NewActivityData[2];} ?>" required></p>
        <p>Volunteers req. <input type="text" name="AcVolReq" value="<?php if(isset($NewActivityData)){echo $NewActivityData[3];} ?>" required></p>
        <p>Location <input type="text" name="AcLocation" value="<?php if(isset($NewActivityData)){echo $NewActivityData[4];} ?>" required></p>
        <p id="NAError"><?php if(isset($_SESSION['ActivityAENAErr'])){echo $NewActivityErr;} ?></p>
        <input type="submit" name="Submit" value="Add Activity">
      </form>
    </section>

    <!-- section for changing an activity-->
    <section id="ChangeActivity">
      <h2>Change Activity</h2>
      <button type="button" name="exit" onclick="CloseEditPanel()" id="ExitButton">X</button>
      <form method="post">
        <?php
        if(isset($_SESSION['ActivityAEEditActivity'])) {$editActivity = $_SESSION['ActivityAEEditActivity'];}
        if(isset($_SESSION['ActivityAECAErr'])) {$editActivityErr = $_SESSION['ActivityAECAErr'];}
        ?>
        <p>Activity Description <input type="text" name="AcDescription" value="<?php if(isset($editActivity)){echo $editActivity->Description;} ?>"required></p>
        <p>Date <input type="text" name="AcDate" placeholder="dd-mm-yyyy" value="<?php if(isset($editActivity)){echo date("d-m-Y", strtotime($editActivity->Time));}?>" required></p>
        <p>StartTime <input type="text" name="AcStartTime" placeholder="hh-mm" value="<?php if(isset($editActivity)){echo date("H:i", strtotime($editActivity->Time));
        }?>" required></p>
        <p>Volunteers req. <input type="text" name="AcVolReq" value="<?php if(isset($editActivity)){echo $editActivity->AmountOfVolunteers;}?>" required></p>
        <p>Location <input type="text" name="AcLocation" value="<?php if(isset($editActivity)){echo $editActivity->Location;}?>" required></p>
        <p id="CAError"><?php if(isset($_SESSION['ActivityAECAErr'])){echo $editActivityErr;} ?></p> <!-- change activity text neerzettten ipv newactivyt text-->
        <input type="submit" name="CASubmit" value="Change">
        <input type="submit" name="Delete" value="Delete" formnovalidate>
      </form>
    </section>

<!--
section for assigning volunteers to a job
in the foreach loop, list every volunteer who is able to hel
make the name a button so if the volunteername is pressed, add him to the Activity
if the volunteer is already helping, the name will be coloured blue, if not it is white,
if a blue volunteers is pressed it will turn white and vice versa-->
    <section id="AssignVolunteers">
      <h2>Assign Volunteers</h2>
      <button type="button" name="exit" onclick="CloseAssignPanel()" id="ExitButton">X</button>
      <div class="scrolltable2">
        <table class="VolunteerTable">
          <thead>
            <tr>
              <th>Volunteer</th>
              <th>Rank</th>
              <th>Tasks</th>
            </tr>
          </thead>
          <tbody>
            <?php $volunteers = $activityAE->GetVolunteers();
            if(isset($_SESSION['ActvitiyVolunteers'])){
              $volunteersByActivity = $_SESSION['ActvitiyVolunteers'];
              foreach ($volunteers as $key) {?>
                <tr>
                  <td>
                    <form method="post">
                      <input type="submit" name="AssignVolunteerName" value="<?php echo $key->FirstName." ".$key->LastName;?>"
                      <?php foreach ($volunteersByActivity as $key2){
                        if($key->VolunteerID == $key2->VolunteerID){
                          echo "style=background-color:#6bdbdb";
                        }
                      }?>>
                      <input type="hidden" name="AssignVolunteerId" value="<?php echo $key->VolunteerID ;?>">
                    </form>
                  </td>
                  <td><?php echo $key->Function; ?></td>
                  <td><?php echo $key->Activities; ?></td>
                </tr>
              <?php }
            }?>
          </tbody>
        </table>
      </div>
    </section>
  </body>

  <script>
  var editPopup = document.getElementById("ChangeActivity");
  var assignPopup = document.getElementById("AssignVolunteers");
  var users = [];
  //open popup bla bla bla
  if (!/ActivityId/.test(window.location.href)){
    editPopup.style.pointerEvents = "none";
    editPopup.style.opacity = "0.5";
  }

  if(/ActivityId/.test(window.location.href)){
    editPopup.scrollIntoView();
  }

  if(/ActID/.test(window.location.href)){
    OpenAssignPanel();
  }

  function OpenEditPanel(AcitivityId) {
    editPopup.style.pointerEvents = "auto";
    editPopup.style.opacity = "1";
    window.location.href = "ActivityAEView.php?ActivityId=" + AcitivityId;
  }

  function OpenAssignPanel() {
    assignPopup.style.pointerEvents = "auto";
    assignPopup.style.opacity = "1";
    assignPopup.scrollIntoView();
  }

  function CloseEditPanel(){
    editPopup.style.pointerEvents = "none";
    editPopup.style.opacity = "0.5";
    var location = window.location.href;
    window.location.href = location.replace('ActivityId=','');

  }
  function CloseAssignPanel(){
    assignPopup.style.pointerEvents = "none";
    assignPopup.style.opacity = "0.5";
  }
  </script>
  </html>

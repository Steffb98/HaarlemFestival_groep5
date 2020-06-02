<?php
if(isset($_SESSION['LoggedInUser'])){
  $loggedInUser = $_SESSION['LoggedInUser'];
}
else{
  header("location: LoginView.php");
}
if($loggedInUser->NewAccount == 1){
  header('location: EditAccountView.php');
}
?>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../CSS/SideBars.css">
  <script src="https://kit.fontawesome.com/ddad9acd2b.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400&display=swap" rel="stylesheet">
  <link rel="shortcut icon" type="image/png" href="../Assets/favicon.png"/>
</head>
<body>
  <div class="UserInfo">
    <div class="UserInfoName">
      <a><?php echo $loggedInUser->FirstName." ".$loggedInUser->LastName; ?></a>
    </div>
    <div id="Barrier-Line"></div>
    <a class="Button" href="EditAccountView.php">Edit Account</a>
    <a class="Button" href="LoggOff.php">Log off</a>
  </div>
  <nav>
    <li><div id="Dashboard" class="NavItem"><a href="../View/DashboardView.php">Dashboard</a></div></li>
    <li><div id="Message" class="NavItem"><a href="../View/MessageView.php">Messages</a></div></li>
    <li><div id="Update" class="NavItem"><a href="../View/UpdateView.php">Updates</a></div></li>
    <li><div id="Activity" class="NavItem"><a href="../View/ActivityView.php">Activities</a></div></li>
    <?php if ($loggedInUser->Function >= 2){ ?>
    <li><div id="User" id="LastNavItem" class="NavItem"><a href="../View/CMSUserView.php">Users</a></div></li><?php } ?>
    <?php if ($loggedInUser->Function == 3){ ?>
      <a id="Barrier" class="AddEdit">Add/Edit</a>
      <li><div id="Information" class="NavItem"><a class="AddEdit" href="../View/InformationView.php">Information -</a></div></li>
      <li><div id="Restaurant" class="NavItem"><a class="AddEdit" href="../View/CMSRestaurantView.php">Restaurants -</a></div></li>
      <li><div id="Schedule" class="NavItem"><a class="AddEdit" href="../View/ScheduleView.php">Schedules -</a></div></li>
      <li><div id="UpdateAE" class="NavItem"><a class="AddEdit" href="../View/UpdateAEView.php">Updates -</a></div></li>
      <li><div id="ActivityAE" class="NavItem"><a class="AddEdit" href="../View/ActivityAEView.php">Activities -</a></div></li>
      <li><div id="Volunteer" class="NavItem"><a class="AddEdit" href="../View/VolunteerView.php">Volunteers -</a></div></li>
      <li><div id="Revenue" class="NavItem"><a class="AddEdit" href="../View/RevenueView.php">Revenue -</a></div></li>
    <?php } ?>
  </nav>
  <div class="TopBar">
    <img src="../Assets/Haarlem_Festival_Logo.png" alt="">
    <a id="Date"><?php echo date("l")."</br>".date("d F Y"); ?></a>
  </div>
</body>
<script>
if(/DashboardView/.test(window.location.href)){
  document.getElementById("Dashboard").style.backgroundColor = "#343a42";
}
else if(/MessageView/.test(window.location.href)){
  document.getElementById("Message").style.backgroundColor = "#343a42";
}
else if(/UpdateView/.test(window.location.href)){
  document.getElementById("Update").style.backgroundColor = "#343a42";
}
else if(/ActivityView/.test(window.location.href)){
  document.getElementById("Activity").style.backgroundColor = "#343a42";
}
else if(/CMSUserView/.test(window.location.href)){
  document.getElementById("User").style.backgroundColor = "#343a42";
}
else if(/InformationView/.test(window.location.href)){
  document.getElementById("Information").style.backgroundColor = "#343a42";
}
else if(/RestaurantView/.test(window.location.href)){
  document.getElementById("Restaurant").style.backgroundColor = "#343a42";
}
else if(/ScheduleView/.test(window.location.href)){
  document.getElementById("Schedule").style.backgroundColor = "#343a42";
}
else if(/UpdateAEView/.test(window.location.href)){
  document.getElementById("UpdateAE").style.backgroundColor = "#343a42";
}
else if(/ActivityAEView/.test(window.location.href)){
  document.getElementById("ActivityAE").style.backgroundColor = "#343a42";
}
else if(/VolunteerView/.test(window.location.href)){
  document.getElementById("Volunteer").style.backgroundColor = "#343a42";
}
else if(/Revenue/.test(window.location.href)){
  document.getElementById("Revenue").style.backgroundColor = "#343a42";
}
</script>
</html>

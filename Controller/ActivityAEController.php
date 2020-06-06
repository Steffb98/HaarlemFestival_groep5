<?php
require_once '../DAL/ActivityAEDAL.php';
require_once '../Model/ActivityModel.php';

class ActivityAE
{
    function AddActivity()
    {
        global $activityAE;
        $AcDescription = $_POST['AcDescription'];
        $AcDate = $_POST['AcDate'];
        $AcStartTime = $_POST['AcStartTime'];
        $AcVolReq = $_POST['AcVolReq'];
        $AcLocation = $_POST['AcLocation'];

        //make an error variable,
        //make an checker variable,
        //while $checker is true, enter every if, if the value is not valid, set the checker to false, generate err msg,
        //and break out of the loop, this way not every if statement has to be walked through->efficient
        //if the checker is false(invalid input), put the error msg in a session,
        //return the values into the input boxes so the user won't have to type it again.
        //if the checker is true(all valid inputs), empty the inputs, empty the err, reload page and add the valid inputs to the DB
        $err = '';
        $checker = true;
        if (!$activityAE->ValidateInput($AcDescription)) {
            $checker = false;
            $err = 'Invalid description';
        } else if (!$activityAE->ValidateInputDate($AcDate)) {
            $checker = false;
            $err = 'Invalid date, write as: dd-mm-yyyy ';
        } else if (!$activityAE->ValidateInputTime($AcStartTime)) {
            $checker = false;
            $err = 'Invalid start time, write as hh:mm';
        } else if (!is_numeric($AcVolReq)) {
            $checker = false;
            $err = 'Invalid volunteer number, make sure only numbers are used';
        } else if (!$activityAE->ValidateInput($AcLocation)) {
            $checker = false;
            $err = 'Invalid Location, use only text, numbers, hyphons or colons';
        }

        if ($checker == false) {
            $_SESSION['ActivityAENAErr'] = $err; //activity; AE=add&edit; NA=New Activity; Err=Error;
            $_SESSION['ActivityAENAData'] = array($AcDescription, $AcDate, $AcStartTime, $AcVolReq, $AcLocation);
        } else {
            CMS_AddActivity($AcDescription, $AcDate, $AcStartTime, $AcVolReq, $AcLocation);
            header("Location: ActivityAEView.php");
            $_SESSION['ActivityAENAData'] = array('', '', '', '', '');
            $_SESSION['ActivityAENAErr'] = ''; //activity; AE=add&edit; NA=New Activity; Err=Error;
        }
    }

    function ChangeActivity()
    {
        global $activityAE;
        $CADescription = $_POST['AcDescription'];
        $CADate = $_POST['AcDate'];
        $CAStartTime = $_POST['AcStartTime'];
        $CAVolReq = $_POST['AcVolReq'];
        $CALocation = $_POST['AcLocation'];
        $CAID = $_GET['ActivityId'];

        //make an error variable,
        //make an checker variable,
        //while $checker is true, enter every if, if the value is not valid, set the checker to false, generate err msg,
        //and break out of the loop, this way not every if statement has to be walked through->efficient
        //if the checker is false(invalid input), put the error msg in a session,
        //return the values into the input boxes so the user won't have to type it again.
        //if the checker is true(all valid inputs), empty the inputs, empty the err, reload page and add the valid inputs to the DB
        $err = '';
        $checker = true;
        if (!$activityAE->ValidateInput($CADescription)) {
            $checker = false;
            $err = 'Invalid description';
        } else if (!$activityAE->ValidateInputDate($CADate)) {
            $checker = false;
            $err = 'Invalid date, use hyphons';
        } else if (!$activityAE->ValidateInputTime($CAStartTime)) {
            $checker = false;
            $err = 'Invalid start time, use colons';
        } else if (!is_numeric($CAVolReq)) {
            $checker = false;
            $err = 'Invalid volunteer number, make sure only numbers are used';
        } else if (!is_numeric($CAID)) {
            $checker = false;
            header("location: ActivityAEView.php" . $CAID);
        } else if (!$activityAE->ValidateInput($CALocation)) {
            $checker = false;
            $err = 'Invalid Location, use only text, numbers, hyphons or colons';
        }

        if ($checker == false) {
            $_SESSION['ActivityAECAErr'] = $err; //activity; AE=add&edit; CA=Change Activity; Err=Error;
        } else {
            CMS_EditActivity($CADescription, $CADate, $CAStartTime, $CALocation, $CAVolReq, $_GET['ActivityId']);
            unset($_SESSION['ActivityAEEditActivity']);
            $_SESSION['ActivityAECAErr'] = ''; //activity; AE=add&edit; CA=Change Activity; Err=Error;
            echo "<script>CloseEditPanel();</script>";
            header("location: ActivityAEView.php?");
        }
    }

    function GetActivity()
    {
        if (is_numeric($_GET['ActivityId'])) {
            $_SESSION['ActivityAEEditActivity'] = GetActivities($_GET['ActivityId'], true);
        } else {
            header("location: ActivityAEView.php");
        }
    }

    function GetVolunteers()
    {
        return CMS_GetVolunteers();
    }

    function DeleteActivity()
    {
        CMS_DeleteActivity($_GET['ActivityId']);
        echo "<script>CloseEditPanel();</script>";
        header("location: ActivityAEView.php?");
    }

    function AssignVolunteer()
    {
      //get all volunteers
        $volunteerList = $_SESSION['ActvitiyVolunteers'];

        $checker = true;
        //for each volunteer
        foreach ($volunteerList as $key) {
            if ($key->VolunteerID == $_POST['AssignVolunteerId']) {
                $checker = false;
                CMS_DeleteActivityVolunteer($key->VolunteerID, $_GET['ActID']);
            }
        }
        if ($checker == true) {
            CMS_AddActivityVolunteer($_POST['AssignVolunteerId'], $_GET['ActID']);
        }
        //reload page
        header('location: ActivityAEView.php?ActID=' . $_GET['ActID']);
    }

    //validate input
    function ValidateInput($input)
    {
        if (!preg_match('/[^A-z_\-:!?,.0-9"  *"]/i', $input)) {
            return true;
        }
        return false;
    }

    //validate input date
    function ValidateInputDate($input)
    {
        if (preg_match('/^([0-2][0-9]|(3)[0-1])(\-)(((0)[0-9])|((1)[0-2]))(\-)\d{4}$/i', $input)) {
            return true;
        }
        return false;
    }

    //you guessed it, validate input time
    function ValidateInputTime($input)
    {
        if (preg_match('/^$|^(([01][0-9])|(2[0-3])):[0-5][0-9]$/', $input)) {
            return true;
        }
        return false;
    }
}

$activityAE = new ActivityAE;

//if user searches something, a get value is collected
//this value is passed to the database and filters the restults
if (isset($_GET['S'])) {
    $_SESSION['ActivityAEActivities'] = GetActivities($_GET['S']);
} else {
    $_SESSION['ActivityAEActivities'] = GetActivities();
}

//if actvitiyID is in GET, get the activity with that specific value and make a session out of it
//if value is not valid return to activityAEView.php.
if (isset($_GET['ActivityId'])) {
    $activityAE->GetActivity();
}

//if the submit button is pressed, do the following things
if (isset($_POST['Submit'])) {
    $activityAE->AddActivity();
}

//change activity
if (isset($_POST['CASubmit'])) {
    $activityAE->ChangeActivity();
}

//small function for deleting an activity
if (isset($_POST['Delete'])) {
    $activityAE->DeleteActivity();
}

//if assign volunteer button is pressed, get the activity.
if (isset($_GET['ActID'])) {
    $_SESSION['ActvitiyVolunteers'] = CMS_ActivityVolunteer($_GET['ActID']);
}

//if a user is pressed, check if the user is already bound to the activity,
//if so delete the user from the list, if not add the user to the list.
if (isset($_POST['AssignVolunteerName'])) {
    $activityAE->AssignVolunteer();
}

?>

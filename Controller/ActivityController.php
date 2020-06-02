<?php
require_once '../DAL/ActivityDAL.php';


class GetActivity
{
  function GetActivity2(){
    //get all activities from the database belonging to the volunteer
    $activityArray = CMS_GetActivity($_SESSION['LoggedInUser']->VolunteerID);
    //make an array for all the days
    $dayList = array();

    //foreach activity from the database
    foreach ($activityArray as $tempActivity){
      //set a success meter on fail.
      //this success meter is set to success if the activity can be sorted in a day,
      //if the activivty can not be classified, the success stays on fail a new day is made.
      $sucessBool = false;

      //for every day in the daylist
      for ($i=0; $i < count($dayList); $i++) {
        //if the day is not empty
        if($dayList[$i] != NULL){
          //grab one activity from the daylist
          foreach ($dayList[$i] as $key) {
            //if the date corresponds with the date from the activity gotten from the database
            if (date("m-d-Y",strtotime($key->Time)) == date("m-d-Y",strtotime($tempActivity->Time))){
              //place the activity in that day
              array_push($dayList[$i], $tempActivity);
              //and set the success meter on success
              $sucessBool = true;
              //break out of the loop so only one activity of the day has to be checked
              break;
            }
            //break out of the loop to check for days
            break;
          }
        }
      }

      //check if the success meter is on Fail
      if($sucessBool == false){
        //empty an array
        $activityList = array();
        //put the activity in the activitylist
        array_push($activityList, $tempActivity);
        //put the activitylist in the daylist
        array_push($dayList, $activityList);
      }
    }
    $_SESSION['days'] = $dayList;
  }
}

function TestFunction2($array){
  echo '<pre>';
  print_r($array);
  echo '</pre>';
}
//            echo date("m-d-Y",strtotime($key[0]->Time)), "---", date("m-d-Y",strtotime($tempActivity->Time)),"###############";

?>

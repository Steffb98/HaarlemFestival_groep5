<?php

class ActivityModel
{
    private $activityId;
    private $description;
    private $time;
    private $location;
    private $amountOfVolunteers;
    private $volunteersRequired;

    public function __construct()
    {
        $arguments = func_get_args();
        $numberOfArguments = func_num_args();

        if (method_exists($this, $function = '__construct'.$numberOfArguments)) {
            call_user_func_array(array($this, $function), $arguments);
        }
    }

    function __construct6($tempActivityId, $description, $time, $location, $amountOfVolunteers, $volunteersRequired)
    {
        $this->activityId = $tempActivityId;
        $this->description = $description;
        $this->time = $time;
        $this->location = $location;
        $this->amountOfVolunteers = $amountOfVolunteers;
        $this->volunteersRequired = $volunteersRequired;
    }

    function __construct5($tempActivityId, $description, $time, $location, $amountOfVolunteers)
    {
        $this->activityId = $tempActivityId;
        $this->description = $description;
        $this->time = $time;
        $this->location = $location;
        $this->amountOfVolunteers = $amountOfVolunteers;
    }

    public function getActivityId()
    {
        return $this->activityId;
    }

    public function setActivityId($activityId)
    {
        $this->activityId = $activityId;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time)
    {
        $this->time = $time;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function getAmountOfVolunteers()
    {
        return $this->amountOfVolunteers;
    }

    public function setAmountOfVolunteers($amountOfVolunteers)
    {
        $this->amountOfVolunteers = $amountOfVolunteers;
    }

    public function getVolunteersRequired()
    {
        return $this->volunteersRequired;
    }

    public function setVolunteersRequired($volunteersRequired)
    {
        $this->volunteersRequired = $volunteersRequired;
    }


}

?>

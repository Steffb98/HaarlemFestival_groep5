<?php

class ActivityModel
{
    private $activityId;
    private $description;
    private $time;
    private $location;
    private $amountOfVolunteers;
    private $volunteersRequired;

    function __construct($tempActivityId, $description, $time, $location, $amountOfVolunteers, $volunteersRequired)
    {
        $this->activityId = $tempActivityId;
        $this->description = $description;
        $this->time = $time;
        $this->location = $location;
        $this->amountOfVolunteers = $amountOfVolunteers;
        $this->volunteersRequired = $volunteersRequired;
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

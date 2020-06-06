<?php

class VolunteerModel
{
    private $volunteerId;
    private $amountOfActivities;
    private $function;
    private $firstName;
    private $lastName;
    private $email;
    private $registerDate;

    public function __construct($volunteerId, $amountOfActivities, $function, $firstName, $lastName, $email, $registerDate)
    {
        $this->volunteerId = $volunteerId;
        $this->amountOfActivities = $amountOfActivities;
        $this->function = $function;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->registerDate = $registerDate;
    }

    public function getVolunteerId()
    {
        return $this->volunteerId;
    }

    public function setVolunteerId($volunteerId)
    {
        $this->volunteerId = $volunteerId;
    }

    public function getAmountOfActivities()
    {
        return $this->amountOfActivities;
    }

    public function setAmountOfActivities($amountOfActivities)
    {
        $this->amountOfActivities = $amountOfActivities;
    }

    public function getFunction()
    {
        return $this->function;
    }

    public function setFunction($function)
    {
        $this->function = $function;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getRegisterDate()
    {
        return $this->registerDate;
    }

    public function setRegisterDate($registerDate)
    {
        $this->registerDate = $registerDate;
    }


}

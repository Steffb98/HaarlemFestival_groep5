<?php
class UserModel
{
  private $firstName;
  private $lastName;
  private $email;
  private $password;
  private $registrationDate;
  private $userID;

  function __construct($firstName, $lastName, $email, $password, $registrationDate, $userID)
  {
      $this->firstName = $firstName;
      $this->lastName = $lastName;
      $this->email = $email;
      $this->password = $password;
      $this->RegistrationDate = $registrationDate;
      $this->userID = $userID;
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

  public function getPassword()
  {
      return $this->password;
  }

  public function setPassword($password)
  {
      $this->password = $password;
  }

  public function getRegistrationDate()
  {
      return $this->registrationDate;
  }

  public function setRegistrationDate($registrationDate)
  {
      $this->registrationDate = $registrationDate;
  }

  public function getUserID()
  {
      return $this->userID;
  }

  public function setUserID($userID)
  {
      $this->userID = $userID;
  }
}

 ?>

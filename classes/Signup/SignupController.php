<?php

declare(strict_types=1);

namespace App\Signup;

use Exception;

require __DIR__ . "/../../vendor/autoload.php";

class SignupController extends Signup
{
  # Properties
  private $username;
  private $pwd;
  private $pwdRepeat;
  private $email;

  # Methods

  /**
   * Constructor of the SignupController class
   */
  public function __construct($username, $pwd, $pwdRepeat, $email)
  {
    $this->username = $username;
    $this->pwd = $pwd;
    $this->pwdRepeat = $pwdRepeat;
    $this->email = $email;
  }

  /**
   * Get data assigned to this class
   * 
   * @return array
   */
  public function getAssignedData(): array
  {
    return get_object_vars($this);
  }

  /**
   * Signs up the current user provided. Returns an array with the post request status and a feedback message.
   * 
   * @return array
   */
  public function signupUser(): array
  {
    if ($this->emptyInputSignup() === false) {
      // throw new Exception("Empty input at form");

      return ["status" => false, "message" => "Empty input at form"];
    }

    if (!$this->invalidUsername()) {
      // throw new Exception("Error invalid username: " . $this->username);

      return ["status" => false, "message" => "Error invalid username: " . $this->username];
    }

    if (!$this->invalidEmail()) {
      // throw new Exception("Error invalid email: " . $this->email);

      return ["status" => false, "message" => "Error invalid email: " . $this->email];
    }

    if (!$this->pwdMatch()) {
      // throw new Exception("Error passwords don't match");

      return ["status" => false, "message" => "Error passwords don't match"];
    }

    if ($this->usernameExists() === false) {
      // throw new Exception("Error username already exists");

      return ["status" => false, "message" => "Error user already exists"];
    }

    //* Insert user into database
    $this->setUser($this->username, $this->pwd, $this->email);

    //* Success message
    return ["status" => true, "message" => "User created"];
  }
  /**
   * Verifies if the data inserted is empty
   * 
   * @return bool
   */
  private function emptyInputSignup(): bool
  {
    switch (true) {
      case empty($this->username):
        return false;
        break;

      case empty($this->pwd):
        return false;
        break;

      case empty($this->pwdRepeat):
        return false;
        break;

      case empty($this->email):
        return false;
        break;

      default:
        return true;
        break;
    }
  }

  private function invalidUsername()
  {
    return preg_match("/^[a-zA-Z][a-zA-Z0-9_]{2,30}[a-zA-Z0-9]$/i", $this->username);
  }

  private function invalidEmail()
  {
    return filter_var($this->email, FILTER_VALIDATE_EMAIL);
  }

  private function pwdMatch()
  {
    return $this->pwd === $this->pwdRepeat ? true : false;
  }

  private function usernameExists()
  {
    return $this->checkUser($this->username, $this->email);
  }
}

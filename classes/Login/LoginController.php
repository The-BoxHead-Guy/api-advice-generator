<?php

declare(strict_types=1);

namespace App\Login;

require __DIR__ . "/../../vendor/autoload.php";

/**
 * Class `LoginController` is the controller for **Login** that manages user's input and then uses `Login` class to process it.
 */
class LoginController extends Login
{
  // public $test = "I'm working";

  private $email;
  private $pwd;

  /**
   * Constructs a new instance of the class.
   *
   * @param mixed $email The email of the user.
   * @param mixed $pwd The password of the user.
   */
  public function __construct($email, $pwd)
  {
    $this->email = $email;
    $this->pwd = $pwd;
  }

  /**
   * Check if the user login input is valid, then verify the user credentials and return the status and message accordingly.
   *
   * @return array Returns an array with the status and message based on the authentication result.
   */
  public function loginUser(): array
  {
    if ($this->emptyInputLogin()) {
      return ["status" => false, "message" => "fields seem to be empty"];
    }

    # Check if user exists and password is correct
    $userGettingStatus = $this->getUser($this->email, $this->pwd);

    # Sends JSON response
    return ["status" => $userGettingStatus["status"], "message" => $userGettingStatus["message"]];
  }

  /**
   * Verifies if the user's input entered is empty and returns a boolean value accordingly.
   * 
   * @return boolean Returns `true` if the user's input is empty, `false` otherwise.
   */
  private function emptyInputLogin()
  {
    match (true) {
      empty($this->email) => true,
      empty($this->pwd) => true,
      default => false
    };
  }
}

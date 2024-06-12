<?php

declare(strict_types=1);

namespace App\Signup;

use App\Database\DBHandler;

require __DIR__ . "/../../vendor/autoload.php";

class Signup extends DBHandler
{
  /**
   * Checks if a user exists in the database based on their UID or email.
   *
   * @param string $uid The UID of the user to check.
   * @param string $email The email of the user to check.
   * @return bool|null Returns true if the user does not exist, false if the user exists, and null if there was an error executing the query.
   */
  protected function checkUser($uid, $email)
  {
    $resultCheck = null;

    $stmt = $this->connect()->prepare(
      "SELECT username FROM users WHERE username = ? OR email = ?;"
    );

    if (!$stmt->execute([$uid, $email])) {
      $stmt = null;
      header("location: ../../Signup.php?error=stmtfailed");
      exit();
    }

    if ($stmt->rowCount() > 0) {
      $resultCheck = false;
    } else {
      $resultCheck = true;
    }

    return $resultCheck;
  }

  /**
   * Inserts a new user into the database.
   *
   * @param string $uid The user's unique identifier.
   * @param string $pwd The user's password.
   * @param string $email The user's email.
   * @throws PDOException If there is an error executing the SQL statement.
   * @return void
   */
  protected function setUser($uid, $pwd, $email)
  {
    $stmt = $this->connect()->prepare(
      "INSERT INTO users (username, email, pwd) VALUES (?, ?, ?);"
    );

    # Hashing the password for better security
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    if (!$stmt->execute([$uid, $email, $hashedPwd])) {
      $stmt = null;

      return false;
    }

    $stmt = null;
  }
}

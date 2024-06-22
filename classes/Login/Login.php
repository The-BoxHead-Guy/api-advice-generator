<?php

declare(strict_types=1);

namespace App\Login;

require __DIR__ . "/../../vendor/autoload.php";

use App\Database\DBHandler;
use App\Jwt\AuthJWT;
use PDO;

/**
 * Login class for handling user login.
 */
class Login extends DBHandler
{
  /**
   * Retrieves user information based on email and password.
   *
   * @param string $email The email of the user.
   * @param string $pwd The password of the user.
   * @return array Returns an array with status and message based on the authentication result.
   */
  protected function getUser(string $email, string $pwd): array
  {
    $query = "SELECT pwd FROM users WHERE email LIKE :email;";

    $stmt = $this->connect()->prepare($query);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);

    # If query execute doesn't succeed, it returns false
    if (!$stmt->execute()) {
      $stmt = null;

      return ["status" => false, "message" => "Something went wrong, please try again later."];
    }

    if (!$stmt->rowCount()) {
      $stmt = null;

      return ["status" => false, "message" => "User doesn't exist."];
    }

    $hashedPassword = $stmt->fetch(PDO::FETCH_ASSOC);
    $checkedPassword = password_verify($pwd, $hashedPassword["pwd"]);

    if (!$checkedPassword) {
      return ["status" => false, "message" => "Incorrect password."];
    } else if ($checkedPassword) {
      $query = "SELECT * FROM users WHERE email LIKE :email AND pwd = :pwd;";

      $stmt = $this->connect()->prepare($query);
      $stmt->bindParam(":email", $email, PDO::PARAM_STR);
      $stmt->bindParam(":pwd", $hashedPassword["pwd"], PDO::PARAM_STR);

      if (!$stmt->execute()) {
        $stmt = null;

        return ["status" => false, "message" => "Something went wrong, please try again later."];
      }

      if (!$stmt->rowCount()) {
        $stmt = null;

        return ["status" => false, "message" => "Password doesn't match."];
      }

      $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $_SESSION["userid"] = $user[0]["id"];
      $_SESSION["useruid"] = $user[0]["username"];
      $_SESSION["role"] = $user[0]["role"];

      # Create JWT
      $jwtKey = AuthJWT::setJWT($_SESSION["userid"], $_SESSION["useruid"], $_SESSION["role"]);

      return ["status" => true, "message" => "Login successful.", "jwt" => $jwtKey];
    }
  }
}

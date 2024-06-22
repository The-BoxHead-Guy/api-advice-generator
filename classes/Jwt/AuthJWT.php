<?php

declare(strict_types=1);

namespace App\Jwt;

use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require __DIR__ . "/../../vendor/autoload.php";

class AuthJWT
{
  const ENCRYPTION_ALGORITHM = 'HS256';

  /**
   * Load .env variables and save them in $_ENV
   */
  private static function loadENV(): void
  {
    $dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
    $dotenv->load();

    $dotenv->required("JWT_DEFAULT_SIGNATURE")->notEmpty();
  }

  /**
   * Generates a JSON Web Token (JWT) with the given user ID, username, and role.
   *
   * @param string $userid The ID of the user.
   * @param string $username The username of the user.
   * @return string The generated JWT.
   */
  public static function setJWT($userid, $username, $role): string
  {
    self::loadENV();

    $key = $_ENV["JWT_DEFAULT_SIGNATURE"];

    $payload = [
      "userid" => $userid,
      "username" => $username,
      "role" => $role,
    ];

    return JWT::encode($payload, $key, self::ENCRYPTION_ALGORITHM);
  }

  /**
   * Decode the JWT token using the provided token and return the decoded data as an array.
   *
   * @param string $token The JWT token to decode
   * @return array The decoded JWT data
   */
  public static function decodeCurrentUser($token)
  {
    self::loadENV();

    $key = $_ENV["JWT_DEFAULT_SIGNATURE"];

    $decodedJwt = JWT::decode($token, new Key($key, self::ENCRYPTION_ALGORITHM));
    $decodedJwt = (array) $decodedJwt;

    return $decodedJwt;
  }
}

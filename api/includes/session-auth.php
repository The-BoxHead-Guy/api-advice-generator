<?php

/**
 * Endpoint that handles user's javascript request for JWT session authentication. 
 * Its purpose is to verify the JWT token credentials, validate the user and send back the user's information as JSON for later use.
 */

declare(strict_types=1);

use App\Json\JsonReqHandler;
use App\Jwt\AuthJWT;

require __DIR__ . "/../../vendor/autoload.php";

// Set CORS environment for API call
JsonReqHandler::setJsonHeaders("*");

# Getting app's request headers
$apiRequestHeaders = apache_request_headers();

if (isset($apiRequestHeaders["Authorization"])) {
  $token = $apiRequestHeaders["Authorization"];

  $data = AuthJWT::decodeCurrentUser($token);
  echo json_encode($data);
} else {
  echo json_encode(["error" => "No Authorization header provided"]);
}

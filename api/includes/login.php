<?php

declare(strict_types=1);

require __DIR__ . "/../../vendor/autoload.php";
// require __DIR__ . "/../../config.php";

use App\Login\LoginController;
use App\Json\JsonReqHandler;

# Request initialization
JsonReqHandler::setJsonHeaders("*");

# Getting JSON data from request
$data = JsonReqHandler::getPostData();

# Implementing user login if request exists.
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
  # Grabbing the data

  $email = $data["email"];
  $password = $data["password"];

  // echo json_encode(["email" => $email, "password" => $password]);

  # Instantiate SignupController
  $login = new LoginController($email, $password);

  # Error handling
  $loginStatus = $login->loginUser();

  # Sending JSON response to front-end for user login status
  if (!$loginStatus["status"]) {
    http_response_code(401);
    echo json_encode("Failed to login, " . $loginStatus["message"]);
    exit();
  } else {
    http_response_code(200);
    header("Status: $loginStatus[status]");
    echo json_encode($loginStatus["jwt-token"]);
  }

  # Destroys session if user couldn't login
  if (!$loginStatus) {
    session_unset();
    session_destroy();
  }
}

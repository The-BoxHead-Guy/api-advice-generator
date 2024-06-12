<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Json\JsonReqHandler;
use App\Signup\SignupController;

# Request initialization
JsonReqHandler::setJsonHeaders("*");

# Get JSON data from Request and saving it in variable for further use
$data = JsonReqHandler::getPostData();

# Handling POST request
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {

  # Assigning data to variables
  $username = $data["name"];
  $email = $data["email"];
  $password = $data["password"];
  $passwordRepeat = $data["password-repeat"];

  # Instantiate SignupController
  $signup = new SignupController($username, $password, $passwordRepeat, $email);

  # Error handling
  $signupStatus = $signup->signupUser();

  //todo: Manage status code of response using JsonReqHandler
  JsonReqHandler::displayResponseStatus($signupStatus);
} else {
  echo json_encode(["message" => "Signup failed"]);
}

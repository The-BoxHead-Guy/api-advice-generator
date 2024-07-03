<?php

declare(strict_types=1);

use App\Crud\DeleteController;
use App\Crud\ReadView;
use App\Crud\UpdateController;
use App\Json\JsonReqHandler;

require_once __DIR__ . "/../../vendor/autoload.php";

# Request Initialization
JsonReqHandler::setJsonHeaders("*");

# Request Request Data
$data = JsonReqHandler::getPostData();

# Checking what kind of request was made
$httpMethodBool =
  [
    "PUT" => $_SERVER["REQUEST_METHOD"] === "PUT" ? true : false,
    "POST" => $_SERVER["REQUEST_METHOD"] === "POST" ? true : false,
    "DELETE" => $_SERVER["REQUEST_METHOD"] === "DELETE" ? true : false,
    "GET" => $_SERVER["REQUEST_METHOD"] === "GET" ? true : false
  ];

# Setting up the CRUD different routes

# GET => Get all records from the database
if (isset($_SERVER["REQUEST_METHOD"])) {

  switch (true) {
      # Handling GET request to perform app data retrieval
    case $httpMethodBool["GET"]:
      $adviceView = new ReadView();

      try {
        $adviceView->sendDataAsJson();
      } catch (Exception $e) {
        die("Error at 'getAdvice': " . $e->getMessage());
      }

      break;

      # Handling PUT request to perform data updates from app.
    case $httpMethodBool["PUT"]:

      $updateDB = new UpdateController($data["id"], $data["text"]);
      $updateStatus = $updateDB->update();

      # Echoing JSON response
      echo json_encode($updateStatus);

      break;

      # Handling DELETE request to perform data deletion from app.
    case $httpMethodBool["DELETE"]:

      $deleteAdvice = new DeleteController($data["id"]);
      $deleteStatus = $deleteAdvice->delete();

      # Echoing JSON response
      echo json_encode($deleteStatus);

      break;

      # Handling POST request to perform data insertion from app.
    case $httpMethodBool["POST"]:
      echo json_encode("POST activated");
      break;


    default:
      echo json_encode("Method not allowed");
      break;
  }
}

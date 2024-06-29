<?php

declare(strict_types=1);

use App\Crud\ReadView;
use App\Json\JsonReqHandler;

require_once __DIR__ . "/../../vendor/autoload.php";

# Request Initialization
JsonReqHandler::setJsonHeaders("*");

# Getting app's request headers
$apiRequestHeaders = apache_request_headers();

# Setting up the CRUD different routes

# GET => Get all records from the database
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "GET") {
  $adviceView = new ReadView();

  try {
    $adviceView->sendDataAsJson();
  } catch (Exception $e) {
    die("Error at 'getAdvice': " . $e->getMessage());
  }
}

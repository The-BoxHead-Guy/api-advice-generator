<?php

declare(strict_types=1);

namespace App\Json;

require __DIR__ . '/../../vendor/autoload.php';

use Exception;

class JsonReqHandler
{
  /**
   * Generates headers to convert the response to JSON readable format for front-end consumption.
   * 
   * @return void
   */
  public static function setJsonHeaders(string $url): void
  {
    header("Access-Control-Allow-Origin: " . $url);
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, POST, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
  }

  /**
   * Get input raw data as string in order to be able to convert it to an associative array for later using
   * 
   * @return array
   */
  public static function getPostData()
  {
    try {
      # get file content as a string
      $content = file_get_contents('php://input');

      # convert the string to an associative array
      $data = json_decode($content, true);

      # Verifies if the data is actually an array
      if (!is_array($data)) {
        throw new Exception('Data is not an array');
      }

      return $data;
    } catch (Exception $e) {
      return "Error: " . $e->getMessage();
    }
  }

  public static function displayResponseStatus(array $status): void
  {
    if ($status["status"]) {
      http_response_code(200);
      echo json_encode([$status["message"]]);
    } else {
      http_response_code(412);
      echo json_encode([$status["message"]]);
    }
  }

  public static function displayResponseStatusLogin(array $status): void
  {
    if ($status["status"]) {
      http_response_code(200);
      echo json_encode($_SESSION);
    } else {
      http_response_code(400);
      echo json_encode($status["message"]);
    }
  }
}

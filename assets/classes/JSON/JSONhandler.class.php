<?php

declare(strict_types=1);

namespace JSON;

class JSONhandler
{
  public static function encode(array $data): string
  {
    return json_encode($data);
  }

  public static function display_api_data($http_request_method, $data)
  {
    if ($http_request_method === "GET") {
      # Set the content type
      header("Content-Type: application/json");
      # CORS management
      header("Access-Control-Allow-Origin: http://127.0.0.1:5500");

      # Preparing advice for API call
      echo self::encode($data);
      exit;
    } else {
      header("HTTP/1.1 405 Method Not Allowed");
      exit;
    }
  }
}

<?php

declare(strict_types=1);

function fetch_pieces_of_advice(string $http_request): array
{
  if ($http_request === "GET") {
    try {
      # Establishing the connection with the DataBase "pieces_of_advices"
      require_once __DIR__ . "/include/db-handler.php";

      $query = "SELECT * 
      FROM list_of_advices;";

      $stmt = $pdo->prepare($query);

      $stmt->execute();

      return $pieces_of_advice = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      die("Can't fetch pieces of advice: " . $e->getMessage());
    }
  }
}

# Getting pieces of advice from DataBase and saving them into a variable.
$pieces_of_advice = fetch_pieces_of_advice($_SERVER["REQUEST_METHOD"]);

# Getting the random advice after selection
function get_random_advice(array $pieces_of_advice)
{
  return $pieces_of_advice[array_rand($pieces_of_advice)];
}

# Executing the random advice function
$advice = get_random_advice($pieces_of_advice);

# Setting the default advice ID
function set_id(array $advice): int
{
  return (int) $advice["advice_id"];
}

# Setting the default advice text
function set_text(array $advice): string
{
  return (string) $advice["advice_text"];
}

# Returning the advice as JSON encoding for API call
function return_advice_as_json(array $advice): string
{
  return json_encode($advice);
}

# Handling the GET request for the advice
if ($_SERVER["REQUEST_METHOD"] === "GET") {

  # Set the content type
  header("Content-Type: application/json");
  # CORS management
  header("Access-Control-Allow-Origin: http://127.0.0.1:5500");

  # Preparing advice for API call
  echo return_advice_as_json($advice);
  exit;
} else {
  header("HTTP/1.1 405 Method Not Allowed");
  exit;
}

<?php

declare(strict_types=1);

require_once "pieces-of-advice.php";

# Getting the random advice after selection
function get_random_advice(array $pieces_of_advice)
{
  return $pieces_of_advice[array_rand($pieces_of_advice)];
}

# Setting the random advice  variable
$advice = get_random_advice($pieces_of_advice);

# Setting the advice ID
function set_id(array $advice): int
{
  return $advice["id"];
}

# Setting the advice text
function set_text(array $advice): string
{
  return $advice["advice"];
}


# Returning the advice as JSON encoding for API call
function return_advice_as_json(array $advice): string
{
  return json_encode($advice);
}

# Handling the GET request for the advice
if ($_SERVER["REQUEST_METHOD"] === "GET") {
  $id = $_GET["q"] ?? null;

  if ($id) {
    header("Content-Type: application/json");
    echo return_advice_as_json($advice);
    exit;
  }
} else {
  header("HTTP/1.1 405 Method Not Allowed");
  exit;
}

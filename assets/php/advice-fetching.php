<?php

declare(strict_types=1);

# Creating the data for advice generator in an array
//todo: Save all the pieces of advice in a different file, and make the array as a CONST variable
$pieces_of_advice = [
  [
    "id" => 1,
    "advice" => "It is easy to sit up and take notice, what's difficult is getting up and taking action."
  ],
  [
    "id" => 2,
    "advice" => "The best way to make a permanent change is to break the habit that's keeping you from it."
  ],
  [
    "id" => 3,
    "advice" => "The biggest risk is not taking any risk at all."
  ],
  [
    "id" => 4,
    "advice" => "The most important thing is to enjoy what you're doing."
  ],
  [
    "id" => 5,
    "advice" => "The opposite of courage is not weakness, it's fear."
  ],
  [
    "id" => 6,
    "advice" => "The only thing that interferes with our learning is our fear of not knowing."
  ],
  [
    "id" => 7,
    "advice" => "The only way to do great work is to love what you do."
  ],
  [
    "id" => 8,
    "advice" => "The only way to make progress is to take action."
  ],
  [
    "id" => 9,
    "advice" => "The only way to make things better is to change them."
  ],
];

# Getting the random advice after selection
function get_random_advice(array $pieces_of_advice): array
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
}

<?php

# Import default data to the database, it's used in case the database is empty
# WARNING: This function it's used manually, it's not automated yet.

declare(strict_types=1);

require_once __DIR__ . "/default-advice.php";

# Establishing the data into the database
function establish_data(string $http_request, array $pieces_of_advice = [])
{
  if ($http_request === "GET") {
    foreach ($pieces_of_advice as $advice) {
      # Setting variables from the main array
      $id = $advice["id"];
      $advice = $advice["advice"];

      # Connecting to the database
      try {
        require_once __DIR__ . "/include/db-handler.php";

        # Creating a "SELECT" query in order to check if the advice already exists
        $search_query = "SELECT advice_id FROM list_of_advices
        WHERE advice_id = :id;";

        $stmt = $pdo->prepare($search_query);

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        # Inserting data if the advice doesn't exist
        if ($results[0]["advice_id"] === (int) $id) {
          continue;
        } else {
          $query = "INSERT INTO list_of_advices (advice_id, advice_text) VALUES (:id, :advice);";

          $stmt = $pdo->prepare($query);

          $stmt->bindParam(":id", $id);
          $stmt->bindParam(":advice", $advice);

          $stmt->execute();

          $stmt = null;
          $pdo = null;
        }
      } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
      }
    }
  }
}

# Executing the function
establish_data($_SERVER['REQUEST_METHOD'], $pieces_of_advice);

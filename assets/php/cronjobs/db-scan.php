<?php

declare(strict_types=1);

require_once __DIR__ . "/../default-advice.php";
require_once __DIR__ . "/../include/db-handler.php";

// FUNCTION EXECUTIONS

//* Extracting the amount of data from the DB
$data_amount = get_data_amount($pdo);

//* Saving all the already advice texts existent in the DB
$list_advice_texts = get_advice_text_list($pdo);
/* foreach ($list_advice_texts as $key => $text) {
  # code...
  echo "ID " . ($key + 1) . ": " . $text["advice_text"] . "\n";
} */

//* Executing the data insertion into the database
insert_data($pdo, $data_amount, $pieces_of_advices, $list_advice_texts);

// FUNCTION DECLARATIONS

# Checking how much data it's already in the DB
function get_data_amount($pdo): int
{
  try {
    $query = "SELECT COUNT(*) AS data_amount FROM list_of_advices;";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $data_amount = $stmt->fetchColumn();

    return $data_amount;
  } catch (PDOException $e) {
    die("Can't get data amount: " . $e->getMessage());
  }
}

# Verifying if "advice_text" has been already inserted into the DB
function verify_advice_text(string $str, array $text_list)
{
  $text_is_equal = false;

  foreach ($text_list as $key => $text) {
    /* echo "text: " . $text["advice_text"] . "\n";
    echo "str: " . $str . "\n"; */

    if ($text["advice_text"] === $str) {
      $text_is_equal = true;
    }
  }

  if ($text_is_equal) {
    return false;
  } else {
    return true;
  }
}

# Checking if the data it's already in the database
function insert_data($pdo, $data_amount, $pieces_of_advices, $list_advice_texts)
{
  $start = $data_amount + 1;
  $end = $start + 1;
  $amount_of_data_inserted = 0;

  for ($i = $start; $i < $end; $i++) {
    $query = "INSERT INTO list_of_advices (advice_text)
    VALUES (:advice);";

    # Verifying if there's more data available to insert into
    if ($i > (count($pieces_of_advices) - 1)) {
      log_cronjob($amount_of_data_inserted);
      die("\nNo more data to insert into the database");
    } else {
      $advice = $pieces_of_advices[$i]["advice"];

      if (verify_advice_text($advice, $list_advice_texts)) {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":advice", $advice);

        $stmt->execute();

        echo "\nData with ID: \"$i\" inserted succesfully";

        $amount_of_data_inserted++;
      } else {
        continue;
      }
    }
  }

  log_cronjob($amount_of_data_inserted);
}

# Gets all the advice texts and returns all the fetched results
function get_advice_text_list($pdo)
{
  $query = "SELECT advice_text FROM list_of_advices;";

  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $results = $stmt->fetchAll();

  return $results;
}

# Logging the data insertion after CRON job
function log_cronjob($data_inserted)
{
  # Sets Venezuela 🇻🇪 timezone
  //! Originally, it's GMT-4, but due to PHP timezone issues, it's GMT+4
  date_default_timezone_set("Etc/GMT+4");

  # Gets the current date and time when the script it's executed
  $today = date("F j, Y, g:i a");

  # Opens the log file
  $log = fopen(__DIR__ . "/db-scan.log", "a");

  # Writes the status in the log after succesful data insertion
  if ($data_inserted > 0) {
    fwrite(
      $log,
      "Script executed at: " . $today . "\n" . "Data inserted: $data_inserted" . "\n\n"
    );
  } else {
    fwrite(
      $log,
      "Script executed at: " . $today .
        "\n" .
        "No data inserted, please add more information to be inserted into the database" .
        "\n\n"
    );
  }

  fclose($log);

  echo "\nLog created successfully";
}

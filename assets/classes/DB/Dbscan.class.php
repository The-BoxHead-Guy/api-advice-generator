<?php

declare(strict_types=1);

namespace DB;

use PDOException;
use PDO;
use Cron\CreateLog;

/**
 * Performs several operations of INSERTION, SCANNING, and COUNTING of data. Finally, it returns the amount of data inserted for log file update in CRON folder
 * 
 */

class Dbscan extends Dbhandler
{
  # PROPERTIES
  private const TABLE_NAME = "list_of_advices";
  private const COLUMN_NAME = "advice_text";

  private $dataAmount;

  # METHODS

  /**
   * * Count data amount in table depending on how many pieces of advices are existent in the DB
   * 
   * @return int
   */
  private function count_data(): int
  {
    try {
      $query = "SELECT COUNT(*) AS data_amount
      FROM " . self::TABLE_NAME;

      $stmt = $this->connect()->prepare($query);
      $stmt->execute();

      $output = $stmt->fetchColumn();

      return $output;
    } catch (PDOException $e) {
      die("Can't get data amount: " . $e->getMessage());
    }
  }

  /**
   * * Get ONLY the text of all the pieces of advices
   * 
   * @return array
   */
  public function get_advice_text(): array
  {
    try {
      $query = "SELECT " . self::COLUMN_NAME . " FROM " . self::TABLE_NAME;

      $stmt = $this->connect()->prepare($query);
      $stmt->execute();
      $results = $stmt->fetchAll();

      return $results;
    } catch (PDOException $e) {
      die("Can't get texts from 'list_of_advices': " . $e->getMessage());
    }
  }

  /**
   * * Verify if the advice text is already in the DB
   * 
   * @param string
   * @param array
   * @return bool
   */
  private function verify_advice_text(string $advice, array $list): bool
  {
    $text_is_equal = false;

    foreach ($list as $key => $text) {
      /* echo "text to compare: " . $text["advice_text"] . " at key: " . $key . PHP_EOL;
      echo "advice text: " . $advice . "\n"; */

      if ($text["advice_text"] === $advice) {
        $text_is_equal = true;
      }
    }

    if ($text_is_equal) {
      return false;
    } else {
      return true;
    }
  }

  /**
   * * INSERT data INTO DB
   * 
   * @param array
   * @return void
   */
  public function insert_data(array $list, array $dbList): void
  {
    $start = $this->dataAmount;
    $end = $start + 2;
    $amount_of_data_inserted = 0;

    for ($i = $start; $i < $end; $i++) {
      # Prepare query
      $query = "INSERT INTO " . self::TABLE_NAME . " (" . self::COLUMN_NAME . ") VALUES (:advice)";

      if ($i > (count($list) - 1)) {
        CreateLog::set_inserted_data($amount_of_data_inserted);
        CreateLog::log_cronjob();
        die("No more data to insert...");
      } else {

        # Setting the element to be inserted
        $advice = $list[$i]["advice"];

        if ($this->verify_advice_text($advice, $dbList)) {

          $stmt = $this->connect()->prepare($query);
          $stmt->bindParam(":advice", $advice, PDO::PARAM_STR);
          $stmt->execute();

          error_log("Data of ID: " . ($i + 1) . " inserted successfully." . PHP_EOL);

          $amount_of_data_inserted++;
        } else {
          CreateLog::notify_advice_repetition($i, $advice);
          die("Caught an exception at $i: " . $advice . " already exists in DB." . PHP_EOL);
        }
      }
    }

    # Returns the amount of data inserted for log file update in CRON job
    CreateLog::set_inserted_data($amount_of_data_inserted);
    CreateLog::log_cronjob();
  }

  # SETTERS
  private function set_data_amount(): void
  {
    $data = $this->count_data();
    $this->dataAmount = $data;
  }

  # GETTERS
  public function get_data_amount(): int
  {
    $this->set_data_amount();
    return $this->dataAmount;
  }
}

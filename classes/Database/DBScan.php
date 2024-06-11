<?php

declare(strict_types=1);

namespace App\Database;

use PDOException;
use PDO;
use App\Cron\CreateLog;

/**
 * Performs several operations of INSERTION, SCANNING, and COUNTING of data. Finally, it returns the amount of data inserted for log file update in CRON folder
 * 
 */

class DBScan extends DBHandler
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
   */
  private function verify_advice_text(string $advice, array $dbList): bool
  {
    foreach ($dbList as $key => $text) {
      /* echo "text to compare: " . $text["advice_text"] . " at key: " . $key . PHP_EOL;
      echo "advice text: " . $advice . "\n"; */

      if (strtolower($text["advice_text"]) === strtolower($advice)) {
        # Returns true if match is found
        return true;
      } else {
        # skips to next element if no match is found
        continue;
      }
    }

    # Returns false if no match among all data was found
    return false;
  }

  /**
   * * INSERT data INTO DB
   */
  public function insert_data(string $advice, array $dbList): void
  {
    /**
     * testing purposes
     * 
     * echo $text["advice_text"] . PHP_EOL;
     * echo $advice . PHP_EOL;
     */

    if (!$this->verify_advice_text($advice, $dbList)) {
      # Prepare query
      $query = "INSERT INTO " . self::TABLE_NAME . " (" . self::COLUMN_NAME . ") VALUES (:advice)";

      $stmt = $this->connect()->prepare($query);
      $stmt->bindParam(":advice", $advice, PDO::PARAM_STR);
      $stmt->execute();

      error_log("Text: \"" . $advice . "\" has been inserted successfully." . PHP_EOL);
      # Returns the amount of data inserted for log file update in CRON job
      CreateLog::log_cronjob(true, $advice);
    } else {
      CreateLog::log_cronjob(false, $advice);
    }
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

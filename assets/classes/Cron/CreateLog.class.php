<?php

declare(strict_types=1);

namespace Cron;

/**
 * * Represents the log creation after a CRON script it's executed
 */

class CreateLog
{
  private static $inserted_data = 0;
  # Gets the current date and time when the script it's executed

  private static $path = "/../../cronjobs/db-scan.log";
  private static $date_format = "F j, Y, g:i a";

  /**
   * * Gets inserted data as INT in order to set $this->inserted_data
   * 
   * @param int 
   * @return void
   */
  public static function set_inserted_data(int $amount): void
  {
    self::$inserted_data = $amount;
  }

  /**
   * * Creates log file with the current date and time and the status of the script
   *
   * @param int
   * @return void
   */
  public static function log_cronjob(): void
  {
    # Sets Venezuela 🇻🇪 timezone
    date_default_timezone_set("Etc/GMT+4");

    $today = date(self::$date_format);

    # Opens the log file
    $log = fopen(__DIR__ . self::$path, "a");

    # Writes the status in the log after succesful data insertion
    if (self::$inserted_data > 0) {
      fwrite(
        $log,
        "Script executed at: " . $today . "\n" . "Data inserted: " . self::$inserted_data . "\n\n"
      );
    } else {
      fwrite(
        $log,
        "Script executed at: " . $today .
          "\n" .
          "No data inserted, please add more information to be inserted into the database" . "\n\n"
      );
    }

    fclose($log);

    echo "Log created successfully" . PHP_EOL;
  }

  /**
   * * Notify which file has to be deleted due to its repetition
   * 
   * @param string
   * @return void
   */
  public static function notify_advice_repetition(int $advice_id, string $advice)
  {
    $today = date(self::$date_format);

    # Opens the log file
    $log = fopen(__DIR__ . self::$path, "a");

    # Writes the status in the log after succesful data insertion
    fwrite(
      $log,
      "\nScript executed at: " . $today . "\n" . "Id: " . $advice_id . " whose text is: \"" . $advice . "\" has to be deleted. Cause: repetition" . "\n\n"
    );

    fclose($log);

    echo "Error Log created successfully" . PHP_EOL;
  }
}

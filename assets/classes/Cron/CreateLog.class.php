<?php

declare(strict_types=1);

namespace Cron;

/**
 * * Represents the log creation after a CRON script it's executed
 */

class CreateLog
{
  private static $path = "/../../cronjobs/db-scan.log";
  private static $date_format = "F j, Y, g:i a";

  /**
   * * Creates log file with the current date and time and the status of the script
   *
   * @return void
   */
  public static function log_cronjob(bool $status, string $textData): void
  {
    # Sets Venezuela 🇻🇪 timezone
    date_default_timezone_set("Etc/GMT+4");

    $today = date(self::$date_format);

    # Opens the log file
    $log = fopen(__DIR__ . self::$path, "a");

    # Writes the status in the log after succesful data insertion
    if ($status) {
      fwrite(
        $log,
        "Script executed at: " . $today . "\n" . "Data inserted: \"" . $textData . "\"" . "\n\n"
      );
    } else {
      fwrite(
        $log,
        "Script executed at: " . $today .
          "\n" .
          "Repetition of advice caught: \"" . $textData . "\" already exists in DB." . "\n\n"
      );
    }

    fclose($log);

    echo "Log created successfully" . PHP_EOL;
  }
}

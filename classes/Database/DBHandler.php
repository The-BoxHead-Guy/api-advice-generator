<?php

declare(strict_types=1);

namespace App\Database;

use Dotenv\Dotenv;
use PDO;
use PDOException;

require __DIR__ . "/../../vendor/autoload.php";

class DBHandler
{
  # Reusable constants
  protected const TABLE_NAME = "list_of_advices";
  protected const COL_ADVICE_TEXT = "advice_text";
  protected const ID = "advice_id";

  # Reusable variables
  private $dsn;
  private $username;
  private $password;

  /**
   * Sets the database connection parameters and establishes the connection.
   * 
   * This function uses `setDatabaseData()` to firstly set the needed credentials and then performs the database connection.
   * 
   * @return PDO
   */
  protected function connect(): PDO
  {
    try {
      $this->setDatabaseData();

      $pdo = new PDO($this->dsn, $this->username, $this->password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // echo "Connection established: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . "\n";

      return $pdo;
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }

  /**
   * Sets the database connection parameters from the environment variables.
   *
   * This function loads the environment variables using the Dotenv library and
   * assigns the values to the class properties `$dsn`, `$username`, and `$password`.
   *
   * @return void
   */
  private function setDatabaseData(): void
  {
    $dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
    $dotenv->load();

    $this->dsn = $_ENV["DB_DSN"];
    $this->username = $_ENV["DB_USERNAME"];
    $this->password = $_ENV["DB_PASSWORD"];
  }
}

<?php

declare(strict_types=1);

namespace DB;

use PDO;
use PDOException;

require_once __DIR__ . "/../../includes/autoload.inc.php";

class Dbhandler
{
  # Setting up the connection's parameters
  private const DSN = "mysql:host=localhost;dbname=pieces_of_advices";
  private const USERNAME = "root";
  private const PASSWORD = "Onix-DB";

  # Establishing the connection using 'PDO'
  protected function connect(): PDO
  {
    try {
      $pdo = new PDO(self::DSN, self::USERNAME, self::PASSWORD);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // echo "Connection established: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . "\n";

      return $pdo;
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }
}

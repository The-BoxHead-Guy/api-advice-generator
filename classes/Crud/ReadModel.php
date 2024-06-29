<?php

declare(strict_types=1);

namespace App\Crud;

use App\Database\DBHandler;
use PDOException;
use PDO;

require __DIR__ . "/../../vendor/autoload.php";

class ReadModel extends DBHandler
{
  protected const TABLE = "list_of_advices";
  protected const ID = "advice_id";

  protected function getAllData()
  {
    try {
      $query = "SELECT * FROM " . self::TABLE . " ORDER BY " . self::ID . " ASC";

      $stmt = $this->connect()->prepare($query);
      $stmt->execute();

      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return $data;
    } catch (PDOException $e) {
      die("Can't get data from 'list_of_advices': " . $e->getMessage());
    }
  }
}

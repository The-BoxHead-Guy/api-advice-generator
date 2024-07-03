<?php

/**
 * This class is in charge of taking admin's delete action and delete the defined
 * data in the database
 */

declare(strict_types=1);

namespace App\Crud;

use App\Database\DBHandler;
use PDOException;
use PDO;

require __DIR__ . "/../../vendor/autoload.php";

class DeleteModel extends DBHandler
{

  # Properties
  protected $adviceId;

  protected function __construct(int $adviceId)
  {
    $this->adviceId = $adviceId;
  }


  protected function implementDelete()
  {
    try {
      $query = "DELETE FROM " . parent::TABLE_NAME .
        " WHERE " . parent::ID . " = :advice_id;";

      $stmt = $this->connect()->prepare($query);

      # Binding named parameters
      $stmt->bindParam(':advice_id', $this->adviceId, PDO::PARAM_INT);

      if (!$stmt->execute()) {
        throw new PDOException("Can't find row: " . $stmt->errorInfo());
      }

      return true;
    } catch (PDOException $e) {
      die($e);
    }
  }
}

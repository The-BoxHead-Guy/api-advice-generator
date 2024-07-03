<?php

/**
 * This class is in charge of taking admin's update action and update the defined
 * data in the database
 */

declare(strict_types=1);

namespace App\Crud;

use App\Database\DBHandler;
use PDOException;
use PDO;

require __DIR__ . "/../../vendor/autoload.php";

/**
 * Accomplishes the **Database Update Query** and performs the update operation
 */
class UpdateModel extends DBHandler
{
  protected $newAdviceText;
  protected $adviceId;


  protected function __construct(int $adviceId, string $newAdviceText)
  {
    $this->adviceId = $adviceId;
    $this->newAdviceText = $newAdviceText;
  }

  /**
   * Updates a row in the database table with the new advice text.
   *
   * @throws PDOException If the row update fails.
   * @return bool Returns true if the row update is successful.
   */
  protected function implementUpdate()
  {
    try {
      $query = "UPDATE " . parent::TABLE_NAME . " 
                SET " . parent::COL_ADVICE_TEXT . " = :advice_text
                WHERE " . parent::ID . " = :advice_id";

      $stmt = $this->connect()->prepare($query);

      # Binding named parameters
      $stmt->bindParam(':advice_text', $this->newAdviceText);
      $stmt->bindParam(':advice_id', $this->adviceId);

      if (!$stmt->execute()) {
        throw new PDOException("Can't update row: " . $stmt->errorInfo());
      }

      return true;
    } catch (PDOException $e) {
      die($e);
    }
  }
}

<?php

declare(strict_types=1);

namespace App\Crud;

use App\Database\DBHandler;
use PDO;
use PDOException;

require __DIR__ . "/../../vendor/autoload.php";

class CreateModel extends DBHandler
{
  //? `?int $adviceId` can be used later to set specific pieces of advice
  private ?int $adviceId;
  private string $adviceText;

  protected function __construct(?int $adviceId, string $adviceText)
  {
    $this->adviceId = $adviceId;
    $this->adviceText = $adviceText;
  }

  protected function implementeAdviceCreation()
  {
    try {
      $query = "INSERT INTO " . parent::TABLE_NAME . " (" . parent::COL_ADVICE_TEXT . ") 
      VALUES (:adviceText);";

      $stmt = $this->connect()->prepare($query);
      $stmt->bindParam(':adviceText', $this->adviceText, PDO::PARAM_STR);

      if (!$stmt->execute()) {
        throw new PDOException("Error Processing Request", 1);
      }

      return true;
    } catch (PDOException $error) {
      die("Error at 'createAdvice': " . $error->getMessage());
    }
  }
}

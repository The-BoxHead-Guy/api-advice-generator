<?php

declare(strict_types=1);

namespace DB;

use DB\Dbhandler;
use Exception;
use PDO;

class FetchAdvices extends Dbhandler
{
  # Both id, and text of the advice saved in the database, selected randomly after method call
  private $advice_id;
  private $advice_text;

  # Get all pieces of advice from DB
  public function get_pieces_of_advices(): array
  {
    try {
      if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $query = "SELECT * 
        FROM list_of_advices;";

        $stmt = $this->connect()->prepare($query);
        $stmt->execute();

        $pieces_of_advices = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $pieces_of_advices;
      } else {
        throw new Exception("Can't fetch pieces of advices");
      }
    } catch (Exception $e) {
      die("Error at 'getPiecesOfAdvices': " . $e->getMessage());
    }
  }

  # Gets random advice from fetched data
  public function get_random_advice(array $data): array
  {
    return $data[array_rand($data)];
  }

  # Setters
  public function set_id(array $data): int
  {
    $this->advice_id = $data['advice_id'];
    return $this->advice_id;
  }
  public function set_text(array $data): string
  {
    $this->advice_text = $data['advice_text'];
    return $this->advice_text;
  }
}

<?php

declare(strict_types=1);

namespace App\Crud;

use App\Crud\ReadModel;

require __DIR__ . "/../../vendor/autoload.php";

class ReadView extends ReadModel
{
  private $piecesOfAdvices = [];
  private function getFetchedData()
  {
    $this->piecesOfAdvices = $this->getAllData();

    return $this->piecesOfAdvices;
  }

  public function sendDataAsJson()
  {
    $this->getFetchedData();

    $json = json_encode($this->piecesOfAdvices);
    echo $json;
  }
}

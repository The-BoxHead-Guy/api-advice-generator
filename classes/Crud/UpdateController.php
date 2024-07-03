<?php

namespace App\Crud;

use App\Crud\UpdateModel;

require __DIR__ . "/../../vendor/autoload.php";

class UpdateController extends UpdateModel
{
  function __construct($adviceId, $newAdviceText)
  {
    parent::__construct($adviceId, $newAdviceText);
  }

  public function update(): array
  {
    if ($this->implementUpdate()) {
      return ["success" => true];
    }
  }
}

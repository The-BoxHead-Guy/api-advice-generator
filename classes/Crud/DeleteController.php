<?php

namespace App\Crud;

use App\Crud\DeleteModel;

require __DIR__ . "/../../vendor/autoload.php";

class DeleteController extends DeleteModel
{
  function __construct($adviceId)
  {
    parent::__construct($adviceId);
  }

  public function delete(): array
  {
    if ($this->implementDelete()) {
      return ["success" => true];
    }
  }
}

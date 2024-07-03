<?php

declare(strict_types=1);

namespace App\Crud;

use App\Crud\CreateModel;
use Exception;

require __DIR__ . "/../../vendor/autoload.php";

class CreateController extends CreateModel
{
  public function __construct($id, string $newAdviceText)
  {
    parent::__construct($id, $newAdviceText);
  }

  public function createNewAdvice(): array
  {
    if (!$this->implementeAdviceCreation()) {
      throw new Exception("Couldn't create the new piece of advice", 1);
    }

    return ["status" => true];
  }
}

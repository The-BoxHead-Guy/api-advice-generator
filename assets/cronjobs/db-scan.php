<?php

declare(strict_types=1);

require_once __DIR__ . "/../data/default-advice.php";
require_once __DIR__ . "/../includes/autoload.inc.php";

use DB\Dbscan;

# Creating the database object connection for perform operations.
$DBscan = new Dbscan();

//* Saving all the already advice texts existent in the DB
$list_advice_texts = $DBscan->get_advice_text();
/* foreach ($list_advice_texts as $key => $text) {
  # code...
  echo "ID " . ($key + 1) . ": " . $text["advice_text"] . PHP_EOL;
} */

$data_amount = $DBscan->get_data_amount();
echo "Data amount: " . $data_amount . PHP_EOL;

# Inserting the data into the DB and logging it into the log file
$DBscan->insert_data($pieces_of_advices, $list_advice_texts);
